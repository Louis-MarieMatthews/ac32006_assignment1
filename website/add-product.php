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

// Checks if the request is a post request to add a new product and process the request accordingly.
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $product = new Product;
  $isValid = true;
  try {
    $product->setName( getPost( 'name' ) );
  }
  catch ( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  $product->setPrice( getPost( 'price' ) );
  if ( $isValid ) {
    $sql = '
      INSERT
      INTO   Product ( Name, Price )
      VALUES ( ?, ? );
    ';
    $params = array( $product->getName(), $product->getPrice() );
    try {
      $db = Database::getConnection();
      $request = $db->prepare( $sql );
      $success = $request->execute( $params );
      if ( $success === false ) {
        throw new Exception( 'Error: Could not add product.' );
      }
      $request->closeCursor();
      $message = 'Your product (' . $product->getName() . ') has been successfully added.';
      $title = 'Product Successfully Added';
      displayMessagePage( $message, $title );
    }
    catch ( Exception $e ) {
      // TODO: to change, shouldn't display the exception to the user.
      $formErrors[] = $e->getMessage();
      if ( isset( $request) ) {
        $request->closeCursor();
      }
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Add Product</title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <caption>Add Product</caption>
        <tr>
          <td>
            <label for="name" form="form">Name</label>
          </td>
          <td>
            <input form="form" id="name" name="name" type="text" value="<?php echo( getPost( 'name' ) ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="price" form="form">Price</label>
          </td>
          <td>
            <input form="form" id="price" name="price" type="text" value="<?php echo( getPost( 'price' ) ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Add product</button>
      </form>
    </main>
  </body>
</html>