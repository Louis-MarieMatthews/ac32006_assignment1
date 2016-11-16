<?php

// Enables login functionalities
session_start();

// Dependencies
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks if either company manager or branch manager
if ( ! isCompanyManager() & ! isBranchManager() ) {
  displayAccessDenied();
  die();
}

// Checks that the branch id has been defined
if ( getHttpGet( 'id' ) == null ) {
  $title = 'No Branch Id Defined';
  $message = 'You have not defined any branch id.';
  displayMessagePage( $message, $title );
}

// Checks that, if the user is a branch manager, they have access to 
// this branch
if ( isBranchManager() ) {
  $getBranchSql = '
    SELECT BranchId
    FROM   BranchManager
    WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
  ';
  $getBranchParams = array( SessionLogin::getUsername() );
  try {
    $db = Database::getConnection();
    $getBranchRequest = $db->prepare( $getBranchSql );
    $success = $getBranchRequest->execute( $getBranchParams );
    if ( $success === false ) {
      throw new Exception( 'Error: The system could not check if you are authorized to see this branch.' );
    }
    $getBranchRow = $getBranchRequest->fetch();
    if ( $getBranchRow === false ) {
      throw new Exception( 'Error: There is no branch with this id.' );
    }
    $branchId = $getBranchRow['BranchId'];
  }
  catch ( Exception $e ) {
    displayMessagePage( $e->getMessage(), $e->getMessage() );
  }
  finally {
    if ( isset( $getBranchRequest ) ) {
      $getBranchRequest->closeCursor();
    }
  }
  if ( $branchId != getHttpGet( 'id' ) ) {
    displayAccessDenied();
  }
}

// Proccess supply update
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  try {
    $db = Database::getConnection();
    $alreadyThereRequest = $db->prepare( 'SELECT * FROM Warehouse WHERE BranchId = ? AND ProductId = ?;' );
    $success = $alreadyThereRequest->execute( array( getHttpGet( 'id' ), getPost( 'product-id' ) ) );
    if ( $success === false ) {
      throw new Exception( 'Error: The system could not check if there is already some data set for that type of supplies for that branch.' );
    }
    if ( $alreadyThereRequest->fetch() === false ) {
      $alreadyThere = false;
    }
    else {
      $alreadyThere = true;
    }
    if ( $alreadyThere ) {
      $updateSql = '
        UPDATE Warehouse
        SET    Quantity = ?
        WHERE  ProductId = ? AND BranchId = ?;
      ';
      $updateParams = array( getPost( 'quantity' ), getPost( 'product-id' ), getHttpGet( 'id' ) );
      $updateRequest = $db->prepare( $updateSql );
      $updateSuccess = $updateRequest->execute( $updateParams );
      if ( $updateSuccess === false ) {
        throw new Exception( 'Error: An error prevented the supplies of that branch from being updated.' );
      }
      $message = 'The supply has been updated successfully';
      $title = 'Supply Set Successfully';
      displayMessagePage( $message, $title );
    }
    else {
      $insertSql = '
        INSERT INTO Warehouse ( BranchId, ProductId, Quantity )
        VALUES ( ?, ?, ? );
      ';
      $insertParams = array( getHttpGet( 'id' ), getPost( 'product-id' ), getPost( 'quantity' ) );
      $insertRequest = $db->prepare( $insertSql );
      $insertSuccess = $insertRequest->execute( $insertParams );
      if ( $insertSuccess === false ) {
        throw new Exception( 'Error: An error prevented the supplies of that branch from being updated.' );
      }
      $message = 'The supply has been updated successfully';
      $title = 'Supply Set Successfully';
      displayMessagePage( $message, $title );
    }
  }
  catch( Exception $e ) {
    $formErrors[] = $e->getMessage();
  }
  finally {
    if ( isset( $request ) ) {
      $request->closeCursor();
    }
  }
}

// Sets the title of the page
$title = 'Set Branch #' . getHttpGet( 'id' ) . ' Supplies';
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title><?php echo( $title ) ?></title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <caption><?php echo( $title ) ?></caption>
          <tr>
            <td>
              <label for="product-id" form="form">Product Id</label>
            </td>
            <td>
              <input form="form" id="product-id" name="product-id"
              type="text"
              value="<?php echo( getPost( 'product-id' ) ) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <label for="quantity" form="form">Quantity</label>
            </td>
            <td>
              <input form="form" id="quantity" name="quantity"
              type="text"
              value="<?php echo( getPost( 'quantity' ) ) ?>" />
            </td>
          </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Set supply</button>
      </form>
    </main>
  </body>
</html>