<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/PersonModel.php' );

class CompanyManagerModel extends PersonModel
{
  public static function isCompanyManager( string $username ) : bool {
    $query = '
      SELECT CompanyManager.CompanyManagerId
      FROM   CompanyManager
      WHERE  CompanyManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public static function getAllCompanyManagers() : array {
    $query = '
      SELECT *
      FROM   CompanyManager
      INNER JOIN Person
      ON CompanyManager.PersonId = Person.PersonId
      ;
    ';
    return Database::query( $query, array() )->fetchAll();
  }
  
  
  
  public final function fetch() {
    parent::fetch();
     
    $query = '
    SELECT *
    FROM   CompanyManager
    WHERE  PersonId = ?;
    ';
    $request = Database::query( $query,  array( $this->getPersonId() ) );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( '0 or more than 1 CompanyManager with this 
      CompanyManager id' );
    }
    $results = $request->fetchAll()[0];
    
    // hydrating the branch manager
    $this->setWage( (float) $results['Wage'] );
    $this->setSortCode( $results['SortCode'] );
    $this->setAccountNumber( $results['AccountNumber'] );
  }
  
  
  
  public final function update() {
    parent::update();
    // TODO: allow to precise which fields to update in parameters?
    $query = '
    UPDATE CompanyManager
    SET    Wage = ?,
           SortCode = ?,
           AccountNumber = ?
    WHERE  PersonId = ?;
    ';
    $parameters = array(
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
    INSERT INTO CompanyManager (
      Wage, SortCode, AccountNumber )
      VALUES ( ?, ?, ? );
    ';
    $parameters = array(
      $this->getWage(),
      $this->getSortCode(),
      $this->getAccountNumber() );
    Database::query( $query, $parameters );
    // TODO: check that one person has been changed?
  }
}