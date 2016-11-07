<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/AccountNumber.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/SortCode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/UserModel.php' );

class BranchManagerUserModel extends UserModel
{
  private $username;
  private $personId;
  private $accountNumber;
  private $branchId;
  private $branchManagerId;
  private $sortCode;
  private $wage;
  
  
  
  public function __construct() {
  }
  
  
  
  public function set( string $username, int $personId, string $accountNumber, int $branchId,
                       int $branchManagerId, string $sortCode, float $wage )
  {
    $this->username = $username;
    $this->accountNumber = new AccountNumber( $accountNumber );
    $this->branchId = $branchId;
    $this->branchManagerId = $branchManagerId;
    $this->personId = $personId;
    $this->sortCode = new SortCode( $sortCode );
    $this->wage = $wage;
  }
  
  
  
  public static function isBranchManager( string $username ) : bool {
    $query = '
      SELECT BranchManager.BranchManagerId
      FROM   BranchManager
      WHERE  BranchManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public static function getAllBranchManagers() : array {
    $query = '
      SELECT *
      FROM   BranchManager
      INNER JOIN Person
      ON BranchManager.PersonId = Person.PersonId
      ;
    ';
    return Database::query( $query, array() )->fetchAll();
  }
  
  
  
  public function getWage() : float {
    return $this->wage;
  }
  
  
  
  public function getAccountNumber() : string {
    return (string) $this->accountNumber;
  }
  
  
  
  public function getBranchId() : int {
    return $this->branchId;
  }
  
  
  
  public function getSortCode() : string {
    return (string) $this->sortCode;
  }
  
  
  
  public function getUsername() : string {
    return $this->username;
  }
  
  
  
  public function setAccountNumber( string $accountNumber ) {
    $this->accountNumber = new AccountNumber( $accountNumber );
  }
  
  
  
  public function setBranchId( int $branchId ) {
    $this->branchId = $branchId;
  }
  
  
  
  public function setSortCode( string $sortCode ) {
    $this->sortCode = new SortCode( $sortCode );
  }
  
  
  
  public function setUsername( string $username ) {
    $this->username = $username;
  }
  
  
  
  //TODO: check the wage? (it must nott be higher than a certain value)
  public function setWage( float $wage ) {
    $this->wage = $wage;
  }
  
  
  
  public function pull() {
    $query = '
      SELECT *
      FROM   BranchManager
      WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
    ';
    $request = Database::query( $query, array( $this->username ) );
    $columns = $request->fetchAll()[0];
    $this->accountNumber = $columns['AccountNumber'];
    $this->branchId = (int) $columns['BranchId'];
    $this->branchManagerId = (int) $columns['BranchManagerId'];
    $this->personId = (int) $columns['PersonId'];
    $this->sortCode = new SortCode( $columns['SortCode'] );
    $this->wage = (float) $columns['Wage'];
  }
  
  
  
  public function push() {
    $query = '
      UPDATE BranchManager
      SET    AccountNumber = ?,
             BranchId = ?,
             PersonId = ?,
             SortCode = ?,
             Wage = ?
      WHERE  BranchManagerId = ?
      ;
    ';
    $values = array(
      (string) $this->accountNumber,
      $this->branchId,
      $this->personId,
      (string) $this->sortCode,
      $this->wage,
      $this->branchManagerId
    );
    Database::query( $query, $values );
  }
}