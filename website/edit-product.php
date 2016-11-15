<?php

// Starts session. Necessary to enable login functionalities.
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'classes/stores/Product.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks if the user is logged-in and is a company manager.
checkIfCompanyManager();

// Checks if the product id is set.
if ( getHttpGet( 'id' ) == null ) {
  $title = 'No Product Id provided';
  displayMessagePage( '', $title );
}

// Fetches the product
$fetchSql = '
  SELECT *
  FROM   Product
  WHERE  ProductId = ?;
';
try {
  $db = Database::getConnection();
  $fetchRequest = $db->prepare( $fetchSql );
  $success = $fetchRequest->execute( array( getHttpGet( 'id' ) ) );
  if ( $success === false ) {
    throw new Exception( 'Error: Can\t search product.' );
  }
  $row = $fetchRequest->fetch();
  if ( $row == null ) {
    throw new Exception( 'Error: No product has this id.' );
  }
  $fetchRequest->closeCursor();
}
catch ( Exception $e ) {
  if ( $fetchRequest !== null ) {
    $fetchRequest->closeCursor();
  }
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
$product = new Product;
$product->setId( $row['ProductId'] );
$product->setName( $row['Name'] );
$product->setPrice( $row['Price'] );
$pageTitle = 'Edit Product #' . $product->getId();

// Checks if the request is a post request to update the product and process the request accordingly.
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  try {
    $product->setName( getPost( 'name' ) );
  }
  catch ( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
    $product->setPrice( getPost( 'price' ) );
  $updateSql = '
    UPDATE Product
    SET    Name = ?,
           Price = ?
    WHERE  ProductId = ?;
  ';
  $params = array(  $product->getName(),  $product->getPrice(),  $product->getId() );
  try {
    $updateRequest = $db->prepare( $updateSql );
    $success = $updateRequest->execute( $params );
    if ( $success === false ) {
      throw new Exception( 'Error: The product could not be updated.' );
    }
    $updateRequest->closeCursor();
    $message = 'Your product (' . $product->getName() . ') has been successfully updated.';
    $title = 'Product Successfully Updated';
    displayMessagePage( $message, $title );
  }
  catch ( Exception $e ) {
    if ( $updateRequest !== null ) {
      $updateRequest->closeCursor();
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title><?php echo( $pageTitle ) ?></title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <caption><?php echo( $pageTitle ) ?></caption>
        <tr>
          <td>
            Id
          </td>
          <td>
            <?php echo( $product->getId() ) ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="name" form="form">Name</label>
          </td>
          <td>
            <input form="form" id="name" name="name" type="text" value="<?php echo( $product->getName() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="price" form="form">Price</label>
          </td>
          <td>
            <input form="form" id="price" name="price" type="text" value="<?php echo( $product->getPrice() ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Update product</button>
      </form>
    </main>
  </body>
</html>