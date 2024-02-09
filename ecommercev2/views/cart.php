<?php

require_once '../models/User.php';
require_once '../models/CartProduct.php';
require_once '../models/Product.php';
require_once '../models/Cart.php';

session_start();

if (empty($_SESSION["current_user"]) || $_SESSION['current_user']->GetRole_ID() != 1) {
    header("HTTP/1.1 401 Unauthorized");
    ?>
    <h1>
        <?php exit("401 Not Authorized"); ?>
    </h1>
    <?php
}

$current_user = $_SESSION['current_user'];
$carrello_user = CartProduct::fetchAll($current_user);
$totale = 0;
?>

<html>
<head>
    <title>Carrello</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
        }

        ul {
            list-style-type: none;
            padding: 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        ul li {
            margin: 20px 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-top: 10px;
            margin-left: 10px;
        }

        form input {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        a:hover {
            background-color: #3498db;
            color: white;
        }

    </style>
</head>

<body>


<?php foreach ($carrello_user as $acquisto) {
    $product = Product::Find($acquisto->getProductId());
    $quantita = $acquisto->getQuantita();
    $prezzo = $product->getPrezzo(); ?>
    <ul>
        <li><?php echo "Marca: " . $product->getMarca(); ?></li>
        <li><?php echo "Nome: " . $product->getNome(); ?></li>
        <li><?php echo "Prezzo: " . $prezzo; ?></li>
        <li><?php echo "Quantità: " . $quantita; ?></li>
        <?php $totale += $quantita * $prezzo; ?>
    </ul>

    <form action="../actions/edit_cart.php" method="POST">
        <input type="number" name="quantita" min=0 value="<?php echo $quantita; ?>">
        <input type="hidden" name="cart_id" value="<?php echo $acquisto->getCartId(); ?>">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="submit" value="submit">
    </form>


<?php } ?>
<p>Totale carrello: <?php echo $totale; ?></p>
<a class="button" href="http://localhost:63342/ecommercev2/views/products/index.php">Vai al listino</a>
<?php include '../views/navbar.php'; ?>

</body>
</html>