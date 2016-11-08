<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/AccountNumber.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/SortCode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/PersonModel.php' );

class BranchManagerModel extends PersonModel
{
  private $accountNumber;
  private $branchId;
  private $branchManagerId;
  private $sortCode;
  private $wage;
  
  
  
  // TODO (minor) make this method non static?
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
  
  
  
  public final function fetch() {
    parent::fetch();
     
    $query = '
    SELECT *
    FROM   BranchManager
    WHERE  PersonId = ?;
    ';
    $request = Database::query( $query,  array( $this->getPersonId() ) );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( '0 or more than 1 branch manager with this 
      branch manager id' );
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
    UPDATE BranchManager
    SET    BranchId = ?,
           Wage = ?,
           SortCode = ?,
           AccountNumber = ?
    WHERE  PersonId = ?;
    ';
    $parameters = array(
      $this->getBranchId(),
      $this->getWage(),
      $this->getSortCode(),
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
      INSERT INTO BranchManager (
        BranchId,
        Wage,
        SortCode,
        AccountNumber )
      VALUES ( ?, ?, ?, ? );
    ';
    $parameters = array(
      $this->getBranchId(),
      $this->getWage(),
      $this->getSortCode(),
      $this->getAccountNumber() );
    Database::query( $query, $parameters );
    // TODO: check that one person has been changed?
  }
  
  
  
  public function getWage() {
    return $this->wage;
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
  
  
  
  public function setAccountNumber( $accountNumber ) {
    if ( $accountNumber == null ) {
      $this->accountNumber = null;
    }
    else {
      $this->accountNumber = new AccountNumber( $accountNumber );
    }
  }
  
  
  
  // create BranchId class?
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
  
  
  
  //TODO: check the wage? (it must not be higher than a certain value)
  public function setWage( $wage ) {
    if ( $wage == null ) {
      $this->wage = null;
    }
    else {
    $this->wage = $wage;
    }
  }
}