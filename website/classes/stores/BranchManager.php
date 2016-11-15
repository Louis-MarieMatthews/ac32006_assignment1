<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );
require_once( '/classes/stores/AccountNumber.php' );
require_once( '/classes/stores/SortCode.php' );
require_once( '/classes/stores/Person.php' );

class BranchManager extends Person
{
  private $accountNumber;
  private $branchId;
  private $branchManagerId;
  private $sortCode;
  private $wage;
  
  
  
  public function getWage() {
    return $this->wage;
  }
  
  
  
  public function getAccountNumber() {
    return (string) $this->accountNumber;
  }
  
  
  
  public function getBranchId() {
    return $this->branchId;
  }
  
  
  
  public function getBranchManagerId() {
    return $this->branchManagerId;
  }
  
  
  
  public function getSortCode() {
    return (string) $this->sortCode;
  }
  
  
  
  public function setAccountNumber( $accountNumber ) {
    if ( $accountNumber == null ) {
      $this->accountNumber = null;
    }
    else {
      $this->accountNumber = new AccountNumber( $accountNumber );
    }
  }
  
  
  
  // create BranchId class?
  public function setBranchId( $branchId ) {
    if ( $branchId == null ) {
      $this->branchId = null;
    }
    else {
      $this->branchId = (int) $branchId;
    }
  }
  
  
  
  public function setBranchManagerId( $branchManagerId ) {
    if ( $branchManagerId == null ) {
      $this->branchManagerId = null;
    }
    else {
      $this->branchManagerId = (int) $branchManagerId;
    }
  }
  
  
  
  public function setSortCode( $sortCode ) {
    if ( $sortCode == null ) {
      $this->sortCode = null;
    }
    else {
      $this->sortCode = new SortCode( $sortCode );
    }
  }
  
  
  
  //TODO: check the wage? (it must not be higher than a certain value)
  public function setWage( $wage ) {
    if ( $wage == null ) {
      $this->wage = null;
    }
    else {
    $this->wage = (int) $wage;
    }
  }
}