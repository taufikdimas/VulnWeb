<?php
// =========================================
// Admin Controller
// IntraCorp Portal (Vulnerable Edition)
// =========================================

require_once '../app/Core/BaseController.php';
require_once '../app/Models/UserModel.php';
require_once '../app/Models/AnnouncementModel.php';
require_once '../app/Models/TicketModel.php';

class AdminController extends BaseController
{
    private $userModel;
    private $announcementModel;
    private $ticketModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireLogin();
        $this->requireAdmin(); // Weak check - can be bypassed
        $this->userModel         = new UserModel();
        $this->announcementModel = new AnnouncementModel();
        $this->ticketModel       = new TicketModel();
    }

    // Admin dashboard
    public function dashboard()
    {
        // Get users ordered by last login (most recent first)
        $users         = $this->userModel->getUsersByLastLogin();
        $announcements = $this->announcementModel->getAllAnnouncements();
        $tickets       = $this->ticketModel->getAllTickets();

        $this->view('admin/dashboard', [
            'users'         => $users,
            'announcements' => $announcements,
            'tickets'       => $tickets,
        ]);
    }

    // Manage users
    public function users()
    {
        $users = $this->userModel->getAllUsers();

        // Apply filters
        if (! empty($_GET['search'])) {
            $search = $_GET['search'];
            $users  = array_filter($users, function ($user) use ($search) {
                return stripos($user['username'], $search) !== false ||
                stripos($user['email'], $search) !== false ||
                stripos($user['full_name'], $search) !== false;
            });
        }

        if (! empty($_GET['role'])) {
            $role  = $_GET['role'];
            $users = array_filter($users, function ($user) use ($role) {
                return $user['role'] == $role;
            });
        }

        if (! empty($_GET['department'])) {
            $department = $_GET['department'];
            $users      = array_filter($users, function ($user) use ($department) {
                return $user['department'] == $department;
            });
        }

        if (! empty($_GET['status'])) {
            $status = $_GET['status'];
            $users  = array_filter($users, function ($user) use ($status) {
                if ($status == 'active') {
                    return $user['is_active'] == 1;
                } else if ($status == 'suspended') {
                    return $user['is_active'] == 0;
                }
                return true;
            });
        }

        $this->view('admin/users', ['users' => $users]);
    }

    // Delete user (no CSRF protection)
    public function deleteUser()
    {
        $id = $_GET['id'];
        $this->userModel->deleteUser($id);
        $this->redirect('index.php?controller=admin&action=users');
    }

    // View user detail
    public function viewUser()
    {
        $id   = $_GET['id'];
        $user = $this->userModel->getUserById($id);
        $this->view('admin/view_user', ['user' => $user]);
    }

    // Edit user
    public function editUser()
    {
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username'   => $_POST['username'],
                'email'      => $_POST['email'],
                'full_name'  => $_POST['full_name'],
                'role'       => $_POST['role'],
                'department' => $_POST['department'],
                'phone'      => $_POST['phone'],
                'password'   => $_POST['password'],
                'is_active'  => isset($_POST['is_active']) ? 1 : 0,
            ];

            $this->userModel->updateUser($id, $data);
            $this->redirect('index.php?controller=admin&action=users');
        } else {
            $user = $this->userModel->getUserById($id);
            $this->view('admin/edit_user', ['user' => $user]);
        }
    }

    // Create new user
    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username'   => $_POST['username'],
                'email'      => $_POST['email'],
                'full_name'  => $_POST['full_name'],
                'role'       => $_POST['role'],
                'department' => $_POST['department'],
                'phone'      => $_POST['phone'] ?? '',
                'password'   => $_POST['password'],
                'is_active'  => isset($_POST['is_active']) ? 1 : 0,
            ];

            $this->userModel->createUser($data);
            $this->redirect('index.php?controller=admin&action=users');
        } else {
            $this->view('admin/create_user');
        }
    }

    // Manage announcements
    public function announcements()
    {
        // Get search parameter
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Get filtered announcements
        $announcements = $this->announcementModel->getAllAnnouncements($search);

        // Pass search and data to view
        $this->view('admin/announcements', [
            'announcements' => $announcements,
            'search'        => $search,
        ]);
    }

    // View announcement detail
    public function viewAnnouncement()
    {
        $id           = $_GET['id'];
        $announcement = $this->announcementModel->getAnnouncementById($id);
        $this->view('admin/view_announcement', ['announcement' => $announcement]);
    }

    // Create announcement
    public function createAnnouncement()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title     = $_POST['title'];
            $content   = $_POST['content']; // Vulnerable to XSS
            $createdBy = $this->getCurrentUser()['id'];

            // Handle file upload to database
            $attachmentName = null;
            $attachmentData = null;
            $attachmentMime = null;
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
                $attachmentName = $_FILES['attachment']['name'];
                $attachmentData = file_get_contents($_FILES['attachment']['tmp_name']);
                $attachmentMime = $_FILES['attachment']['type'];
            }

            $this->announcementModel->createAnnouncement($title, $content, $createdBy, $attachmentName, $attachmentData, $attachmentMime);
            $this->redirect('index.php?controller=admin&action=announcements');
        } else {
            $this->view('admin/create_announcement');
        }
    }

    // Delete announcement (no CSRF)
    public function deleteAnnouncement()
    {
        $id = $_GET['id'];
        $this->announcementModel->deleteAnnouncement($id);
        $this->redirect('index.php?controller=admin&action=announcements');
    }

    // Edit announcement
    public function editAnnouncement()
    {
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title'   => $_POST['title'],
                'content' => $_POST['content'], // Vulnerable to XSS
            ];

            // Handle file upload to database
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
                $data['attachment']      = $_FILES['attachment']['name'];
                $data['attachment_data'] = file_get_contents($_FILES['attachment']['tmp_name']);
                $data['attachment_mime'] = $_FILES['attachment']['type'];
            } elseif (isset($_POST['remove_attachment'])) {
                // Remove attachment if requested
                $data['attachment']      = null;
                $data['attachment_data'] = null;
                $data['attachment_mime'] = null;
            }

            $this->announcementModel->updateAnnouncement($id, $data);
            $this->redirect('index.php?controller=admin&action=announcements');
        } else {
            $announcement = $this->announcementModel->getAnnouncementById($id);
            $this->view('admin/edit_announcement', ['announcement' => $announcement]);
        }
    }

    // View all tickets
    public function tickets()
    {
        // Get filter parameters
        $search   = $_GET['search'] ?? '';
        $status   = $_GET['status'] ?? '';
        $priority = $_GET['priority'] ?? '';
        $category = $_GET['category'] ?? '';

        // Use SQL-level filtering for better performance
        $tickets = $this->ticketModel->getAllTicketsWithFilters($search, $status, $priority, $category);

        // Check if any filters are applied
        $hasFilters = ! empty($search) || ! empty($status) || ! empty($priority) || ! empty($category);

        // Calculate stats based on whether filters are applied
        if ($hasFilters) {
            // Recalculate stats from filtered tickets
            $stats = [
                'total'       => count($tickets),
                'open'        => count(array_filter($tickets, fn($t) => $t['status'] == 'open')),
                'in_progress' => count(array_filter($tickets, fn($t) => $t['status'] == 'in_progress')),
                'closed'      => count(array_filter($tickets, fn($t) => $t['status'] == 'closed')),
            ];
        } else {
            // Use stats from model for better performance
            $stats = $this->ticketModel->getTicketStats();
        }

        $this->view('admin/tickets', [
            'tickets' => $tickets,
            'stats'   => $stats,
        ]);
    }

    // View ticket detail
    public function viewTicket()
    {
        $ticketId = $_GET['id'] ?? 0;

        $ticket = $this->ticketModel->getTicketById($ticketId);
        if (! $ticket) {
            $this->redirect('index.php?controller=admin&action=tickets');
            return;
        }

        $comments = $this->ticketModel->getComments($ticketId, true); // Show internal notes
        $users    = $this->userModel->getUsersByRole('admin');        // Get IT staff for assignment

        $this->view('admin/view_ticket', [
            'ticket'   => $ticket,
            'comments' => $comments,
            'users'    => $users,
        ]);
    }

    // Add comment to ticket
    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticketId   = $_POST['ticket_id'];
            $userId     = $this->getCurrentUser()['id'];
            $comment    = $_POST['comment']; // No XSS protection
            $isInternal = isset($_POST['is_internal']) ? 1 : 0;

            $this->ticketModel->addComment($ticketId, $userId, $comment, $isInternal);
            $this->redirect('index.php?controller=admin&action=viewTicket&id=' . $ticketId);
        }
    }

    // Assign ticket
    public function assignTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticketId   = $_POST['ticket_id'];
            $assignedTo = $_POST['assigned_to'];

            $this->ticketModel->assignTicket($ticketId, $assignedTo ?: null);
            $this->redirect('index.php?controller=admin&action=viewTicket&id=' . $ticketId);
        }
    }

    // Update ticket priority
    public function updateTicketPriority()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticketId = $_POST['ticket_id'];
            $priority = $_POST['priority'];

            $this->ticketModel->updatePriority($ticketId, $priority);
            $this->redirect('index.php?controller=admin&action=viewTicket&id=' . $ticketId);
        }
    }

    // Update ticket category
    public function updateTicketCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticketId = $_POST['ticket_id'];
            $category = $_POST['category'];

            $this->ticketModel->updateCategory($ticketId, $category);
            $this->redirect('index.php?controller=admin&action=viewTicket&id=' . $ticketId);
        }
    }

    // Update ticket status
    public function updateTicketStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id     = $_POST['id'] ?? $_POST['ticket_id'];
            $status = $_POST['status'];

            if ($status == 'closed') {
                $this->ticketModel->closeTicket($id, $this->getCurrentUser()['id']);
            } else {
                $this->ticketModel->updateStatus($id, $status);
            }

            // Redirect back to ticket detail if ticket_id is present, otherwise to tickets list
            if (isset($_POST['ticket_id'])) {
                $this->redirect('index.php?controller=admin&action=viewTicket&id=' . $_POST['ticket_id']);
            } else {
                $this->redirect('index.php?controller=admin&action=tickets');
            }
        }
    }

    // Profile
    public function profile()
    {
        $user = $this->userModel->getUserById($this->getCurrentUser()['id']);
        $this->view('admin/profile', ['user' => $user]);
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
                    $this->view('admin/change_password', ['success' => $success]);
                    return;
                } else {
                    $error = "Password baru dan konfirmasi tidak cocok!";
                }
            } else {
                $error = "Password lama salah!";
            }

            $this->view('admin/change_password', ['error' => $error]);
        } else {
            $this->view('admin/change_password');
        }
    }

    // Serve ticket attachment from database
    public function getTicketAttachment()
    {
        $ticketId = $_GET['id'] ?? 0;
        $this->serveAttachment('TicketModel', $ticketId);
    }

    // Serve announcement attachment from database
    public function getAnnouncementAttachment()
    {
        $announcementId = $_GET['id'] ?? 0;
        $this->serveAttachment('AnnouncementModel', $announcementId);
    }

    // Serve profile picture from database
    public function getProfilePicture()
    {
        $userId = $_GET['id'] ?? 0;
        $this->serveProfilePicture($userId);
    }
}
