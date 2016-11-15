<?php

// Activate sessions (necessary for the login system)
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Makes sure the script goes on only if the user is logged in and is
// a company manager.
checkIfCompanyManager();

// Makes sure a branch manager id is defined, otherwise ends the script
if (  getHttpGet( 'id' ) === null ) {
  $noIdMessage = 'Error: You have not specified any product id.';
  $noIdTitle = 'No Id Specified';
  displayMessagePage( $noIdMessage, $noIdTitle );
}

// Puts the connection to the database in a variable
$db = Database::getConnection();

// Makes sure the specified id corresponds to an existing branch manager
$countSql = '
  SELECT COUNT(*)
  FROM   Product
  WHERE  ProductId = ?;
';
try {
  $countRequest = $db->prepare( $countSql );
  $countSuccess  = $countRequest->execute( array( getHttpGet( 'id' ) ) );
  if ( $countSuccess === false ) {
    throw new Exception( 'Error: Could not check that there is a product with this id.' );
  }
  $count = $countRequest->fetch()[0];
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( $countRequest->closeCursor() !== null ) {
    $countRequest->closeCursor();
  }
}
if ( $count != 1 ) {
  $noProductTitle = 'Product doesn\'t exist';
  $noProductMessage = 'No product with the specified Id exist.';
  displayMessagePage( $noProductMessage, $noProductTitle );
}

// Deletes the product
$delSql = '
  DELETE 
  FROM   Product
  WHERE  ProductId = ?;
';
try {
  $deleteRequest = $db->prepare( $delSql );
  $deleteSuccess = $deleteRequest->execute( array( getHttpGet( 'id' ) ) );
  if ( $deleteSuccess === false ) {
    throw new Exception( 'Error: The product could not be deleted.' );
  }
  $title = 'Product Deleted';
  $message = 'The product #' . getHttpGet( 'id' ) . ' has been deleted.';
  displayMessagePage( $message, $title );
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( $deleteRequest->closeCursor() !== null ) {
    $deleteRequest->closeCursor();
  }
}