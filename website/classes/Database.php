<?php

declare( STRICT_TYPES = 1 );

/**
 * Singleton class to get a database connection.
 * Use this class to get a database connection, then perform queries on it.
 * The class uses the information provided in ini/database.ini and ini/root.ini.
 * 
 * @author Louis-Marie Matthews
 */
class Database {
  private static $connection;
  
  
  
  public static function getConnection() : PDO {
    if ( ! isset ( $connection ) ) {
      self::initialiseConnection();
    }
    return self::$connection;
  }
  
  
  
  /**
   * Gets the database name, host and the root's username and password from ini files.
   */
  public static function initialiseConnection() {
    $db = parse_ini_file( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/ini/database.ini' );
    $root = parse_ini_file( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/ini/root.ini' );
    self::$connection = new PDO( 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'] . ';charset=utf8', $root['username'], $root['password'] );
  }
}