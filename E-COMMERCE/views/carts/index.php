<?php

require '../../models/Classes.php';

session_start();

$current_user = $_SESSION['current_user'];
$carrello = Cart::Find($current_user->GetID());
$prodotti = $carrello-> FetchAllProducts();
?>

<html>
<head>
    <title>Carrello</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #1a1a1a;
            color: #ffffff;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #333333;
            width: 300px;
            margin: 0 auto;
        }

        li {
            padding: 10px;
            border-bottom: 1px solid #555555;
        }

        form {
            margin-top: 10px;
        }

        input {
            padding: 5px;
            margin-right: 5px;
            background-color: #444444;
            color: #ffffff;
            border: 1px solid #555555;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 10px;
        }

    </style>
</head>

<body>

<?php include '../navbar.php'; ?>
<a href="../products/index.php">Vai ai prodotti</a>
<?php if($carrello) : ?>
    <h1>Carrello</h1>
    <ul>
        <ul>
            <?php foreach ($prodotti as $productInCart) : ?>
            <?php if ($productInCart['quantita'] != 0) { ?>
            <?php $prodotto = Product::Find($productInCart['product_id']); ?>
            <li><?php echo $prodotto->getMarca(); ?></li>
            <li><?php echo $prodotto->getNome(); ?></li>
            <li><?php echo $prodotto->getPrezzo(); ?></li>
            <li>Quantità: <?php echo $productInCart['quantita']; ?></li>
            <li>Totale: <?php echo $productInCart['quantita'] * $prodotto->getPrezzo(); ?></li>
        </ul>

        <form action="../../actions/edit_cart.php" method="POST">
            <label for="quantita">Modifica quantità:</label>
            <input type="number" name="quantita" value="<?php echo $productInCart['quantita']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
            <input type="submit" name="update" value="Aggiorna quantità">
        </form>


            <form action="../../actions/edit_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
                <input type="hidden" name="quantita" value="0">
                <input type="submit" name="remove" value="Rimuovi dal carrello">
            </form>
            <hr>
            <?php } ?>
            <?php endforeach; ?>
    </ul>

<p>Totale carrello: <?php echo $carrello->PrezzoTotale(); ?></p>

<form action="../../actions/edit_cart.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $carrello->getId(); ?>">
    <input type="submit" value="Compra">
</form>

<?php else : ?>
<p>Il carrello è vuoto.</p>
<?php endif ?>

</body>

</html>