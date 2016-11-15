<?php
session_start();

require( 'classes/stores/Branch.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

$branch = new Branch();

if ( isset( $_GET['id'] ) ) {
  $branch->setBranchId( $_GET['id'] );
  try {
    $sql = '
      SELECT Name, Address, Postcode, City
      FROM   Branch
      WHERE  BranchId = ?;
    ';
    $parameters = array( $_GET['id'] );
    $rs = Database::query( $sql, $parameters )->fetchAll();
    if ( sizeof( $rs ) !== 1 ) {
      throw new Exception();
    }
    $branch->setName( $rs[0]['Name'] );
    $branch->setAddress( $rs[0]['Address'] );
    $branch->setPostcode( $rs[0]['Postcode'] );
    $branch->setCity( $rs[0]['City'] );
    $actionUrl = '?id=' . $_GET['id'];
  }
  catch( Exception $e ) {
    $error = 'Branch ' . $_GET['id'] . ' does not exist';
    displayMessagePage( $error, $error );
  }
}
else {
  $title = 'No Branch Id Specified';
  $message = 'You have not specified any branch id';
  displayMessagePage( $message, $title );
}



$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  try {
    $branch->setName( getPost( 'name' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setAddress( getPost( 'address' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setPostcode( getPost( 'postcode' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setCity( getPost( 'city' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  if ( $isValid ) {
    try {
      $sql = '
        UPDATE Branch
        SET    Name = ?,
               Address = ?,
               Postcode = ?,
               City = ?
        WHERE  BranchId = ?
      ';
      $parameters = array(
        $branch->getName(),
        $branch->getAddress(),
        $branch->getPostcode(),
        $branch->getCity(),
        $branch->getBranchId()
      );
      Database::query( $sql, $parameters );
      $title = 'Branch Updated Successfully';
      $message = 'Branch #' . $branch->getBranchId() . ' has been ' .
        'updated successfully!';
      displayMessagePage( $title, $message );
    }
    catch( Exception $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
}


?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Manage Branch #<?php echo( $branch->getBranchId() ) ?></title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ); ?>
      <table>
        <caption>Branch <?php echo( $branch->getBranchId() ) ?></caption>
        <tr>
          <td>
              Branch Id
          </td>
          <td>
            <?php echo( $branch->getBranchId() ) ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="name" form="form">
              Name
            </label></td>
          <td>
            <input form="form" id="name" name="name" type="text" value="<?php echo( $branch->getName() ) ?>" /></td>
        </tr>
        <tr>
          <td>
            <label for="address" form="form">
              Address
            </label></td>
          <td>
            <input form="form" id="address" name="address" type="text" value="<?php echo( $branch->getAddress() ) ?>" /></td>
        </tr>
        <tr>
          <td>
            <label for="postcode" form="form">
              Postcode
            </label></td>
          <td>
            <input form="form" id="postcode" name="postcode" type="text" value="<?php echo( $branch->getPostcode() ) ?>" /></td>
        </tr>
        <tr>
          <td>
            <label for="city" form="form">
              City
            </label></td>
          <td>
            <input form="form" id="city" name="city" type="text" value="<?php echo( $branch->getCity() ) ?>" /></td>
        </tr>
      </table>
      <form action="<?php echo( $actionUrl ) ?>" id="form" method="POST">
        <button type="submit">Submit</button>
      </form>
        <a href="">Delete branch</a>
    </main>
  </body>
</html>