<?php
session_start();

require_once( 'classes/Database.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

checkIfEmployee();
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Customers</title>
  </head>
  <body>
    <main>
      <?php
      $sql = '
        SELECT *
        FROM   Customer
        INNER JOIN Person
        ON Customer.PersonId = Person.PersonId;
      ';
      $db = Database::getConnection();
      $request = $db->query( $sql );
      if ( $request === false ) {
        throw new Exception( 'Error: Can\'t fetch customers from the database.' );
      }
      $customers = $request->fetchAll();
      
      
      
      function td( $string, $customer ) {
        echo( '<td class="link-row"><a class="link-row" href="view-customer.php?id=' . $customer['CustomerId'] . '">' . $string . '</a></td>' );
      }
      ?>
      
      
      
      <table class="bordered-table" >
      <caption>Customers</caption>
      <thead>
        <tr>
          <td>Person Id</td>
          <td>Customer Id</td>
          <td>Username</td>
          <td>First Name</td>
          <td>Last Name</td>
          <td>Address</td>
          <td>Postcode</td>
          <td>City</td>
          <td>Telephone</td>
          <td>Email</td>
        </tr>
        </thead>
        <?php foreach( $customers as $customer ) : ?>
        <tr class="link-row">
          <?php td( $customer['PersonId'], $customer ) ?>
          <?php td( $customer['CustomerId'], $customer ) ?>
          <?php td( $customer['UserId'], $customer ) ?>
          <?php td( $customer['FirstName'], $customer ) ?>
          <?php td( $customer['LastName'], $customer ) ?>
          <?php td( $customer['Address'], $customer ) ?>
          <?php td( $customer['Postcode'], $customer ) ?>
          <?php td( $customer['City'], $customer ) ?>
          <?php td( $customer['Telephone'], $customer ) ?>
          <?php td( $customer['Email'], $customer ) ?>
        </tr>
        <?php endforeach ?>
      </table>
    </main>
  </body>
</html>