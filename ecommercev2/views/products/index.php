<?php
require_once '../../models/Session.php';
require_once '../../models/Product.php';
require_once '../../models/User.php';
require_once '../../models/Cart.php';


session_start();

if (empty($_SESSION["current_user"]) || $_SESSION['current_user']->GetRole_ID() != 1) {
    header("HTTP/1.1 401 Unauthorized");
    ?>
    <h1>
        <?php exit("401 Not Authorized"); ?>
    </h1>
    <?php
}
$user = $_SESSION['current_user'];
$products = Product::fetchAll();
?>

<html>
<head>
    <title>Catalogo Prodotti</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul li {
            margin: 20px 10px;
            padding: 20px;
            border-radius: 8px;
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

        form input[type="number"] {
            width: 85px;
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

<?php foreach ($products as $product) { ?>
    <ul>
        <li><?php echo "Marca: " . $product->getMarca() ?></li>
        <li><?php echo "Nome: " . $product->getNome() ?></li>
        <li><?php echo "Prezzo: " . $product->getPrezzo() ?></li>
    </ul>

    <form action="../../actions/add_to_cart.php" method="POST">
        <input type="number" name="quantita" min=0 placeholder="quantita">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="hidden" name="cart_id" value="<?php echo Cart::FindByUserId($user->GetID())->getId(); ?>">
        <input type="submit" value="submit">
    </form>
<?php } ?>

<a href="../../views/cart.php">Vai al carrello</a>
<a href="../../actions/logout.php">logout</a>

</body>
</html>
