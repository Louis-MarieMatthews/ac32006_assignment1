<?php

class BranchManagerModel
{
  public static function isBranchManager( $username ) {
    $query = '
      SELECT COUNT(*)
      FROM   BranchManager
      WHERE  BranchManager.PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? )
      ;
    ';
    $parameters = array( $username );
    $rs = Database::query( $query, $parameters )->fetchAll();
    if ( $rs[0][0] == 1 ) {
       return true;
     }
     else {
       return false;
     }
  }
  
  
  
  public static function getAllBranchManagers() {
    $query = '
      SELECT *
      FROM   BranchManager
      INNER JOIN Person
      ON BranchManager.PersonId = Person.PersonId
      ;
    ';
    return Database::query( $query, array() )->fetchAll();
  }
}