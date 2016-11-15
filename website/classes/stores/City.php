<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class City
{
  private $city;
  
  
  
  public final function __construct( $city ) {
    $this->set( $city );
  }
  
  
  
  public final function set( $city ) {
    if ( self::isValid( $city ) ) {
      $this->city = $city;
    }
    else {
      throw new IllegalFormatException( 'Invalid City Name: Any city name must be 85 characters long at most.' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    if ( strlen( $string ) <= 85 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->city;
  }
}