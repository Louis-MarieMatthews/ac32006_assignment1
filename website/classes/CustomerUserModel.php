<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/UserModel.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Username.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Password.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Title.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Name.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Address.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/PostCode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Email.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/City.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Telephone.php' );

class CustomerUserModel extends UserModel
{
  private $username;
  private $password;
  private $title;
  private $firstName;
  private $lastName;
  private $address;
  private $postCode;
  private $city;
  private $telephone;
  private $email;
  
  
  
  public final static function isCustomer( string $username ) : bool {
    $query = '
      SELECT Customer.CustomerId
      FROM   Customer
      WHERE  Customer.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    
    return self::checkIfPresent( $query, array( $username ) );
  }
  
  
  
  public final function setUsername( string $username ) {
    $this->username = new Username( $username );
  }
  public final function setPassword( string $password ) {
    $this->password = new Password( $password );
  }
  public final function setFirstName( string $firstName ) {
    $this->firstName = new Name( $firstName );
  }
  public final function setTitle( string $title ) {
    $this->title = new Title( $title );
  }
  public final function setLastName( string $lastName ) {
    $this->lastName = new Name( $lastName );
  }
  public final function setAddress( string $address ) {
    $this->address = new Address( $address );
  }
  public final function setCity( string $city ) {
    $this->city = new City( $city );
  }
  public final function setEmail( string $email ) {
    $this->email = new Email( $email );
  }
  public final function setPostCode( string $postCode ) {
    $this->postCode = new PostCode( $postCode );
  }
  public final function setTelephone( string $telephone ) {
    $this->telephone = new Telephone( $telephone );
  }
                                 
  
  
  
}