<?php
// =========================================
// Dashboard Controller (Employee)
// IntraCorp Portal (Vulnerable Edition)
// =========================================

require_once '../app/Core/BaseController.php';
require_once '../app/Models/UserModel.php';
require_once '../app/Models/AnnouncementModel.php';
require_once '../app/Models/TicketModel.php';

class DashboardController extends BaseController
{
    private $userModel;
    private $announcementModel;
    private $ticketModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireLogin();
        $this->userModel         = new UserModel();
        $this->announcementModel = new AnnouncementModel();
        $this->ticketModel       = new TicketModel();
    }

    // Employee dashboard
    public function index()
    {
        $userId        = $this->getCurrentUser()['id'];
        $user          = $this->userModel->getUserById($userId);
        $announcements = $this->announcementModel->getAllAnnouncements();
        $tickets       = $this->ticketModel->getTicketsByUser($userId);

        $this->view('dashboard/index', [
            'user'          => $user,
            'announcements' => $announcements,
            'tickets'       => $tickets,
        ]);
    }

    // View announcements
    public function announcements()
    {
        // Get search parameter
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Get filtered announcements
        $announcements = $this->announcementModel->getAllAnnouncements($search);

        $this->view('dashboard/announcements', [
            'announcements' => $announcements,
            'search'        => $search,
        ]);
    }

    // View profile
    public function profile()
    {
        $user = $this->userModel->getUserById($this->getCurrentUser()['id']);
        $this->view('dashboard/profile', ['user' => $user]);
    }

    // Edit profile
    public function editProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $this->getCurrentUser()['id'];

            $data = [
                'full_name'  => $_POST['full_name'],
                'email'      => $_POST['email'],
                'department' => $_POST['department'],
                'phone'      => $_POST['phone'],
            ];

            // Handle file upload (Vulnerable - no validation)
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $uploadDir = '../public/uploads/';
                if (! is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName   = $_FILES['photo']['name'];
                $uploadPath = $uploadDir . $fileName;

                // No file type validation - vulnerable
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
                $data['profile_picture'] = $fileName;
            }

            $this->userModel->updateProfile($userId, $data);
            $this->redirect('index.php?controller=dashboard&action=profile');
        }
    }

    // View tickets
    public function tickets()
    {
        // Get filter parameters
        $search   = isset($_GET['search']) ? $_GET['search'] : '';
        $status   = isset($_GET['status']) ? $_GET['status'] : '';
        $priority = isset($_GET['priority']) ? $_GET['priority'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Get all tickets with filters (not just user's tickets)
        $tickets = $this->ticketModel->getAllTicketsWithFilters($search, $status, $priority, $category);

        $this->view('dashboard/tickets', [
            'tickets' => $tickets,
            'filters' => [
                'search'   => $search,
                'status'   => $status,
                'priority' => $priority,
                'category' => $category,
            ],
        ]);
    }

    // View ticket detail
    public function viewTicket()
    {
        $ticketId = $_GET['id'] ?? 0;

        $ticket = $this->ticketModel->getTicketById($ticketId);

        // Allow all users to view all tickets
        if (! $ticket) {
            $this->redirect('index.php?controller=dashboard&action=tickets');
            return;
        }

        $comments = $this->ticketModel->getComments($ticketId);

        $this->view('dashboard/view_ticket', [
            'ticket'   => $ticket,
            'comments' => $comments,
        ]);
    }

    // Create ticket
    public function createTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $this->getCurrentUser()['id'];

            // Handle file upload (Vulnerable - no validation)
            $attachment = null;
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
                $uploadDir = '../public/uploads/tickets/';
                if (! is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName   = time() . '_' . $_FILES['attachment']['name'];
                $uploadPath = $uploadDir . $fileName;

                // No file type validation - vulnerable
                move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadPath);
                $attachment = $fileName;
            }

            $data = [
                'user_id'     => $userId,
                'subject'     => $_POST['subject'],
                'description' => $_POST['description'], // No XSS protection
                'priority'    => $_POST['priority'] ?? 'medium',
                'category'    => $_POST['category'] ?? 'other',
                'attachment'  => $attachment,
            ];

            $ticketId = $this->ticketModel->createTicket($data);
            $this->redirect('index.php?controller=dashboard&action=viewTicket&id=' . $ticketId);
        } else {
            $this->view('dashboard/create_ticket');
        }
    }

    // Add comment to ticket
    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticketId = $_POST['ticket_id'];
            $userId   = $this->getCurrentUser()['id'];
            $comment  = $_POST['comment']; // No XSS protection

            // Verify user owns this ticket
            $ticket = $this->ticketModel->getTicketById($ticketId);
            if ($ticket && $ticket['user_id'] == $userId) {
                $this->ticketModel->addComment($ticketId, $userId, $comment);
            }

            $this->redirect('index.php?controller=dashboard&action=viewTicket&id=' . $ticketId);
        }
    }

    // Close ticket
    public function closeTicket()
    {
        $ticketId = $_GET['id'] ?? 0;
        $userId   = $this->getCurrentUser()['id'];

        // Verify user owns this ticket
        $ticket = $this->ticketModel->getTicketById($ticketId);
        if ($ticket && $ticket['user_id'] == $userId) {
            $this->ticketModel->closeTicket($ticketId, $userId);
        }

        $this->redirect('index.php?controller=dashboard&action=viewTicket&id=' . $ticketId);
    }

    // Change password
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $this->getCurrentUser()['id'];
            $user   = $this->userModel->getUserById($userId);

            $currentPassword = $_POST['current_password'];
            $newPassword     = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Vulnerable: No password strength validation
            if ($user['password'] === $currentPassword) {
                if ($newPassword === $confirmPassword) {
                    $this->userModel->changePassword($userId, $newPassword);
                    $success = "Password berhasil diubah!";
                    $this->view('dashboard/change_password', ['success' => $success]);
                    return;
                } else {
                    $error = "Password baru dan konfirmasi tidak cocok!";
                }
            } else {
                $error = "Password lama salah!";
            }

            $this->view('dashboard/change_password', ['error' => $error]);
        } else {
            $this->view('dashboard/change_password');
        }
    }

}
