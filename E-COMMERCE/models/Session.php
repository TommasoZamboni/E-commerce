<?php
class Session
{
    private $id;
    private $ip;
    private $data_login;

    public function getId()
    {
        return $this->id;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getDataLogin()
    {
        return $this->data_login;
    }

    public function setDataLogin($data_login)
    {
        $this->data_login = $data_login;
    }

    public function Delete()
    {

        $pdo = self::Connect();
        $id = self::getId();
        $stmt = $pdo->prepare("delete from ecommerce.sessions where id = :id");
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            throw new PDOException("errore di cancellazione del record di sessione richiesto");
        }


    }

    public static function Find($id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.sessions where id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Session");
        } else {
            return false;
        }

    }


    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into ecommerce.sessions (ip, data_login,user_id) values (:ip,:data_login,:user_id)");
        $stmt->bindParam(":ip", $params["ip"]);
        $stmt->bindParam(":data_login", $params["data_login"]);
        $stmt->bindParam(":user_id",$params["user_id"]);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.sessions order by id desc limit 1");
            $stmt->execute();
            return $stmt->fetchObject("Session");
        } else {
            throw new PDOException("Errore Nella Creazione");
        }

    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }

}