<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/UserModel.php' );

class SalesAssistantUserModel extends UserModel
{
  private $username;
  private $personId;
  private $accountNumber;
  private $branchId;
  private $salesAssistantId;
  private $sortCode;
  private $wage;
  
  
  
  public function __construct() {
  }
  
  
  
  public static function isSalesAssistant( string $username ) : bool {
    $query = '
      SELECT SalesAssistant.SalesAssistantId
      FROM   SalesAssistant
      WHERE  SalesAssistant.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public static function getAllSalesAssistants() : array {
    $query = '
      SELECT *
      FROM   SalesAssistant
      INNER JOIN Person
      ON SalesAssistant.PersonId = Person.PersonId
      ;
    ';
    return Database::query( $query, array() )->fetchAll();
  }
  
  
  
  public function getAccountNumber() : string {
    return $this->accountNumber;
  }
  
  
  
  public function getBranchId() : int {
    return $this->branchId;
  }
  
  
  
  public function getSortCode() : string {
    return $this->sortCode;
  }
  
  
  
  public function getUsername() : string {
    return $this->username;
  }
  
  
  
  public function getWage() : float {
    return $this->wage;
  }
  
  
  
  public function setAccountNumber( string $accountNumber ) {
    $this->accountNumber = $accountNumber;
  }
  
  
  
  public function setBranchId( int $branchId ) {
    $this->branchId = $branchId;
  }
  
  
  
  public function setSortCode( string $sortCode ) {
    $this->sortCode = $sortCode;
  }
  
  
  
  public function setUsername( string $username ) {
    $this->username = $username;
  }
  
  
  
  public function setWage( float $wage ) {
    $this->wage = $wage;
  }
  
  
  
  public function pull() {
    $query = '
      SELECT *
      FROM   SalesAssistant
      WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
    ';
    $request = Database::query( $query, array( $this->username ) );
    $columns = $request->fetchAll()[0];
    $this->accountNumber = $columns['AccountNumber'];
    $this->branchId = (int) $columns['BranchId'];
    $this->salesAssistantId = (int) $columns['SalesAssistantId'];
    $this->personId = (int) $columns['PersonId'];
    $this->sortCode = $columns['SortCode'];
    $this->wage = (float) $columns['Wage'];
  }
  
  
  
  public function push() {
    $query = '
      UPDATE SalesAssistant
      SET    AccountNumber = ?,
             BranchId = ?,
             PersonId = ?,
             SortCode = ?,
             Wage = ?
      WHERE  SalesAssistantId = ?
      ;
    ';
    $values = array(
      $this->accountNumber,
      $this->branchId,
      $this->personId,
      $this->sortCode,
      $this->wage,
      $this->salesAssistantId
    );
    Database::query( $query, $values );
  }
}