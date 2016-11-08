<?php
session_start();

require( 'classes/BranchModel.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

if ( ! isset( $_GET['id'] ) ) {
  displayMessagePage( 'No branch id have been specified.', 'No Branch Id' );
  die();
}

$branch = new BranchModel();
$branch->setBranchId( $_GET['id'] );
try {
  $branch->fetch();
}
catch( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage() );
  die();
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
    $branch->update();
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
      <form action="manage-branches.php?id=<?php echo( $branch->getBranchId() ) ?>" id="form" method="POST">
        <button type="submit">Submit</button>
      </form>
    </main>
  </body>
</html>