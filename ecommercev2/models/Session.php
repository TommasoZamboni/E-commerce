<?php

class Session
{
    private $id;
    private $ip;
    private $data_login;

    private $data_logout;


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

    public function getDataLogout()
    {
        return $this->data_logout;
    }

    public function setDataLogout($data_logout)
    {
        $this->data_logout = $data_logout;
    }

    public static function Find($id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.sessions where id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Session");
        } else {
            throw new PDOException("sessione non trovata");
        }

    }


    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into ecommerce.sessions (ip, data_login,user_id) values (:ip,:data_login,:user_id)");
        $stmt->bindParam(":ip", $params["ip"]);
        $stmt->bindParam(":data_login", $params["data_login"]);
        $stmt->bindParam(":user_id", $params["user_id"]);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.sessions order by id desc limit 1");
            $stmt->execute();
            return $stmt->fetchObject("Session");
        } else {
            throw new PDOException("Errore Nella Creazione");
        }

    }

    public function deactivate($data_logout)
    {
        $pdo = self::Connect();
        $id = $this->getId();
        $stmt = $pdo->prepare("update ecommerce.sessions set data_logout = :data_logout  where id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":data_logout", $data_logout);
        $stmt->execute();

    }


    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }

}