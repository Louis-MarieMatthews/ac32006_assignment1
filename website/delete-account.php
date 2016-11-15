<?php

session_start();

require_once( 'classes/Database.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

checkIfCustomer();

$db = Database::getConnection();


$deleteCustomer = $db->prepare("DELETE FROM Customer WHERE PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );" );
$deleteCustomer->execute(array(SessionLogin::getUsername()));
$deleteCustomer->closeCursor();

$deletePersonal = $db->prepare(" DELETE FROM Person WHERE UserId = ?");
$deletePersonal->execute(array(SessionLogin::getUsername()));
$deletePersonal->closeCursor();


$deleteAccount = $db->prepare( " DELETE FROM User WHERE UserId = ?");
$deleteAccount->execute(array(SessionLogin::getUsername()));


session_destroy();

displayMessagePage( 'Your account has been deleted','Account Deleted' );