<?php
declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Name.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Address.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Postcode.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/City.php' );

class BranchModel
{
  private $branchId;
  private $name;
  private $address;
  private $postcode;
  private $city;
  
  
  
  public function fetch() {
    $query = '
      SELECT *
      FROM   Branch
      WHERE  BranchId = ?;
    ';
    $request = Database::query( $query, array( $this->getBranchId() ) );
    if ( $request->rowCount() !== 1 ) {
      throw new Exception( 'there is no branch with this unique id' );
    }
    $results = $request->fetchAll()[0];
    $this->setName( $results['Name'] );
    $this->setAddress( $results['Address'] );
    $this->setPostcode( $results['Postcode'] );
    $this->setCity( $results['City'] );
  }
  
  
  
  public function update() {
    if ( $this->getBranchId() == null ) {
      throw new Exception( 'the branch id needs to be set' );
    }
    $query = '
      UPDATE Branch
      SET    Name = ?,
             Address = ?,
             Postcode = ?,
             City = ?
      WHERE  BranchId = ?;
    ';
    $parameters = array(
      $this->getName(),
      $this->getAddress(),
      $this->getPostcode(),
      $this->getCity(),
      $this->getBranchId() );
    Database::query( $query, $parameters );
  }
  
  
  
  public function getBranchId() {
    return $this->branchId;
  }
  
  
  
  public function getName() {
    return $this->name;
  }
  
  
  
  public function getAddress() {
    return $this->address;
  }
  
  
  
  public function getPostcode() {
    return $this->postcode;
  }
  
  
  
  public function getCity() {
    return $this->city;
  }
  
  
  
  public function setBranchId( $branchId ) {
    if ( $branchId == null ) {
      $this->branchId == null;
    }
    else {
      $this->branchId = (int) $branchId;
    }
  }
  
  
  
  public function setName( $name ) {
    if ( $name == null ) {
      $this->name == null;
    }
    else {
      $this->name = new Name( $name );
    }
  }
  
  
  
  public function setAddress( $address ) {
    if ( $address == null ) {
      $this->address == null;
    }
    else {
      $this->address = new Address( $address );
    }
  }
  
  
  
  public function setPostcode( $postcode ) {
    if ( $postcode == null ) {
      $this->postcode == null;
    }
    else {
      $this->postcode = new Postcode( $postcode );
    }
  }


  
  public function setCity( $city ) {
    if ( $city == null ) {
      $this->city == null;
    }
    else {
      $this->city = new City( $city );
    }
  }
}