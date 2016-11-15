<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );

class Address
{
  private $address;
  
  
  
  public final function __construct( $address ) {
    $this->set( $address );
  }
  
  
  
  public final function set( $address ) {
    if ( self::isValid( $address ) ) {
      $this->address = $address;
    }
    else {
      throw new IllegalFormatException( 'Invalid Address: An address can not be more than 255 characters long.' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    if ( strlen( $string ) <= 255 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->address;
  }
}