<?php

require_once( 'classes/stores/Name.php' );
require_once( 'classes/stores/Address.php' );
require_once( 'classes/stores/Postcode.php' );
require_once( 'classes/stores/City.php' );

class Branch
{
  private $branchId;
  private $name;
  private $address;
  private $postcode;
  private $city;
  
  
  
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