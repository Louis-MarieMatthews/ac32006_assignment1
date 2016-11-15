<?php
session_start();

require( 'classes/stores/BranchManager.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

if ( getHttpGet( 'id' ) == null ) {
  $error = 'no branch manager id specified';
  displayMessagePage( $error, $error );
}
$bm = new BranchManager();

$bm->setBranchManagerId( getHttpGet( 'id' ) );
try {
  $sql = '
    SELECT *
    FROM   BranchManager
    WHERE  BranchManagerId = ?;
  ';
  $parameters = array( getHttpGet( 'id' ) );
  $rs = Database::query( $sql, $parameters )->fetchAll();
  if ( sizeof( $rs ) != 1 ) {
    $error = 'no branch manager with this id';
    displayMessagePage( $error, $error );
  }
  $bm->setPersonId( $rs[0]['PersonId'] );
  $bm->setBranchId( $rs[0]['BranchId'] );
  $bm->setWage( $rs[0]['Wage'] );
  $bm->setSortCode( $rs[0]['SortCode'] );
  $bm->setAccountNumber( $rs[0]['AccountNumber'] );
  $title = 'Update Branch Manager';
  $actionUrl = 'manage-branch-manager.php?id=' .
    $bm->getBranchManagerId();
}
catch ( Exception $e ) {
  displayMessagePage( $e->getMessage(), $e->getMessage );
}

$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $isValid = true;
  if ( getPost( 'person-id' ) != null ) {
    try {
      $bm->setPersonId( getPost( 'person-id' ) );
    }
    catch ( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'wage' ) != null ) {
    try {
      $bm->setWage( getPost( 'wage' ) );
    }
    catch ( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'branch-id' ) != null ) {
    try {
      $bm->setBranchId( getPost( 'branch-id' ) );
    }
    catch( IllegalFormatException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( $isValid ) {
    try {
      $sql = '
        UPDATE BranchManager
        SET    PersonId = ?,
               BranchId = ?,
               Wage = ?,
               SortCode = ?,
               AccountNumber = ?
        WHERE  BranchManagerId = ?;
      ';
      $parameters = array(
        $bm->getPersonId(),
        $bm->getBranchId(),
        $bm->getWage(),
        $bm->getSortCode(),
        $bm->getAccountNumber(),
        getHttpGet( 'id' )
      );
      Database::query( $sql, $parameters );
      $title = 'Branch Manager Updated';
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
<!doctype>
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
              type="text" value="<?php echo( $bm->getPersonId() ) ?>" 
              />
          </td>
        </tr>
        <tr>
          <td>
            <label for="branch-id" form="form">Branch Id</label>
          </td>
          <td>
            <input form="form" id="branch-id" name="branch-id" type="text" value="<?php echo( $bm->getBranchId() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="wage" form="form">Wage</label>
          </td>
          <td>
            <input form="form" id="wage" name="wage" type="text" value="<?php echo( $bm->getWage() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>Sort Code</td>
          <td><?php echo( $bm->getSortCode() ) ?></td>
        </tr>
        <tr>
          <td>Account Number</td>
          <td><?php echo( $bm->getAccountNumber() ) ?></td>
        </tr>
      </table>
      <form action="<?php echo( $actionUrl ) ?>" id="form" method="POST">
        <button type="submit">Update</button>
        <a href="delete-branch-manager.php?id=<?php echo( $bm->getBranchManagerId() ) ?>">Delete</a>
      </form>
    </main>
  </body>
</html>