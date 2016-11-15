<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class Title
{
  private $title;
  private static $TITLES = array( 'Mr.', 'Ms.', 'Dr.', 'Prof.' );
  
  
  
  public final function __construct( $title ) {
    $this->set( $title );
  }
  
  
  
  public final function set( $title ) {
    if ( self::isValid( $title ) ) {
      $this->title = $title;
    }
    else {
      throw new IllegalFormatException( 'Invalid Title: It must either be "Mr.", "Ms.", "Dr." or "Prof.".' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
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