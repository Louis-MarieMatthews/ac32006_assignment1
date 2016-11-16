<?php

// Enables login functionalities
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks if company manager
checkIfCompanyManager();

// Checks if id is defined
if ( getHttpGet( 'id' ) == null ) {
  $title = 'No Supplier Id Given';
  $message = 'You have not supplied any supplier id';
  displayMessagePage( $message, $title );
}

// Processes the request
$delSql = '
  DELETE 
  FROM   Supplier
  WHERE  SupplierId = ?;
';
$delParams = array( getHttpGet( 'id' ) );
try {
  $db = Database::getConnection();
  $delRequest = $db->prepare( $delSql );
  $success = $delRequest->execute( $delParams );
  if ( $success === false ) {
    throw new Exception( 'Error: The supplier has not been deleted due to an unexpected error.' );
  }
  $title = 'Supplier Deleted';
  $message = 'The supplier has been deleted successfully.';
  displayMessagePage( $message, $title );
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( isset( $delRequest ) ) {
    $delRequest->closeCursor();
  }
}