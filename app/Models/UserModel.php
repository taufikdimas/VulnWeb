<?php
// =========================================
// User Model
// IntraCorp Portal (Vulnerable Edition)
// =========================================

class UserModel
{
    private $db;

    public function __construct()
    {
        require_once '../Config/db_config.php';
        $this->db = new Database();
    }

    // Vulnerable login - SQL Injection
    public function login($username, $password)
    {
        $sql    = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Vulnerable register - no input validation
    public function register($data)
    {
        $sql = "INSERT INTO users (username, email, password, full_name, role, department, phone)
                VALUES ('{$data['username']}', '{$data['email']}', '{$data['password']}',
                        '{$data['full_name']}', 'employee', '{$data['department']}', '{$data['phone']}')";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    // Get user by ID
    public function getUserById($id)
    {
        $sql    = "SELECT * FROM users WHERE id = $id";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Update user profile
    public function updateProfile($id, $data)
    {
        $conn = $this->db->getConnection();

        $sql = "UPDATE users SET
                full_name = '{$data['full_name']}',
                email = '{$data['email']}',
                department = '{$data['department']}',
                phone = '{$data['phone']}'";

        if (isset($data['profile_picture'])) {
            $profilePicture  = mysqli_real_escape_string($conn, $data['profile_picture']);
            $sql            .= ", profile_picture = '$profilePicture'";

            if (isset($data['profile_picture_data'])) {
                $profilePictureData  = mysqli_real_escape_string($conn, $data['profile_picture_data']);
                $sql                .= ", profile_picture_data = '$profilePictureData'";
            }

            if (isset($data['profile_picture_mime'])) {
                $profilePictureMime  = mysqli_real_escape_string($conn, $data['profile_picture_mime']);
                $sql                .= ", profile_picture_mime_type = '$profilePictureMime'";
            }
        }

        $sql .= " WHERE id = $id";
        $this->db->query($sql);
    }

    // Get all users (admin)
    public function getAllUsers()
    {
        $sql    = "SELECT * FROM users ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Vulnerable search - SQL Injection
    public function searchUsers($keyword)
    {
        $sql    = "SELECT * FROM users WHERE username LIKE '%{$keyword}%' OR full_name LIKE '%{$keyword}%'";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get users by role
    public function getUsersByRole($role)
    {
        $sql    = "SELECT * FROM users WHERE role = '$role' ORDER BY full_name ASC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Delete user (no CSRF protection)
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = $id";
        $this->db->query($sql);
    }

    // Update user (admin)
    public function updateUser($id, $data)
    {
        $sql = "UPDATE users SET
                username = '{$data['username']}',
                email = '{$data['email']}',
                full_name = '{$data['full_name']}',
                role = '{$data['role']}',
                department = '{$data['department']}',
                phone = '{$data['phone']}',
                is_active = {$data['is_active']}";

        if (! empty($data['password'])) {
            $sql .= ", password = '{$data['password']}'";
        }

        $sql .= " WHERE id = $id";
        $this->db->query($sql);
    }

    // Create new user (admin)
    public function createUser($data)
    {
        $sql = "INSERT INTO users (username, email, password, full_name, role, department, phone, is_active)
                VALUES ('{$data['username']}', '{$data['email']}', '{$data['password']}',
                        '{$data['full_name']}', '{$data['role']}', '{$data['department']}',
                        '{$data['phone']}', {$data['is_active']})";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    // Get user by email (for password reset)
    public function getUserByEmail($email)
    {
        $sql    = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Create password reset token (Vulnerable - weak token generation)
    public function createPasswordReset($email, $token)
    {
        // Delete old tokens for this email
        $deleteSql = "DELETE FROM password_resets WHERE email = '$email'";
        $this->db->query($deleteSql);

        // Insert new token
        $sql = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";
        $this->db->query($sql);
    }

    // Get password reset by token
    public function getPasswordResetByToken($token)
    {
        $sql    = "SELECT * FROM password_resets WHERE token = '$token'";
        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }

    // Reset password (Vulnerable - no proper validation)
    public function resetPassword($email, $newPassword)
    {
        $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
        $this->db->query($sql);
    }

    // Delete password reset token
    public function deletePasswordReset($token)
    {
        $sql = "DELETE FROM password_resets WHERE token = '$token'";
        $this->db->query($sql);
    }

    // Change password (Vulnerable - plain text password)
    public function changePassword($userId, $newPassword)
    {
        $sql = "UPDATE users SET password = '$newPassword' WHERE id = $userId";
        $this->db->query($sql);
    }

    // Update last login time
    public function updateLastLogin($userId)
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = $userId";
        $this->db->query($sql);
    }

    // Get users ordered by last login
    public function getUsersByLastLogin()
    {
        $sql    = "SELECT * FROM users ORDER BY last_login DESC, created_at DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
