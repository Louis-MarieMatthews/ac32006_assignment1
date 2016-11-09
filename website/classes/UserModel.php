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
  
  
function registerUser(string $username, string $title, string $firstname, string $lastname, string $address, string $city, string $zipcode, string $email, string $phone, string $user_password) 
  {

	  
	  $hashed_password = hash('sha512', $user_password);
	  $db = Database::getConnection();
	  echo "connection successful";
	  $request = $db->prepare(" SET FOREIGN_KEY_CHECKS=0;  
	  	INSERT INTO ac32006_assignment1.Person(title, FirstName, LastName, Address, City, Postcode, Email, Telephone ) 										 
      VALUES(:UserId, :Title, :FirstName,:LastName, :Address, :City, :Postcode, :Email, :Telephone  );");    

		$request->execute(array(':UserId'=>$username, ':Title'=>$title, ':FirstName'=> $firstname ,':LastName'=> $lastname, ':Address'=> $address, ':City'=> $city, 		':Postcode' => $zipcode, ':Email'=> $email, ':Telephone'=> $phone));  	
		
		$createAccount = $db->prepare("SET FOREIGN_KEY_CHECKS=0; INSERT INTO ac32006_assignment1.User(UserId, Password) VALUES(:UserId, :Password);");
		$createAccount->execute(array(':UserId' => $username, ':Password' => $hashed_password));
	
	
	/**	
	* @author Kashish Sharma
	 **/
		
		/**
		SET FOREIGN_KEY_CHECKS=0; 
		> The above SQL statement is used to turn off the Foreign key check constraint which will usually be True by default when running queries in MySQL or SQL Server. 
		> This actually allows INSERTS in both the tables: Person and User withhout generating a Foreign key error.
		
		
		**/
   
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
    print_r( $request->fetchAll() );
    echo( $request->rowCount() );
    if ( $request->rowCount() === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
}