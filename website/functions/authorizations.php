<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/BranchManagerModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/CompanyManagerModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/SalesAssistantModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/SessionLogin.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/functions/html.php' );

/**
 * This function checks that the user is logged-in and is a company manager, or otherwise 
 * stops the running script and outputs an error.
 * SHALL BE CALLED BEFORE ANY OUTPUT.
 */
function checkIfCompanyManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $isAdmin = CompanyManagerModel::isCompanyManager( SessionLogin::getUsername() );
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
    $isSalesAssistant = SalesAssistantModel::isSalesAssistant( SessionLogin::getUsername() );
    $isBranchManager = BranchManagerModel::isBranchManager( SessionLogin::getUsername() );
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