<?php
session_start();

// TODO: (important) display a confirmation button

require( 'classes/stores/Branch.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

if ( ! isset( $_GET['id'] ) ) {
  displayMessagePage( 'No branch id have been specified.', 'No Branch Id' );
  die();
}

$branch = new Branch();
$branch->setBranchId( $_GET['id'] );
try {
  $sql = '
    DELETE
    FROM   Branch
    WHERE  BranchId = ?;
  ';
  $parameters = array( $_GET['id'] );
  Database::query( $sql, $parameters );
}
catch( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
  die();
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Branch <?php $branch->getBranchId() ?> has been Deleted</title>
  </head>
  <body>
    <main>
      <h1>Branch <?php $branch->getBranchId() ?> has been Deleted</h1>
      <p>Branch <?php $branch->getBranchId() ?> has been deleted</p>
    </main>
  </body>
</html>