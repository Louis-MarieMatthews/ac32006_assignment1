<?php
session_start();

require( 'classes/BranchModel.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

if ( ! isset( $_GET['id'] ) ) {
  displayMessagePage( 'No branch id have been specified.', 'No Branch Id' );
  die();
}

$branch = new BranchModel();
$branch->setBranchId( $_GET['id'] );
try {
  $branch->remove();
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