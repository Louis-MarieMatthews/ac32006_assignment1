<?php

/**
 * This file shows how the make SQL queries.
 */
 
// First, load the Database class.
require_once( 'classes/Database.php' );

// Gets a connection to the database.
$db = Database::getConnection();

// Make a query on the connection
$query = $db->query( 'SELECT * FROM User' );

// And now we can either
// 1. See the number of columns in the result
$number_of_columns = $query->columnCount();
echo( '<p>Number of columns returned: ' . $number_of_columns . '</p>' );

// 2. Gets the results
$results = $query->fetchAll();

for ( $i = 0; $i < sizeof( $results ); $i++ ) {
  echo( '<p>UserId is: ' . $results[ $i ][ 'UserId' ] . '</p>' );
  echo( '<p>Hashed password is: ' . $results[ $i ][ 'Password' ] . '</p>' );
}

// Once the request is done, we close it
$query->closeCursor();