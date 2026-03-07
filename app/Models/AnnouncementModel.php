<?php
// =========================================
// Announcement Model
// IntraCorp Portal (Vulnerable Edition)
// =========================================

class AnnouncementModel
{
    private $db;

    public function __construct()
    {
        require_once '../Config/db_config.php';
        $this->db = new Database();
    }

    // Get all announcements
    public function getAllAnnouncements($search = '')
    {
        $sql = "SELECT a.*, u.full_name as author
                FROM announcements a
                JOIN users u ON a.author_id = u.id
                WHERE 1=1";

        // Add search filter
        if (! empty($search)) {
            $sql .= " AND (a.title LIKE '%$search%' OR a.content LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.created_at DESC";

        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get announcement by ID
    public function getAnnouncementById($id)
    {
        $sql = "SELECT a.*, u.full_name as author
                FROM announcements a
                JOIN users u ON a.author_id = u.id
                WHERE a.id = $id";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Create announcement (admin) - Vulnerable to XSS
    public function createAnnouncement($title, $content, $authorId, $attachment = null)
    {
        $attachmentValue = $attachment ? "'$attachment'" : "NULL";
        $sql             = "INSERT INTO announcements (title, content, author_id, attachment)
                VALUES ('$title', '$content', $authorId, $attachmentValue)";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    // Delete announcement
    public function deleteAnnouncement($id)
    {
        $sql = "DELETE FROM announcements WHERE id = $id";
        $this->db->query($sql);
    }

    // Update announcement (admin) - Vulnerable to XSS
    public function updateAnnouncement($id, $data)
    {
        $sql = "UPDATE announcements SET
                title = '{$data['title']}',
                content = '{$data['content']}'";

        // Update attachment if provided
        if (isset($data['attachment'])) {
            if ($data['attachment'] === null) {
                $sql .= ", attachment = NULL";
            } else {
                $sql .= ", attachment = '{$data['attachment']}'";
            }
        }

        $sql .= " WHERE id = $id";
        $this->db->query($sql);
    }
}
