<?php

session_start();
$host = "localhost";
$user = 'root';
$pass = '';
$db = "qsoft_training_php";
try {
    $connection = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

class dologin {
    private $connection;
    function __construct($connection) {
        $this->connection = $connection;
    }

    public function __destruct() {
        
    }

    function CheckPassword($password) {
        if (!$password) {
            throw new Exception('Enter password.');
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])[0-9a-zA-Z]{6,}$/', $password)) {
            throw new Exception('Enter valid pass.');
        }
        return true;
    }

    function checkEmail($email) {
        if (!$email) {
            throw new Exception('Enter your email.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Enter valid email.');
        }
        return true;
    }

    function Login() {
        try {
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $password = isset($_POST['password']) ? trim($_POST['password']) : null;
            $this->checkEmail($email);
            $this->CheckPassword($password);
            if ($this->checkEmail($email) && $this->CheckPassword($password)) {
//                $connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8', 'root', $this->pass);
                $statement = $this->connection->prepare("select id from users where email = :email and password = :password");
                $statement->execute(array(':email' => $email, ':password' => md5($password)));
                $statement->fetch(PDO::FETCH_ASSOC);
                if ($statement->rowCount() > 0) {
                    $_SESSION['logged'] = TRUE;
                    $_SESSION['user'] = ['email' => $email, 'password' => $password];
                    return true;
                } else {
                    return FALSE;
                }
            }

            $message = 'Logged.';
            WriteLog('in', $email);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    }

    function Logout() {
        session_destroy();
        WriteLog('out', $email = "");
        header("Location: http://localhost/training-git/login.php");
    }

    public function is_logged() {
        if (isset($_SESSION['logged'])) {
            return true;
        }
        return FALSE;
    }

    public function redirect($url) {
        header('Location:' . $url);
    }

    function WriteLog($action = '', $email) {
        $handle = fopen("log.txt", "a");
        fwrite($handle, 'User ' . $email . ' logged ' . $action . ' to the system at ' . date('d/m/Y H:i:s') . '.');
        fwrite($handle, "\r\n");
        fclose($handle);
    }

    function inLogs() {
        $content = file_get_contents("log.txt");
        echo ($content);
    }
}
$obj = new dologin($connection);