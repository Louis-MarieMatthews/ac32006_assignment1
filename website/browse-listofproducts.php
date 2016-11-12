<?php
session_start();

require_once( 'classes/Database.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'classes/stores/Product.php' );
require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );
?>
<!doctype=html!>
<html>
<head>
 <?php displayHead(); ?>
    <title>Products of SportsScotland</title>
</head>
<body>
  <main>
    <?php
    
    $pSql = '
        SELECT *
        FROM   Product
      ';
      $p = Database::getConnection()->query( $pSql )
        ->fetchAll();
      displayProducts( $p, 'Products' );
    ?>
  </main>
</body>
</html>



