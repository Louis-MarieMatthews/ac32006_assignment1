<?php
// Starts the session to enable login features
session_start();

// Dependencies
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );
require_once( 'classes/Database.php' );
require_once( 'classes/stores/Branch.php' );

// Checks that the user is logged-in and that they are a company
// manager.
checkIfCompanyManager();

// Process potential sent data
$formErrors = array();
$branch  = new Branch;
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  try {
    $branch->setName( $_POST['name'] );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setAddress( $_POST['address'] );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setPostcode( $_POST['postcode'] );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setCity( $_POST['city'] );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  if ( $isValid ) {
    try {
      $sql = '
        INSERT
        INTO   Branch ( Name, Address, Postcode, City )
        VALUES ( ?, ?, ?, ? );
      ';
      $params = array(
        $branch->getName(),
        $branch->getAddress(),
        $branch->getPostcode(),
        $branch->getCity() );
      Database::query( $sql, $params );
      $title = 'Branch Successfully Added';
      $message = 'The branch ' . $branch->getName() . ' has been 
        successfully added.';
      displayMessagePage( $message, $title );
    }
    catch ( PDOException $e ) {
      $formErrors[] = 'An unexpected error happened. Sorry.';
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Add New Branch</title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <tr>
          <td>
            <label for="name" form="form">Name</label>
          </td>
          <td>
            <input form="form" id="name" name="name" type="text"
            value="<?php echo( $branch->getName() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="address" form="form">Address</label>
          </td>
          <td>
            <input form="form" id="address" name="address" type="text"
            value="<?php echo( $branch->getAddress() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label  for="postcode" form="form">Postcode</label>
          </td>
          <td>
            <input form="form" id="postcode" name="postcode"
            type="text"
            value="<?php echo( $branch->getPostcode() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="city" form="form">City</label>
          </td>
          <td>
            <input form="form" id="city" name="city" type="text"
            value="<?php echo( $branch->getCity() ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Add new branch</button>
      </form>
    </main>
  </body>
</html>