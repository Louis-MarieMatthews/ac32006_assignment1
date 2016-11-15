<?php
session_start();

require_once( 'classes/stores/SalesAssistant.php' );
require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );

checkIfCompanyManager();

$formErrors = array();

$sa = new SalesAssistant;
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  try {
    $sa->setPersonId( getPost( 'person-id' ) );
  }
  catch ( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $sa->setWage( getPost( 'wage' ) );
  }
  catch ( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $sa->setBranchId( getPost( 'branch-id' ) );
  }
  catch( IllegalFormatException $e ) {
    $isValid = false;
    $formErrors[] = $e->getMessage();
  }
  try {
    $sql = '
      INSERT INTO SalesAssistant ( PersonId, BranchId, Wage, SortCode,
        AccountNumber )
      VALUES ( ?, ?, ?, ?, ? );
    ';
    $parameters = array(
      $sa->getPersonId(),
      $sa->getBranchId(),
      $sa->getWage(),
      $sa->getSortCode(),
      $sa->getAccountNumber()
    );
    Database::query( $sql, $parameters );
    $title = 'New Sales Assistant Added';
    $message = 'You successfully added the details of a nez
      sales assistant.';
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
    <title>Add New Sales Assistant</title>
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
              type="text" value="<?php echo( $sa->getPersonId() ) ?>"/>
          </td>
        </tr>
        <tr>
          <td>
            <label for="branch-id" form="form">Branch Id</label>
          </td>
          <td>
            <input form="form" id="branch-id" name="branch-id" type="text"
            value="<?php echo( $sa->getBranchId() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="wage" form="form">Wage</label>
          </td>
          <td>
            <input form="form" id="wage" name="wage" type="text" 
            value="<?php echo( $sa->getWage() ) ?>" />
          </td>
        </tr>
      </table>
      <form action="#" id="form" method="POST">
        <button type="submit">Update</button>
      </form>
    </main>
  </body>
</html>