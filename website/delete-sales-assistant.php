<?php

// Activate sessions (necessary for the login system
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Makes sure the script goes on only if the user is logged in and is
// a company manager.
checkIfCompanyManager();

// Makes sure a sales assistant id is defined, otherwise ends the script
if (  getHttpGet( 'id' ) === null ) {
  displayMessagePage( 'no sales assistant id specified' );
}

// Makes sure the specified id corresponds to an existing branch manager
$countSql = '
  SELECT COUNT(*)
  FROM   SalesAssistant
  WHERE  SalesAssistantId = ?;
';
$results = Database::query( $countSql, array( getHttpGet( 'id' ) ) );
$count = $results->fetch()[0];
if ( $count != 1 ) {
  $message = 'no sales assistant with the specified id';
  displayMessagePage( $message, $message );
}

//Deletes the branch
$delSql = '
  DELETE 
  FROM   SalesAssistant
  WHERE  SalesAssistantId = ?;
';
$db = Database::getConnection();
$request = $db->prepare( $delSql );
$success = $request->execute( array( getHttpGet( 'id' ) ) );
if ( $success ) {
  $message = 'Sales Assistant Deleted';
  displayMessagePage( $message, $message );
}
else {
  $message = 'Problem happened, the sales assistant has not been 
    deleted';
  displayMessagePage( $message, $message );
}