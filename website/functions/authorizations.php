<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/BranchManagerUserModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/CompanyManagerUserModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/SalesAssistantUserModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/SessionLogin.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/functions/html.php' );

/**
 * This function checks that the user is logged-in and is a company manager, or otherwise 
 * stops the running script and outputs an error.
 * SHALL BE CALLED BEFORE ANY OUTPUT.
 */
function checkIfCompanyManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $isAdmin = CompanyManagerUserModel::isCompanyManager( SessionLogin::getUsername() );
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
    $isSalesAssistant = SalesAssistantUserModel::isSalesAssistant( SessionLogin::getUsername() );
    $isBranchManager = BranchManagerUserModel::isBranchManager( SessionLogin::getUsername() );
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