<?php
declare( STRICT_TYPES = 1 );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/Database.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Username.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Password.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Title.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Name.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Address.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Postcode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Email.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/City.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Telephone.php'
 );
// TODO: (important) make update(), insert(), fetch() return a query
// and its parameters so that requests can be optimized
// TODO: (critical) add delete() method
// TODO: (medium) comments
// TODO: (minor) separate the class into a model class aggregating a
// store class in order to separate responsabilities and make code?
// more clear.
class PersonModel
{
  private $address;
  private $city;
  private $email;
  private $firstName;
  private $lastName;
  private $personId;
  private $postcode;
  private $telephone;
  private $title;
  private $username;
  
  
  
  /**
   * This method hydrates the PersonModel object from the row in the 
   * database that matches either the PersonId or the UserId of the 
   * object.
   * If PersonId is not defined, username is used to find the row.
   * If none of them are defined, or if they don't match any row, an 
   * exception is thrown.
   */
  public function fetch() {
    // TODO: (minor) more precise exception
    if ( $this->personId == null & $this->username == null ) {
      throw new Exception( 'person id and username not set, cant fetch' );
    }
    else if ( $this->personId != null ) {
      $query = '
        SELECT * FROM Person WHERE PersonId = ?;
      ';
      $parameters = array( $this->personId );
    }
    elseif ( $this->username != null ) {
      $query = '
        SELECT * FROM Person WHERE UserId = ?;
      ';
      $parameters = array( $this->username );
    }
    $request = Database::query( $query, $parameters );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( '0 or more than 1 person with this person id' );
    }
    $results = $request->fetchAll()[0];
    
    // hydrating the person
    $this->setAddress( $results['Address'] );
    $this->setCity( $results['City'] );
    $this->setEmail( $results['Email'] );
    $this->setFirstName( $results['FirstName'] );
    $this->setLastName( $results['LastName'] );
    $this->setPersonId( (int) $results['PersonId'] );
    $this->setPostcode( $results['Postcode'] );
    $this->setTelephone( $results['Telephone'] );
    $this->setTitle( $results['Title'] );
    $this->setUsername( $results['UserId'] );
  }
  
  
  
  /**
   * The method won't check that all the required fields have been 
   * updated as this is the job of the DBMS.
   */
  public function update() {
    // TODO: (medium) allow to precise which fields to update in parameters?
    $query = '
    UPDATE Person
    SET    Address = ?,
           City = ?,
           Email = ?,
           FirstName = ?,
           LastName = ?,
           Postcode = ?,
           Telephone = ?,
           Title = ?,
           UserId = ?
    WHERE  PersonId = ?;
    ';
    $parameters = array (
      $this->getAddress(),
      $this->getCity(),
      $this->getEmail(),
      $this->getFirstName(),
      $this->getLastName(),
      $this->getPostcode(),
      $this->getTelephone(),
      $this->getTitle(),
      $this->getUsername(),
      $this->getPersonId() );
    Database::query( $query, $parameters );
  }
  
  
  
  public function insert() {
    // TODO: allow to precise which fields to update in parameters?
    $query = '
      INSERT INTO Person (
        Address,
        City,
        Email,
        FirstName,
        LastName,
        Postcode,
        Telephone,
        Title,
        UserId )
      VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? );
    ';
    $parameters = array(
      $this->getAddress(),
      $this->getCity(),
      $this->getEmail(),
      $this->getFirstName(),
      $this->getLastName(),
      $this->getPostcode(),
      $this->getTelephone(),
      $this->getTitle(),
      $this->getUsername() );
    Database::query( $query, $parameters );
    $request = Database::query( 'SELECT MAX(PersonId) FROM Person', array() );
    // TODO: (critical) quick and dirty way to do things, will cause severe problems
    // in the case of concurrents insertions / deletions.
    $this->setPersonId( $request->fetchAll()[0][0] );
  }
  
  
  
  protected static function checkIfPresent( string $query, array $parameters ) : bool {
    $request = Database::query( $query, $parameters );
    if ( $request->rowCount() === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  public final function getAddress() {
    return $this->address;
  }
  
  
  
  public final function getCity() {
    return $this->city;
  }
  
  
  
  public final function getEmail() {
    return $this->email;
  }
  
  
  
  public final function getFirstName() {
    return $this->firstName;
  }
  
  
  
  public final function getLastName() {
    return $this->lastName;
  }
  
  
  
  public final function getPersonId() {
    return $this->personId;
  }
  
  
  
  public final function getPostcode() {
    return $this->postcode;
  }
  
  
  
  public final function getTelephone() {
    return $this->telephone;
  }
  
  
  
  public final function getTitle() {
    return $this->title;
  }
  
  
  
  public final function getUsername() {
    return $this->username;
  }
  
  
  
  public final function setAddress( $address ) {
    if ( $address == null ) {
      $this->address = null;
    }
    else {
      $this->address = new Address( $address );
    }
  }
  
  
  
  public final function setCity( $city ) {
    if ( $city == null ) {
      $this->city = null;
    }
    else {
      $this->city = new City( $city );
    }
  }
  
  
  
  public final function setEmail( $email ) {
    if ( $email == null ) {
      $this->email = null;
    }
    else {
      $this->email = new Email( $email );
    }
  }
  
  
  
  public final function setFirstName( $firstName ) {
    if ( $firstName == null ) {
      $this->firstName = null;
    }
    else {
      $this->firstName = new Name( $firstName );
    }
  }
  
  
  
  public final function setLastName( $lastName ) {
    if ( $lastName == null ) {
      $this->lastName = null;
    }
    else {
      $this->lastName = new Name( $lastName );
    }
  }
  
  
  
  public final function setPersonId( $personId ) {
    if ( $personId == null ) {
      $this->personId = null;
    }
    else {
      $this->personId = $personId;
    }
  }
  
  
  
  public final function setPostcode( $postcode ) {
    if ( $postcode == null ) {
      $this->postcode = null;
    }
    else {
      $this->postcode = new Postcode( $postcode );
    }
  }
  
  
  
  public final function setTelephone( $telephone ) {
    if ( $telephone == null ) {
      $this->telephone = null;
    }
    else {
      $this->telephone = new Telephone( $telephone );
    }
  }
  
  
  
  public final function setTitle( $title ) {
    if ( $title == null ) {
      $this->title = null;
    }
    else {
      $this->title = new Title( $title );
    }
  }
  
  
  
  public final function setUsername( $username ) {
    if ( $username == null ) {
      $this->username = null;
    }
    else {
      $this->username = new Username( $username );
    }
  }
}