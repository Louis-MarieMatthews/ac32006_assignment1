<?php
require_once( 'classes/Database.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/html.php' );



function checkIfEmployee() {
  if ( ! isCompanyManager() & ! isBranchManager() & ! isSalesAssistant() ) {
    displayAccessDenied();
    die();
  }
}



function isCompanyManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $param = array( SessionLogin::getUsername() );
    $sql = '
      SELECT COUNT(*)
      FROM   CompanyManager
      WHERE  CompanyManager.PersonId =
      ( SELECT PersonId
        FROM Person
        WHERE UserId = ?
      );
    ';
    $cm = Database::query( $sql, $param );
    if ($cm->fetchAll()[0][0] != 1 ) {
      $isCompanyManager = false;
    }
    else {
      $isCompanyManager = true;
    }
  }
  else {
    $isCompanyManager = false;
  }
  return $isCompanyManager;
}



/**
 * This function checks that the user is logged-in and is a company manager, or otherwise 
 * stops the running script and outputs an error.
 * SHALL BE CALLED BEFORE ANY OUTPUT.
 */
function checkIfCompanyManager() {
  if ( ! isCompanyManager() ) {
    displayAccessDenied();
    die();
  }
}



function isBranchManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $param = array( SessionLogin::getUsername() );
    $sql = '
      SELECT COUNT(*)
      FROM   BranchManager
      WHERE  BranchManager.PersonId =
      ( SELECT PersonId
        FROM Person
        WHERE UserId = ?
      );
    ';
    $bm = Database::query( $sql, $param );
    if ( $bm->fetchAll()[0][0] != 1 ) {
      $isBranchManager = false;
    }
    else {
      $isBranchManager = true;
    }
  }
  else {
    $isBranchManager = false;
  }
  return $isBranchManager;
}



function checkIfBranchManager() {
  if ( ! isBranchManager() ) {
    displayAccessDenied();
    die();
  }
}



function isSalesAssistant() {
  if ( SessionLogin::isLoggedIn() ) {
    $saSql = '
      SELECT COUNT(*)
      FROM   SalesAssistant
      WHERE  SalesAssistant.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
    ';
    $param = array( SessionLogin::getUsername() );
    $sa = Database::query( $saSql, $param );
    if ( $sa->fetchAll()[0][0] != 1 ) {
      $isSalesAssistant = false;
    }
    else {
      $isSalesAssistant = true;
    }
  }
  else {
    $isSalesAssistant = true;
  }
  return $isSalesAssistant;
}



function checkIfSalesAssistant() {
  if ( ! isSalesAssistant() ) {
    displayAccessDenied();
    die();
  }
}



function checkIfCustomer() {
  if ( SessionLogin::isLoggedIn() ) {
    $cParams = array( SessionLogin::getUsername() );
    $cSql = '
      SELECT COUNT(*)
      FROM   Customer
      WHERE  PersonId =
      ( SELECT PersonId
        FROM   Person
        WHERE  UserId = ?
      );
    ';
    $c = Database::query( $cSql, $cParams );
    if ( $c->fetchAll()[0][0] != 1 ) {
      $isCustomer = false;
    }
    else {
      $isCustomer = true;
    }
  }
  else {
    $isCustomer = false;
  }
  if ( ! $isCustomer ) {
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