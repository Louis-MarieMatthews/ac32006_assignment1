<?php

// To enable login feature
session_start();

// Dependencies
require_once( 'classes/stores/Telephone.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Authorizations
checkIfCompanyManager();

// Processes supplier addition if the request is a POST request
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  try {
    $telephone = new Telephone( getPost( 'telephone' ) );
  }
  catch ( Exception $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  if ( $isValid ) {
    $insertSql = '
      INSERT INTO Supplier ( Name, Telephone )
      VALUES      ( ?, ? );
    ';
    $insertParams = array( getPost( 'name' ), $telephone );
    try {
      $db = Database::getConnection();
      $insertRequest = $db->prepare( $insertSql );
      $success = $insertRequest->execute( $insertParams );
      if ( $success === false ) {
        throw new Exception( 'Error: The supplier could not be added.' );
      }
      $title = 'Supplier Added';
      $message = 'The supplier has been added.';
      displayMessagePage( $message, $title );
    }
    catch( Exception $e ) {
      $formErrors[] = $e->getMessage();
    }
    finally {
      if ( isset( $insertRequest ) ) {
        $insertRequest->closeCursor();
      }
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Add Supplier</title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <caption>Add Supplier</caption>
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
            <label for="telephone" form="form">Telephone</label>
          </td>
          <td>
            <input form="form" id="telephone" name="telephone" type="text" value="<?php echo( getPost( 'telephone' ) ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Add supplier</button>
      </form>
    </main>
  </body>
</html>