<?php

require_once( '/classes/Database.php' );
require_once( '/classes/SessionLogin.php' );
require_once( '/functions/html.php' );

/**
 * This function checks that the user is logged-in and is a company manager, or otherwise 
 * stops the running script and outputs an error.
 * SHALL BE CALLED BEFORE ANY OUTPUT.
 */
function checkIfCompanyManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $countSql = '
      SELECT COUNT(*)
      FROM   CompanyManager
      WHERE  CompanyManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
    ';
    $parameters = array( SessionLogin::getUsername() );
    $rs = Database::query( $countSql, $parameters )->fetch();
    if ( $rs[0] == 1 ) {
      $isAdmin = true;
    }
    else {
      $isAdmin = false;
    }
  }
  else {
    $isAdmin = false;
  }
  if ( ! $isAdmin ) {
    displayAccessDenied();
    die();
  }
}



function checkIfEmployee() {
  if ( SessionLogin::isLoggedIn() ) {
    $parameters = array( SessionLogin::getUsername() );
    $bmSql = '
      SELECT COUNT(*)
      FROM   BranchManager
      WHERE  BranchManager.PersonId =
      ( SELECT PersonId
        FROM Person
        WHERE UserId = ?
      );
    ';
    $bm = Database::query( $bmSql, $parameters );
    if ( $bm->fetchAll()[0][0] != 1 ) {
      $isBranchManager = false;
    }
    else {
      $isBranchManager = true;
    }
    $saSql = '
      SELECT COUNT(*)
      FROM   SalesAssistant
      WHERE  SalesAssistant.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
    ';
    $sa = Database::query( $saSql, $parameters );
    if ( $sa->fetchAll()[0][0] != 1 ) {
      $isSalesAssistant = false;
    }
    else {
      $isSalesAssistant = true;
    }
    $isEmployee = $isSalesAssistant | $isBranchManager;
  }
  else {
    $isEmployee = false;
  }
  if ( ! $isEmployee ) {
    displayAccessDenied();
    die();
  }
}



function checkIfNotLoggedIn() {
  if ( SessionLogin::isLoggedIn() ) {
    displayAccessDenied();
    die();
  }
}