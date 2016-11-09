<?php
session_start();

require_once( 'classes/Database.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

checkIfCompanyManager();
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Employees of SportsScotland</title>
  </head>
  <body>
    <main>
      <?php
      $bmSql = '
        SELECT *
        FROM   BranchManager
        INNER JOIN Person
        ON BranchManager.PersonId = Person.PersonId;
      ';
      $bm = Database::getConnection()->query( $bmSql )
        ->fetchAll();
      displayPersons( $bm, 'Branch Managers' );
        
      $cmSql = '
        SELECT *
        FROM   CompanyManager
        INNER JOIN Person
        ON CompanyManager.PersonId = Person.PersonId;
      ';
      $cm = Database::getConnection()->query( $cmSql )
        ->fetchAll();
      displayPersons( $cm, 'Company Managers' );
      
      $saSql = '
        SELECT *
        FROM   SalesAssistant
        INNER JOIN Person
        ON SalesAssistant.PersonId = Person.PersonId;
      ';
      $sa = Database::getConnection()->query( $saSql )
        ->fetchAll();
      displayPersons( $sa, 'Sales Assistants' );
      ?>
    </main>
  </body>
</html>