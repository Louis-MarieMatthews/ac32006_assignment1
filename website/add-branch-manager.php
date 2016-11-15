<?php
session_start();

require_once( 'classes/stores/BranchManager.php' );
require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );

checkIfCompanyManager();

$formErrors = array();

$bm = new BranchManager;
$isValid = true;
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  try {
    $bm->setPersonId( getPost( 'person-id' ) );
  }
  catch ( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $bm->setWage( getPost( 'wage' ) );
  }
  catch ( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $bm->setBranchId( getPost( 'branch-id' ) );
  }
  catch( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $sql = '
      INSERT INTO BranchManager ( PersonId, BranchId, Wage, SortCode,
        AccountNumber )
      VALUES ( ?, ?, ?, ?, ? );
    ';
    $parameters = array(
      $bm->getPersonId(),
      $bm->getBranchId(),
      $bm->getWage(),
      $bm->getSortCode(),
      $bm->getAccountNumber()
    );
    Database::query( $sql, $parameters );
    $title = 'New Branch Manager Added';
    $message = 'You successfully added the details of a nez
      branch manager.';
    displayMessagePage( $message, $title );
  }
  catch( Exception $e ) {
    $formErrors[] = $e->getMessage();
  }
}
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Add New Branch Manager</title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <tr>
          <td>
            <label for="person-id" form="form">Person Id</label>
          </td>
          <td>
            <input form="form" id="person-id" name="person-id" 
              type="text" value="<?php echo( $bm->getPersonId() ) ?>"/>
          </td>
        </tr>
        <tr>
          <td>
            <label for="branch-id" form="form">Branch Id</label>
          </td>
          <td>
            <input form="form" id="branch-id" name="branch-id" type="text"
            value="<?php echo( $bm->getBranchId() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="wage" form="form">Wage</label>
          </td>
          <td>
            <input form="form" id="wage" name="wage" type="text" 
            value="<?php echo( $bm->getWage() ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Update</button>
      </form>
    </main>
  </body>
</html>