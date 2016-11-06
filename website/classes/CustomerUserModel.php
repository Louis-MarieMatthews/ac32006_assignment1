<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/UserModel.php' );

class CustomerUserModel extends UserModel
{  
  public static function isCustomer( string $username ) : bool {
    $query = '
      SELECT Customer.CustomerId
      FROM   Customer
      WHERE  Customer.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
}