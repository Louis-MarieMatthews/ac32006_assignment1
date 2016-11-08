<?php

declare( STRICT_TYPES = 1 );

class Title
{
  private $title;
  private static $TITLES = array( 'Mr.', 'Ms.', 'Dr.', 'Prof.' );
  
  
  
  public final function __construct( string $title ) {
    $this->set( $title );
  }
  
  
  
  public final function set( string $title ) {
    if ( self::isValid( $title ) ) {
      $this->title = $title;
    }
    else {
      throw new DomainException( 'invalid title' );
    }
  }
  
  
  
  public final static function isValid( string $string ) : bool {
    if ( in_array( $string, self::$TITLES ) ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->title;
  }
}