<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/PersonModel.php' );

class CustomerModel extends PersonModel
{
  private $notes;
  
  
  
  public final static function isCustomer( string $username ) : bool {
    $query = '
      SELECT Customer.CustomerId
      FROM   Customer
      WHERE  Customer.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public function fetch() {
    parent::fetch();
    
    $query = '
      SELECT CustomerId, Notes
      FROM   Customer
      WHERE  PersonId = ?;
    ';
    $request = Database::query( $query, array( $this->personId ) );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( '0 or more than 1 customer with this person
      id' );
    }
    $results = $request->fetchAll()[0];
    $this->customerId = $results['CustomerId'];
    $this->notes = $results['Notes'];
  }
  
  
  
  public final function update() {
    parent::update();
    // TODO: allow to precise which fields to update in parameters?
    $query = '
    UPDATE Customer
    SET    Notes = ?
    WHERE  PersonId = ?;
    ';
    $parameters = array( $this->getNotes() );
    Database::query( $query, $parameters );
  }
  
  
  
  public function insert() {
    parent::insert();
    // TODO: allow to precise which fields to update in parameters?
    var_dump( $this->getNotes() );
    $query = '
      INSERT INTO Customer ( PersonId, Notes )
      VALUES ( ?, ? );
    ';
    $parameters = array( $this->getPersonId(), $this->getNotes() );
    Database::query( $query, $parameters );
    
  }
  
  
  
  public function getNotes() {
    return $this->notes;
  }
}