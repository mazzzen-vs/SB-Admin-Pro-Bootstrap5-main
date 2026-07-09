<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO users (full_name, email, phone, password) VALUES (:full_name, :email, :phone, :password)";
        $stmt = $this->db->prepare($sql);
        
        $phone = !empty($data['phone']) ? $data['phone'] : null;

        return $stmt->execute([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $phone,
            'password' => $data['password']
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function saveRememberToken($userId, $selector, $tokenHash, $expiresAt) {
        $sql = "INSERT INTO remember_tokens (user_id, selector, token_hash, expires_at) 
                VALUES (:user_id, :selector, :token_hash, :expires_at)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'selector' => $selector,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ]);
    }

    public function findRememberToken($selector) {
        $stmt = $this->db->prepare("SELECT * FROM remember_tokens WHERE selector = :selector");
        $stmt->execute(['selector' => $selector]);
        return $stmt->fetch();
    }

    public function deleteRememberToken($selector) {
        $stmt = $this->db->prepare("DELETE FROM remember_tokens WHERE selector = :selector");
        return $stmt->execute(['selector' => $selector]);
    }

    public function deleteAllRememberTokens($userId) {
        $stmt = $this->db->prepare("DELETE FROM remember_tokens WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $userId]);
    }
}
