<?php

class Cart
{

    private $id;
    private $user_id;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id = :user_id");
        $stmt->bindParam(":user_id", $params["user_id"]);
        $stmt->execute();
        if (!$stmt->fetchObject("Cart")) {
            $stmt = $pdo->prepare("insert into ecommerce.carts(user_id) values (:user_id)");
            $stmt->bindParam(":user_id", $params["user_id"]);
            $stmt->execute();
        }

        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id = :user_id");
        $stmt->bindParam(":user_id", $params["user_id"]);
        $stmt->execute();
        return $stmt->fetchObject("Cart");

    }

    public static function FindByUserId($user_id)
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id=:user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchObject('Cart');
    }

    public static function Find($cart_id)
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare("select * from ecommerce.carts where id=:id");
        $stmt->bindParam(":id", $cart_id);
        $stmt->execute();
        return $stmt->fetchObject('Cart');
    }

    public static function last_record()
    {
        $pdo = self::connect();
        $stm = $pdo->prepare("SELECT id FROM ecommerce.carts ORDER BY id DESC LIMIT 1");

        if ($stm->execute()) {
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        } else {
            throw new PDOException("Errore nel last_record");
        }
    }

    public static function Find_by_product($product_id)
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare("select cart_id from ecommerce.cart_products where product_id =:product_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchObject('Cart');
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }

    public static function FindAcquisto($cart_id, $product_id)
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare("select * from ecommerce.cart_products where cart_id=:cart_id and product_id=:product_id");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
