<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/AccountNumber.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/SortCode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/PersonModel.php' );

class SalesAssistantModel extends PersonModel
{
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
  
  
  
  public function getAccountNumber() {
    return (string) $this->accountNumber;
  }
  
  
  
  public function getBranchId() {
    return $this->branchId;
  }
  
  
  
  public function getSortCode() {
    return (string) $this->sortCode;
  }
  
  
  
  public function getWage() {
    return $this->wage;
  }
  
  
  
  public function setAccountNumber( $accountNumber ) {
    if ( $accountNumber == null ) {
      $this->accountNumber = null;
    }
    else {
      $this->accountNumber = new AccountNumber( $accountNumber );
    }
  }
  
  
  
  public function setBranchId( $branchId ) {
    if ( $branchId == null ) {
      $this->branchId = null;
    }
    else {
      $this->branchId = $branchId;
    }
  }
  
  
  
  public function setSortCode( $sortCode ) {
    if ( $sortCode == null ) {
      $this->sortCode = null;
    }
    else {
      $this->sortCode = new SortCode( $sortCode );
    }
  }
  
  
  
  public function setWage( $wage ) {
    if ( $wage == null ) {
      $this->wage = null;
    }
    else {
      $this->wage = $wage;
    }
  }
  
  
  
  public final function fetch() {
    parent::fetch();
     
    $query = '
    SELECT *
    FROM   SalesAssistant
    WHERE  PersonId = ?;
    ';
    $request = Database::query( $query,  array( $this->getPersonId() ) );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( '0 or more than 1 sales assistant with this 
      sales assistant id' );
    }
    $results = $request->fetchAll()[0];
    
    // hydrating the branch manager
    $this->setWage( (float) $results['Wage'] );
    $this->setSortCode( $results['SortCode'] );
    $this->setBranchId( (int) $results['BranchId'] );
    $this->setAccountNumber( $results['AccountNumber'] );
  }
  
  
  
  public final function update() {
    parent::update();
    // TODO: allow to precise which fields to update in parameters?
    $query = '
    UPDATE SalesAssistant
    SET    Wage = ?,
           SortCode = ?,
           BranchId = ?,
           AccountNumber = ?
    WHERE  PersonId = ?;
    ';
    $parameters = array(
      $this->getWage(),
      $this->getSortCode(),
      $this->getBranchId(),
      $this->getAccountNumber(),
      $this->getPersonId()
    );
    Database::query( $query, $parameters );
    // TODO: check that one person has been changed?
  }
  
  
  
  public final function insert() {
    parent::insert();
    // TODO: allow to precise which fields to update in parameters?
    $query = '
    INSERT INTO Person (
      Address, City, Email, FirstName, LastName, Postcode, Telephone,
      Title, UserId )
      VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? );
    ';
    $parameters = $this->toArray();
    Database::query( $query, $parameters );
    // TODO: check that one person has been changed?
  }
}