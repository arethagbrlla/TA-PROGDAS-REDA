<?php
class User {
    protected $id;
    protected $username;
    protected $password;
    protected $role;

    public function __construct($username, $password, $role = 'customer') {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = $role;
    }

    // Getter untuk username
    public function getUsername() {
        return $this->username;
    }

    // Getter untuk password (hashed)
    public function getPassword() {
        return $this->password;
    }

    // Getter untuk role
    public function getRole() {
        return $this->role;
    }
}
?>
