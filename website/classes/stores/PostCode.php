<?php

class Postcode
{
  private $postcode;
  
  
  
  public final function __construct( $postcode ) {
    $this->set( $postcode );
  }
  
  
  
  public final function set( $postcode ) {
    if ( self::isValid( $postcode ) ) {
      $this->postcode = $postcode;
    }
    else {
      throw new DomainException( 'invalid post code' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    // From simonwhitaker at https://gist.github.com/simonwhitaker/5748487
    $regex = '/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/';
    if ( preg_match( $regex, $string ) ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->postcode;
  }
}