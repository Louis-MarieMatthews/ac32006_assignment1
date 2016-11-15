<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );
require_once( '/classes/stores/Username.php' );
require_once( '/classes/stores/Password.php' );
require_once( '/classes/stores/Title.php' );
require_once( '/classes/stores/Name.php' );
require_once( '/classes/stores/Address.php' );
require_once( '/classes/stores/Postcode.php' );
require_once( '/classes/stores/Email.php' );
require_once( '/classes/stores/City.php' );
require_once( '/classes/stores/Telephone.php'
 );
// TODO: (important) make update(), insert(), fetch() return a query
// and its parameters so that requests can be optimized
// TODO: (critical) add delete() method
// TODO: (medium) comments
// TODO: (minor) separate the class into a model class aggregating a
// store class in order to separate responsabilities and make code?
// more clear.
class Person
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
      $this->personId = (int) $personId;
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