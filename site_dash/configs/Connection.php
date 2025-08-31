<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/ErrorHandler.php";
class Connection
{
    private $errorHandler;
    private $pdoExceptionHandler;
    private $host;
    private $user;
    private $password;
    private $db_name = 'projeto_incendio';

    public function __construct()
    {
        $e = 0;
        $this->errorHandler = new ErrorHandler;
        $this->pdoExceptionHandler = new PDOExceptionHandler($e);
        set_error_handler([$this->errorHandler, 'errorHandler']);
        set_exception_handler([$this->errorHandler, 'exceptionHandler']);

        switch ($_SERVER["HTTP_HOST"]) {
            case "":
                $this->host = "";
                $this->user = "";
                $this->password = 's7j&';
                break;
            default:
                $this->host = "localhost";
                $this->user = "root";
                $this->password = "1234";
                break;
        }
    }

    public function getConnection()
    {
        try {
            $pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
        }
    }
}
