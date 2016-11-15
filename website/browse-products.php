<?php

// Dependencies
require_once( 'functions/html.php' );
require_once( 'classes/Database.php' );

// Fetching the products
$sql = '
  SELECT *
  FROM   Product;
';
$request = Database::getConnection()->query( $sql );
$products = $request->fetchAll();
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
	<title>Products</title>
  </head>
  <body>
    <main>
	  <table class="bordered-table">
	    <caption>Products</caption>
		<thead>
		  <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Price</td>
		  </tr>
		</thead>
    <?php foreach( $products as $product ) : ?>
      <tr>
        <td><?php echo( $product['ProductId'] ) ?></td>
        <td><?php echo( $product['Name'] ) ?></td>
        <td><?php echo( $product['Price'] ) ?></td>
      </tr>
    <?php endforeach ?>
	  </table>
	</main>
  </body>
</html>