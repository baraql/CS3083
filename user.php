<?php
class User {
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $isAdmin; // false normal user; true admin user;

    public function login($un, $pass) {
        if($this->username === $un && $this->password === md5($pass)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = serialize($this);
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin() {
        return $this->isAdmin == true;
    }
    
    public static function checkPerm() {
        $user = unserialize($_SESSION['user']);
        if (!$user->isAdmin()) {
            die ('No permission to do this operation! <a href="criminal.php"> go back </a>');
        }
    }

    public static function isLogined() {
        return (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true);
    }

    public static function fromRow($row) {
        $user = new User;

        $user->username = $row['username'];
        $user->password = $row['password'];
        $user->firstname = $row['firstname'];
        $user->lastname = $row['lastname'];
        $user->isAdmin = $row['isAdmin'];

        return $user;
    }
}

?>