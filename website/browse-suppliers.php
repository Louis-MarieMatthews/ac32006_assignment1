<?php

// Starts session. Necessary to enable login functionalities.
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks if company manager
checkIfCompanyManager();

// Connection
$db = Database::getConnection();

// Fetches suppliers
$sql = '
  SELECT *
  FROM   Supplier;
';
try {
  $request = $db->query( $sql );
  $suppliers = $request->fetchAll();
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( isset( $request ) ) {
    $request->closeCursor();
  }
}
      
      
      
function td( $string, $supplier ) {
echo( '<td class="link-row"><a class="link-row" href="view-supplier.php?id=' . $supplier['SupplierId'] . '">' . $string . '</a></td>' );
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Browse Suppliers</title>
  </head>
  <body>
    <main>
      <table class="bordered-table">
        <caption>Browse Suppliers</caption>
        <thead>
          <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Telephone</td>
          </tr>
        </thead>
        <?php foreach( $suppliers as $supplier ) : ?>
        <tr>
          <?php td( $supplier['SupplierId'], $supplier ) ?>
          <?php td( $supplier['Name'], $supplier ) ?>
          <?php td( $supplier['Telephone'], $supplier ) ?>
        </tr>
        <?php endforeach ?>
      </table>
    </main>
  </body>
</html>