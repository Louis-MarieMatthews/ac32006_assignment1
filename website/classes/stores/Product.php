<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );
require_once( 'classes/stores/Name.php' );

class Product
{
	private $id;
	private $name;
	private $price;
	
  
  
	public final function getId() {
    return $this->id;
	}
	
  
  
	public final function getName() {
    return $this->name;
	}
	
  
  
	public final function getPrice() {
    return $this->price;
    }
	
  
  
	public final function setId( $id ) {
    if ( $id == null ) {
      $this->id = null;
    }
    else {
      $this->id = ( int ) $id;
    }
  }
  
  
     
	public final function setName( $name ) {
    if ( $name == null ) {
      $this->name = null;
    }
    else {
      $this->name = new Name( $name );
    }
  }
  
  
  
	public final function setPrice( $price ) {
    if ( $price == null ) {
      $this->price = null;
    }
    else {
      $this->price = ( float ) $price;
    }
  }
}