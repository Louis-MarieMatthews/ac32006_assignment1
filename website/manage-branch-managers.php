<?php
session_start();

require( 'classes/stores/BranchManager.php' );
require( 'functions/html.php' );
require( 'functions/authorizations.php' );

checkIfCompanyManager();

$bm = new BranchManager();
if ( getHttpGet( 'id' ) == null ) {
  $createBranchManager = true;
  $title = 'New Branch Manager';
  $actionUrl = 'manage-branch-managers.php';
}
else {
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
      die();
    }
    $bm->setPersonId( $rs['PersonId'] );
    $bm->setBranchId( $rs['BranchId'] );
    $bm->setWage( $rs['Wage'] );
    $bm->setSortCode( $rs['SortCode'] );
    $bm->setAccountNumber( $rs['AccountNumber'] );
    $createBranchManager = false;
    $title = 'Update Branch Manager';
    $actionUrl = 'manage-branch-managers.php?id=' .
      $bm->getBranchManagerId();
  }
  catch ( Exception $e ) {
    displayMessagePage( $e->getMessage(), $e->getMessage );
    die();
  }
}

$formErrors = array();
if ( getPost( 'wage' ) != null &
  getPost( 'branch-id' ) != null &
  getPost( 'person-id' ) != null ) {
  $isValid = true;
  if ( getPost( 'person-id' ) != null ) {
    try {
      $bm->setPersonId( getPost( 'person-id' ) );
    }
    catch ( DomainException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'wage' ) != null ) {
    try {
      $bm->setWage( getPost( 'wage' ) );
    }
    catch ( DomainException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'branch-id' ) != null ) {
    try {
      $bm->setBranchId( getPost( 'branch-id' ) );
    }
    catch( DomainException $e ) {
      $isValid = false;
      $formErrors[] = $e->getMessage();
    }
  }
  if ( $isValid ) {
    if ( $createBranchManager ) {
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
        die();
      }
      catch( Exception $e ) {
        $formErrors[] = $e->getMessage();
      }
    }
    else {
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
        die();
      }
      catch( Exception $e ) {
        $formErrors[] = $e->getMessage();
      }
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
      </form>
    </main>
  </body>
</html>