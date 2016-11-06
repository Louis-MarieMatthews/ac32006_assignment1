<?php

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