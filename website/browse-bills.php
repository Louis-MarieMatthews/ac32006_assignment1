<?php

// Enable login
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks employee
checkIfEmployee();

// Fetches bills
$selSql = '
  SELECT *
  FROM   Bill;
';
try {
  $db = Database::getConnection();
  $selRequest = $db->query( $selSql );
  $bills = $selRequest->fetchAll();
}
catch( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( isset( $selRequest ) ) {
    $selRequest->closeCursor();
  }
}

?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>View Bills</title>
  </head>
  <body>
    <main>
      <table class="bordered-table">
        <caption>View Bills</caption>
        <thead>
          <tr>
            <td>Bill Id</td>
            <td>Customer Id</td>
            <td>Sales Assistant Id</td>
            <td>Date Billed</td>
            <td>Total Price</td>
          </tr>
        </thead>
        <?php foreach( $bills as $bill ) : ?>
        <tr>
          <td><?php echo( $bill['BillId'] ) ?></td>
          <td><?php echo( $bill['CustomerId'] ) ?></td>
          <td><?php echo( $bill['SalesAssistantId'] ) ?></td>
          <td><?php echo( $bill['DateBilled'] ) ?></td>
          <td><?php echo( $bill['TotalPrice'] ) ?></td>
        </tr>
        <?php endforeach ?>
      </table>
    </main>
  </body>
</html>