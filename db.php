<?php

// set true if production environment else false for development
define('IS_ENV_PRODUCTION', false);

// configure error reporting options
if (!IS_ENV_PRODUCTION){
   error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}

ini_set('display_errors', !IS_ENV_PRODUCTION);
//ini_set('error_log', '../log/error.txt');


// set time zone to use date/time functions without warnings
date_default_timezone_set('Asia/Kabul');

// This file contains the database access information.
// This file also establishes a connection to MySQL and selects the database.
// This file also defines the escape_data() function.

// Set the database access information as constants.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_SCHEMA', 'irdp_projects');

// Make the connection.
if (!$GLOBALS['DB'] = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
    die('Could not connect to MySQLi: ' . mysqli_error());
}

// Select the database.
if (!@mysqli_select_db($GLOBALS['DB'], DB_SCHEMA)) {
    @mysqli_close($GLOBALS['DB']);
    die('Could not select the database: ' . mysqli_error());
} else {
    @mysqli_query($GLOBALS['DB'], "SET NAMES utf8");
    @mysqli_query($GLOBALS['DB'], "SET CHARACTER SET utf8");
	mysqli_set_charset($GLOBALS['DB'], 'utf8');
}

// Create a function for escaping the data.
function escape_data($data)
{

    // Address Magic Quotes.
    if (ini_get('magic_quotes_gpc')) {
        $data = stripslashes($data);
    }

    // Check for mysql_real_escape_string() support.
    if (function_exists('mysqli_real_escape_string')) {
        $data = mysqli_real_escape_string($GLOBALS['DB'], trim($data));
    } else {
        $data = mysqli_escape_string($GLOBALS['DB'], trim($data));
    }
    // Return the escaped value.
    return $data;

} // End of escape_data()

?>