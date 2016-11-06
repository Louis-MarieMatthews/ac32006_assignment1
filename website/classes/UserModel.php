<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/Database.php' );

/**
 * Use this class to access / manage user related data stored in the database.
 * Password are not stored in clear, but instead as SHA512 hashes. This class takes care of hashing
 * passords and inserting them in the database.
 * Add here any function related to updating / maintaining users.
 *
 * @author Louis-Marie Matthews
 */
class UserModel {
  /**
   * Tell if the given credentials are correct.
   * 
   * @param $username the username of the user (stored as UserId in the database)
   * @param $password the corresponding non-hashed password of the user (the method takes care of hashing it)
   */
  public static function areCredentialsCorrect( string $username, string $password ) : bool {
    $hashed_password = hash( 'sha512', $password );
    $db = Database::getConnection();
    $request = $db->prepare( 'SELECT Password FROM User WHERE UserId = ?;' );
    $request->execute( array( $username ) );
    if ( $request->columnCount() === 0 | $request->fetch()['Password'] !== $hashed_password ) {
      return false;
    }
    else {
      return true;
    }
  }
  
  
  
  /**
   * Update the password of the specified user.
   * 
   * @param $username the username of the user (stored as UserId in the database)
   * @param $password the non-hashed password of the user (the method takes care of hashing it)
   */
  public static function updatePassword( string $username, string $password ) {
    $hashed_password = hash( 'sha512', $password );
    $db = Database::getConnection();
    $request = $db->prepare( 'UPDATE User SET Password = ? WHERE UserId = ?;' );
    $request->execute( array( $hashed_password, $username ) );
  }
  
  
  
  public static function isCustomer( string $username ) : bool {
    $query = '
      SELECT Customer.CustomerId
      FROM   Customer
      WHERE  Customer.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
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
  
  
  
  public static function isBranchManager( string $username ) : bool {
    $query = '
      SELECT BranchManager.BranchManagerId
      FROM   BranchManager
      WHERE  BranchManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public static function isCompanyManager( string $username ) : bool {
    $query = '
      SELECT CompanyManager.CompanyManagerId
      FROM   CompanyManager
      WHERE  CompanyManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  private static function checkIfPresent( string $query, array $parameters ) : bool {
    $request = Database::getConnection()->prepare( $query );
    $request->execute( $parameters );
    if ( $request->rowCount() === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
}