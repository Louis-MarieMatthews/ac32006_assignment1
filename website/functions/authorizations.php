<?php

/**
 * This function checks that the user is logged-in and is a company manager, or otherwise 
 * stops the running script and outputs an error.
 * SHOULD BE CALLED BEFORE ANY OUTPUT.
 */
function checkIfCompanyManager() {
  if ( SessionLogin::isLoggedIn() ) {
    $isAdmin = CompanyManagerUserModel::isCompanyManager( SessionLogin::getUsername() );
  }
  else {
    $isAdmin = false;
  }
  if ( ! $isAdmin ) {
    //TODO: redirect / include a you're not authorized page
    echo( '<p>You are not authorized to see this page.</p>' );
    die();
  }
}