<?php

// Starts session. Necessary to enable login functionalities.
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks if the user is logged-in and is a company manager.
checkIfCompanyManager();

// Checks if the supplier id is set.
if ( getHttpGet( 'id' ) == null ) {
  $title = 'No Supplier Id provided';
  displayMessagePage( '', $title );
}

// Fetches the supplier
$fetchSql = '
  SELECT *
  FROM   Supplier
  WHERE  SupplierId = ?;
';
try {
  $db = Database::getConnection();
  $fetchRequest = $db->prepare( $fetchSql );
  $success = $fetchRequest->execute( array( getHttpGet( 'id' ) ) );
  if ( $success === false ) {
    throw new Exception( 'Error: Can\t search supplier.' );
  }
  $row = $fetchRequest->fetch();
  if ( $row == null ) {
    throw new Exception( 'Error: No supplier has this id.' );
  }
  $fetchRequest->closeCursor();
}
catch ( Exception $e ) {
  if ( $fetchRequest !== null ) {
    $fetchRequest->closeCursor();
  }
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
$pageTitle = 'Edit Supplier #' . getHttpGet( 'id' ) ;

// Checks if the request is a post request to update the supplier and process the supplier accordingly.
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $updateSql = '
    UPDATE Supplier
    SET    Name = ?,
           Telephone = ?
    WHERE  SupplierId = ?;
  ';
  if ( getPost( 'telephone' ) === '' ) {
    $telephone = null;
  }
  else {
    $telephone = getPost( 'telephone' );
  }
  $updateParams = array(
    getPost( 'name' ),
    $telephone,
    getHttpGet( 'id' ),
  );
  try {
    $updateRequest = $db->prepare( $updateSql );
    $success = $updateRequest->execute( $updateParams );
    if ( $success === false ) {
      throw new Exception( 'Error: The supplier could not be updated.' );
    }
    $message = 'The supplier ' . getPost( 'name' ) . ' has been successfully updated.';
    $title = 'Supplier Successfully Updated';
    displayMessagePage( $message, $title );
  }
  catch ( Exception $e ) {
    $formErrors[] = $e->getMessage();
  }
  finally {
    if ( isset( $updateRequest ) ) {
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
            <?php echo( $row['SupplierId'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="name" form="form">Name</label>
          </td>
          <td>
            <input form="form" id="name" name="name" type="text" value="<?php echo( $row['Name'] ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="telephone" form="form">Telephone</label>
          </td>
          <td>
            <input form="form" id="telephone" name="telephone" type="text" value="<?php echo( $row['Telephone'] ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Update supplier</button>
      </form>
    </main>
  </body>
</html>