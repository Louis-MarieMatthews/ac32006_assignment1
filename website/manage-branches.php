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
      WHERE  BranchId = ?
    ';
    $parameters = array( $_GET['id'] );
    $rs = Database::query( $sql, $parameters )->fetchAll();
    if ( sizeof( $rs ) < 1 ) {
      throw new Exception();
    }
    $branch->setName( $rs['name'] );
    $branch->setAddress( $rs['address'] );
    $branch->setPostcode( $rs['postcode'] );
    $branch->setCity( $rs['city'] );
    $update = true;
    $actionUrl = 'manage-branches.php?id=' . $_GET['id'];
  }
  catch( Exception $e ) {
    $error = 'Branch ' . $_GET['id'] . ' does not exist';
    displayMessagePage( $error, $error );
    die();
  }
}
else {
  $update = false;
  $actionUrl = 'manage-branches.php';
}



$formErrors = array();
if ( getPost( 'name' ) != null &
     getPost( 'address' ) != null &
     getPost( 'postcode' ) != null &
     getPost( 'city' ) != null ) {
  $isValid = true;
  try {
    $branch->setName( getPost( 'name' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setAddress( getPost( 'address' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setPostcode( getPost( 'postcode' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  try {
    $branch->setCity( getPost( 'city' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
  if ( $isValid ) {
    try {
      if ( $update ) {
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
          $branch->getCity,
          $branch->getBranchId()
        );
        Database::query( $sql, $parameters )->fetchAll()[0];
        $title = 'Branch Updated Successfully';
        $message = 'Branch #' . $branch->getBranchId() . ' has been' .
          'updated successfully!';
        displayMessagePage( $title, $message );
        die();
      }
      else {
        $sql = '
          INSERT
          INTO   Branch ( Name, Address, Postcode, City )
          VALUES ( ?, ?, ?, ? );
        ';
        $parameters = array(
          $branch->getName(),
          $branch->getAddress(),
          $branch->getPostcode(),
          $branch->getCity()
        );
        Database::query( $sql, $parameters );
        $title = 'Branch Created Successfully';
        $message = $branch->getName() . ' has been created ' .
          'successfully!';
        displayMessagePage( $message, $title );
        die();
      }
    }
    catch( Exception $e ) {
      displayMessagePage( $e->getMessage(), $e->getMessage() );
      die();
    }
  }
}


?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Manage branch <?php echo( $branch->getBranchId() ) ?></title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ); ?>
      <table>
        <?php if ( $update ) : ?>
        <caption>Branch <?php echo( $branch->getBranchId() ) ?></caption>
        <tr>
          <td>
              Branch Id
          </td>
          <td>
            <?php echo( $branch->getBranchId() ) ?>
          </td>
        </tr>
        <?php else : ?>
        <caption>New Branch</caption>
        <?php endif ?>
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
      <?php
      if ( $update ) {
        ?>
        <a href="">Delete branch</a>
        <?php
      }
      ?>
    </main>
  </body>
</html>