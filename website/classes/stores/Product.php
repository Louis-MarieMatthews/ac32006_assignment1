<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );

class Product
{
	private $productID;
	private $productName;
	private $productPrice;
	
	public final function getProductID() {
    return $this->productID;
	}
	
	public final function getProductName() {
    return $this->productName;
	}
	
	public final function getProductPrice() {
    return $this->productPrice;
    }
	
	public final function setProductID( $productID ) {
    if ( $productID == null ) {
      $this->productID = null;
    }
    else {
      $this->productID = new ProductID( $productID );
    }
  }
     
	public final function setProductName( $productName ) {
    if ( $productName == null ) {
      $this->productName = null;
    }
    else {
      $this->productName = new ProductName( $productName );
    }
  }
  
	public final function setProductPrice( $productPrice ) {
    if ( $productPrice == null ) {
      $this->productPrice = null;
    }
    else {
      $this->productPrice = new ProductPrice( $productPrice );
    }
  }
}