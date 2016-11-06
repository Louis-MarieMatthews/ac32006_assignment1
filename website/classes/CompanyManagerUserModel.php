<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/UserModel.php' );

class CompanyManagerUserModel extends UserModel
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
}