<?php
session_start();

require( 'classes/stores/SalesAssistant.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

if ( getHttpGet( 'id' ) == null ) {
  $error = 'no sales assistant id specified';
  displayMessagePage( $error, $error );
}
$sa = new SalesAssistant();

$sa->setSalesAssistantId( getHttpGet( 'id' ) );
try {
  $sql = '
    SELECT *
    FROM   SalesAssistant
    WHERE  SalesAssistantId = ?;
  ';
  $parameters = array( getHttpGet( 'id' ) );
  $rs = Database::query( $sql, $parameters )->fetchAll();
  if ( sizeof( $rs ) != 1 ) {
    $error = 'no sales assistant with this id';
    displayMessagePage( $error, $error );
  }
  $sa->setPersonId( $rs[0]['PersonId'] );
  $sa->setBranchId( $rs[0]['BranchId'] );
  $sa->setWage( $rs[0]['Wage'] );
  $sa->setSortCode( $rs[0]['SortCode'] );
  $sa->setAccountNumber( $rs[0]['AccountNumber'] );
  $title = 'Update Sales Assistant';
  $actionUrl = 'manage-sales-assistant.php?id=' .
    $sa->getBranchManagerId();
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage );
}

$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  if ( getPost( 'person-id' ) != null ) {
    try {
      $sa->setPersonId( getPost( 'person-id' ) );
    }
    catch ( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'wage' ) != null ) {
    try {
      $sa->setWage( getPost( 'wage' ) );
    }
    catch ( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'branch-id' ) != null ) {
    try {
      $sa->setBranchId( getPost( 'branch-id' ) );
    }
    catch( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( $isValid ) {
    try {
      $sql = '
        UPDATE SalesAssistant
        SET    PersonId = ?,
               BranchId = ?,
               Wage = ?,
               SortCode = ?,
               AccountNumber = ?
        WHERE  SalesAssistantId = ?;
      ';
      $parameters = array(
        $sa->getPersonId(),
        $sa->getBranchId(),
        $sa->getWage(),
        $sa->getSortCode(),
        $sa->getAccountNumber(),
        getHttpGet( 'id' )
      );
      Database::query( $sql, $parameters );
      $title = 'Sales Assistant Updated';
      $message = 'You successfully updated this branch manager\'s 
        details';
      displayMessagePage( $message, $title );
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
    <title><?php echo( $title ) ?></title>
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
              type="text" value="<?php echo( $sa->getPersonId() ) ?>" 
              />
          </td>
        </tr>
        <tr>
          <td>
            <label for="branch-id" form="form">Branch Id</label>
          </td>
          <td>
            <input form="form" id="branch-id" name="branch-id" type="text" value="<?php echo( $sa->getBranchId() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="wage" form="form">Wage</label>
          </td>
          <td>
            <input form="form" id="wage" name="wage" type="text" value="<?php echo( $sa->getWage() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>Sort Code</td>
          <td><?php echo( $sa->getSortCode() ) ?></td>
        </tr>
        <tr>
          <td>Account Number</td>
          <td><?php echo( $sa->getAccountNumber() ) ?></td>
        </tr>
      </table>
      <form action="<?php echo( $actionUrl ) ?>" id="form" method="POST">
        <button type="submit">Update</button>
        <a href="delete-sales-assistant.php?id=<?php echo( $sa->getSalesAssistantId() ) ?>">Delete</a>
      </form>
    </main>
  </body>
</html>