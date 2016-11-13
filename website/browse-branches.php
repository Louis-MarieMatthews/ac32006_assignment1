<?php

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/html.php' );

// TODO: add LIMIT and pagination

$sql = '
  SELECT *
  FROM   Branch;
';
$branches = Database::getConnection()->query( $sql )->fetchAll();

?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Browse Branches</title>
  </head>
  <body>
    <main>
      <table class="bordered-table">
        <thead>
          <tr>
            <td>Branch Id</td>
            <td>Name</td>
            <td>Address</td>
            <td>Postcode</td>
            <td>City</td>
          </tr>
        </thead>
        <?php for ( $i = 0; $i < sizeof( $branches ); $i++ ) : ?>
        <tr>
          <td><?php echo( $branches[ $i ]['BranchId'] ) ?></td>
          <td><?php echo( $branches[ $i ]['Name'] ) ?></td>
          <td><?php echo( $branches[ $i ]['Address'] ) ?></td>
          <td><?php echo( $branches[ $i ]['Postcode'] ) ?></td>
          <td><?php echo( $branches[ $i ]['City'] ) ?></td>
        </tr>
        <?php endfor ?>
      </table>
    </main>
  </body>
</html>