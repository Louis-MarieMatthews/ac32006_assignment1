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

// Gets the supplies of the branch
$selectSuppliesSql = '
  SELECT ProductId, Quantity
  FROM   Warehouse
  WHERE  BranchId = ?;
';
$selectSuppliesParams = array( getHttpGet( 'id' ) );
try {
  $db = Database::getConnection();
  $selectSuppliesRequest = $db->prepare( $selectSuppliesSql );
  $success = $selectSuppliesRequest->execute( $selectSuppliesParams );
  if ( $success === false ) {
    throw new Exception( 'Error: The supplies of the branch could not have been searched for.' );
  }
  $supplies = $selectSuppliesRequest->fetchAll();
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( isset( $selectSuppliesRequest ) ) {
    $selectSuppliesRequest->closeCursor();
  }
}

// Sets the title of the page
$title = 'Branch #' . getHttpGet( 'id' ) . ' Supplies';
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title><?php echo( $title ) ?></title>
  </head>
  <body>
    <main>
      <table class="bordered-table">
        <caption><?php echo( $title ) ?></caption>
        <thead>
          <tr>
            <td>Product Id</td>
            <td>Quantity</td>
          </tr>
        </thead>
        <?php foreach( $supplies as $supply ) : ?>
        <tr>
          <td><?php echo( $supply['ProductId'] ) ?></td>
          <td><?php echo( $supply['Quantity'] ) ?></td>
        </tr>
        <?php endforeach ?>
      </table>
    </main>
  </body>
</html>