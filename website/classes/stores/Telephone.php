<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class Telephone
{
  private $telephone;
  
  
  
  public final function __construct( $telephone ) {
    $this->set( $telephone );
  }
  
  
  
  public final function set( $telephone ) {
    if ( self::isValid( $telephone ) ) {
      $this->telephone = $telephone;
    }
    else {
      throw new IllegalFormatException( 'invalid telephone' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    // TODO: improve
    $withoutSpaces = str_replace( ' ', '', $string );
    if ( ctype_digit( $withoutSpaces ) & strlen( $withoutSpaces ) < 20 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->telephone;
  }
}