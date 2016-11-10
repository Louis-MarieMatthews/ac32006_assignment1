<?php
// Starts the session in order to enable login features
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Check that the user is logged-in and that they are a company 
// manager, otherwise display an access denied page and stops the 
// script.
checkIfCompanyManager();

// Fetch all the persons
$sql = '
  SELECT *
  FROM   Person
';
$persons = Database::getConnection()->query( $sql )->fetchAll();
$title = 'Persons';

?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Browse Persons</title>
  </head>
  <body>
    <main>
      <?php displayPersons( $persons, $title ) ?>
    </main>
  </body>
</html>