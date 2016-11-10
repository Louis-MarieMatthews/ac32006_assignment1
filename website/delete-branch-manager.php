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

// Makes sure a branch manager id is defined, otherwise ends the script
if (  getHttpGet( 'id' ) === null ) {
  displayMessagePage( 'no branch manager id specified' );
}

// Makes sure the specified id corresponds to an existing branch manager
$countSql = '
  SELECT COUNT(*)
  FROM   BranchManager
  WHERE  BranchManagerId = ?;
';
$results = Database::query( $countSql, array( getHttpGet( 'id' ) ) );
$count = $results->fetch()[0];
if ( $count != 1 ) {
  $message = 'no branch manager with the specified id';
  displayMessagePage( $message, $message );
}

//Deletes the branch
$delSql = '
  DELETE 
  FROM   BranchManager
  WHERE  BranchManagerId = ?;
';
$db = Database::getConnection();
$request = $db->prepare( $delSql );
$success = $request->execute( array( getHttpGet( 'id' ) ) );
if ( $success ) {
  $message = 'Branch manager deleted';
  displayMessagePage( $message, $message );
}
else {
  $message = 'Problem happened, the branch manager 
    has not been deleted';
  displayMessagePage( $message, $message );
}