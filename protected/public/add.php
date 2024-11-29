<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - </title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!--<link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<!--<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>-->

<style>
body{ padding-top:60px;}
.error-msg{

  color:red;
}
</style>
</head>

<body >

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CHRP</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    <li>
                        <a href="index1.php">Registration Form</a>
                    </li>
                     <li >
                        <a href="cart.php">Cart</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
  
<div class="container">
 
  <div class="well">
 <?php
//Read in variables from $_POST
$price     = $_POST['price'];
$item      = $_POST['p_name'];
$quantity  = $_POST['quantity'];

echo '<h1>Add to cart</h1>';

echo "<p>Thank you for wanting a <strong>$item</strong>!</p>";

//We define an associative array with the details of our new item
$cart_row = array(
	'item' => $item,
	'unitprice' => $price,
	'quantity' => $quantity
);

//If $_SESSION['cart'] hasn't yet been defined, define it as an array
if (!isset($_SESSION['cart']))
	$_SESSION['cart'] = array();

//Append the item to the $_SESSION['cart'] session variable
// ($array[] means "append a new item to the end of $array")
$_SESSION['cart'][] = $cart_row;

//var_dump($_SESSION);

echo "<p>Your item has been added to the cart.</p>";

echo "<a href=\"cart.php\">Go to cart!</a>";

?>
  
  </div>
 
</div>



</body>
</html>

