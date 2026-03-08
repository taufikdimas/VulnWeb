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
        $this->db = Database::getInstance();
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
    public function createAnnouncement($title, $content, $authorId, $attachmentName = null, $attachmentData = null, $attachmentMime = null)
    {
        $conn = $this->db->getConnection();

        $attachmentNameValue = $attachmentName ? "'" . mysqli_real_escape_string($conn, $attachmentName) . "'" : "NULL";
        $attachmentDataValue = $attachmentData ? "'" . mysqli_real_escape_string($conn, $attachmentData) . "'" : "NULL";
        $attachmentMimeValue = $attachmentMime ? "'" . mysqli_real_escape_string($conn, $attachmentMime) . "'" : "NULL";

        $sql = "INSERT INTO announcements (title, content, author_id, attachment, attachment_data, attachment_mime_type)
                VALUES ('$title', '$content', $authorId, $attachmentNameValue, $attachmentDataValue, $attachmentMimeValue)";
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
        $conn = $this->db->getConnection();

        $sql = "UPDATE announcements SET
                title = '{$data['title']}',
                content = '{$data['content']}'";

        // Update attachment if provided
        if (isset($data['attachment'])) {
            if ($data['attachment'] === null) {
                $sql .= ", attachment = NULL, attachment_data = NULL, attachment_mime_type = NULL";
            } else {
                $attachmentName  = mysqli_real_escape_string($conn, $data['attachment']);
                $sql            .= ", attachment = '$attachmentName'";

                if (isset($data['attachment_data'])) {
                    $attachmentData  = mysqli_real_escape_string($conn, $data['attachment_data']);
                    $sql            .= ", attachment_data = '$attachmentData'";
                }

                if (isset($data['attachment_mime'])) {
                    $attachmentMime  = mysqli_real_escape_string($conn, $data['attachment_mime']);
                    $sql            .= ", attachment_mime_type = '$attachmentMime'";
                }
            }
        }

        $sql .= " WHERE id = $id";
        $this->db->query($sql);
    }
}
