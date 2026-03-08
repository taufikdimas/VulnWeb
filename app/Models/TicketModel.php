<?php
// =========================================
// Ticket Model
// IntraCorp Portal (Vulnerable Edition)
// =========================================

class TicketModel
{
    private $db;

    public function __construct()
    {
        require_once '../Config/db_config.php';
        $this->db = new Database();
    }

    // Create ticket (Vulnerable to XSS - no sanitization)
    public function createTicket($data)
    {
        $userId         = $data['user_id'];
        $subject        = $data['subject'];
        $description    = $data['description'];
        $priority       = $data['priority'] ?? 'medium';
        $category       = $data['category'] ?? 'other';
        $attachment     = $data['attachment'] ?? null;
        $attachmentData = $data['attachment_data'] ?? null;
        $attachmentMime = $data['attachment_mime'] ?? null;

        $attachmentSQL     = $attachment ? "'$attachment'" : 'NULL';
        $attachmentDataSQL = $attachmentData ? "'" . mysqli_real_escape_string($this->db->getConnection(), $attachmentData) . "'" : 'NULL';
        $attachmentMimeSQL = $attachmentMime ? "'$attachmentMime'" : 'NULL';

        $sql = "INSERT INTO tickets (user_id, subject, description, priority, category, attachment, attachment_data, attachment_mime_type)
                VALUES ($userId, '$subject', '$description', '$priority', '$category', $attachmentSQL, $attachmentDataSQL, $attachmentMimeSQL)";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    // Get tickets by user
    public function getTicketsByUser($userId)
    {
        $sql = "SELECT t.*, u.username, u.full_name, u.department,
                       a.username as assigned_username, a.full_name as assigned_full_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON t.assigned_to = a.id
                WHERE t.user_id = $userId
                ORDER BY
                    FIELD(t.priority, 'critical', 'high', 'medium', 'low'),
                    t.created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get all tickets (admin)
    public function getAllTickets()
    {
        $sql = "SELECT t.*, u.username, u.full_name, u.department,
                       a.username as assigned_username, a.full_name as assigned_full_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON t.assigned_to = a.id
                ORDER BY
                    FIELD(t.priority, 'critical', 'high', 'medium', 'low'),
                    t.created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get all tickets with filters (for user view)
    public function getAllTicketsWithFilters($search = '', $status = '', $priority = '', $category = '')
    {
        $sql = "SELECT t.*, u.username, u.full_name, u.department,
                       a.username as assigned_username, a.full_name as assigned_full_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON t.assigned_to = a.id
                WHERE 1=1";

        // Add search filter
        if (! empty($search)) {
            $sql .= " AND (t.subject LIKE '%$search%' OR t.description LIKE '%$search%' OR u.full_name LIKE '%$search%' OR u.username LIKE '%$search%')";
        }

        // Add status filter
        if (! empty($status)) {
            $sql .= " AND t.status = '$status'";
        }

        // Add priority filter
        if (! empty($priority)) {
            $sql .= " AND t.priority = '$priority'";
        }

        // Add category filter
        if (! empty($category)) {
            $sql .= " AND t.category = '$category'";
        }

        $sql .= " ORDER BY
                    FIELD(t.priority, 'critical', 'high', 'medium', 'low'),
                    t.created_at DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get ticket by ID with full details
    public function getTicketById($id)
    {
        $sql = "SELECT t.*, u.username, u.full_name, u.email, u.department,
                       a.username as assigned_username, a.full_name as assigned_full_name,
                       c.username as closed_by_username, c.full_name as closed_by_full_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON t.assigned_to = a.id
                LEFT JOIN users c ON t.closed_by = c.id
                WHERE t.id = $id";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Update ticket status
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE tickets SET status = '$status', updated_at = NOW() WHERE id = $id";
        $this->db->query($sql);
    }

    // Close ticket
    public function closeTicket($id, $userId)
    {
        $sql = "UPDATE tickets
                SET status = 'closed',
                    closed_at = NOW(),
                    closed_by = $userId,
                    updated_at = NOW()
                WHERE id = $id";
        $this->db->query($sql);
    }

    // Add comment to ticket
    public function addComment($ticketId, $userId, $comment, $isInternal = 0)
    {
        $sql = "INSERT INTO ticket_comments (ticket_id, user_id, comment, is_internal)
                VALUES ($ticketId, $userId, '$comment', $isInternal)";
        $this->db->query($sql);

        // Update ticket's updated_at
        $this->db->query("UPDATE tickets SET updated_at = NOW() WHERE id = $ticketId");

        return $this->db->lastInsertId();
    }

    // Get comments for a ticket
    public function getComments($ticketId, $showInternal = false)
    {
        $internalCondition = $showInternal ? '' : 'AND is_internal = 0';

        $sql = "SELECT c.*, u.username, u.full_name, u.role
                FROM ticket_comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.ticket_id = $ticketId $internalCondition
                ORDER BY c.created_at ASC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Update ticket assignment
    public function assignTicket($ticketId, $assignedTo)
    {
        $assignedSQL = $assignedTo ? $assignedTo : 'NULL';
        $sql         = "UPDATE tickets SET assigned_to = $assignedSQL, updated_at = NOW() WHERE id = $ticketId";
        $this->db->query($sql);
    }

    // Update ticket priority
    public function updatePriority($ticketId, $priority)
    {
        $sql = "UPDATE tickets SET priority = '$priority', updated_at = NOW() WHERE id = $ticketId";
        $this->db->query($sql);
    }

    // Update ticket category
    public function updateCategory($ticketId, $category)
    {
        $sql = "UPDATE tickets SET category = '$category', updated_at = NOW() WHERE id = $ticketId";
        $this->db->query($sql);
    }

    // Get ticket count by status
    public function getTicketStats()
    {
        $sql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open,
                    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed
                FROM tickets";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }
}
