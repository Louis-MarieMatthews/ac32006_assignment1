<?php
// Starts session. Necessary to enable login functionalities.
session_start();

// Dependencies
require_once( 'classes/Database.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

// Checks that the user is logged-in and is an employee
checkIfEmployee();

// Checks if the customer id is set.
if ( getHttpGet( 'id' ) == null ) {
  $title = 'No Customer Id';
  $message = 'You have not provided any customer id.';
  displayMessagePage( $message, $title );
}

// Saves the connection to the database in a local variable
$db = Database::getConnection();

// Checks if the current request is a post request, and if so, process
// it accordingly.
$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $updateSql = '
    UPDATE Customer
    SET    Notes = ?
    WHERE  CustomerId = ?;
  ';
  $updateParams = array( getPost( 'notes' ), getHttpGet( 'id' ) );
  try {
    $updateRequest = $db->prepare( $updateSql );
    $success = $updateRequest->execute( $updateParams );
    if ( $success === false ) {
      throw new Exception( 'Error: The customer could not be updated' );
    }
  }
  catch ( Exception $e ) {
    $formErrors[] = $e->getMessage();
  }
  finally {
    if ( $updateRequest != null ) {
      $updateRequest->closeCursor();
    }
  }
}

// Fetches the customer
$selectSql = '
  SELECT *
  FROM   Customer
  INNER JOIN Person
  ON Customer.PersonId = Person.PersonId
  WHERE  CustomerId = ?;
';
$selectParams = array( getHttpGet( 'id' ) );
try {
  $selectRequest = $db->prepare( $selectSql );
  $success = $selectRequest->execute( $selectParams );
  if ( ! $success ) {
    throw new Exception( 'Error: The system could not search for customers.' );
  }
  $customer = $selectRequest->fetch();
  if ( $customer == null ) {
    throw new Exception( 'Error: There is no customer with this id.' );
  }
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
}
finally {
  if ( isset( $selectRequest ) ) {
    $selectRequest->closeCursor();
  }
}
$title = 'Customer #' . $customer['CustomerId'];
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title><?php echo( $title ) ?></title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <caption><?php echo( $title ) ?></caption>
        <tr>
          <td>
            Person Id
          </td>
          <td>
            <?php echo( $customer['PersonId'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Customer Id
          </td>
          <td>
            <?php echo( $customer['CustomerId'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Username
          </td>
          <td>
            <?php echo( $customer['UserId'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            First Name
          </td>
          <td>
            <?php echo( $customer['FirstName'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Last Name
          </td>
          <td>
            <?php echo( $customer['LastName'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Address
          </td>
          <td>
            <?php echo( $customer['Address'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Postcode
          </td>
          <td>
            <?php echo( $customer['Postcode'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            City
          </td>
          <td>
            <?php echo( $customer['City'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Telephone
          </td>
          <td>
            <?php echo( $customer['Telephone'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Email
          </td>
          <td>
            <?php echo( $customer['Email'] ) ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="notes" form="form">Notes</label>
          </td>
          <td>
            <input form="form" id="notes" name="notes" type="text" value="<?php echo( $customer['Notes'] ) ?>" />
          </td>
        </tr>
      </table> 
      <form action="#" id="form" method="POST">
        <button type="submit">Update notes</button>
      </form>
    </main>
  </body>
</html>