<?php
declare( STRICT_TYPES = 1 );

class SalesAssistantModel
{ static function isSalesAssistant( string $username ) : bool {
    $query = '
      SELECT SalesAssistant.SalesAssistantId
      FROM   SalesAssistant
      WHERE  SalesAssistant.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    $parameters = array( $username );
    $rs = Database::query( $query, $parameters )->fetchAll();
    if ( $rs[0][0] == 1 ) {
       return true;
     }
     else {
       return false;
     }
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
}