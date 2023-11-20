<?php

// Function to redirect to HTTP if currently on HTTPS
function no_SSL() {
	if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
		header("Location: http://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
}

// Function to enforce SSL, redirecting to HTTPS if not already on it
function require_SSL() {
	if($_SERVER['HTTPS'] != "on") {
		header("Location: https://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
}

// Start the session
session_start();
// Establish database connection
$db =  connection('localhost', 'root', '', 'classicmodels');

// Function to create a database connection and handle connection errors
function connection($dbhost, $dbuser, $dbpass, $dbname) {
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        //quit and display error and error number
        die("Database connection failed:" .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno() . ")"
        );
    }
    return $conn;
}


// Function to create the HTML header with dynamic title and CSS
function createHeader($title, $css) {

    echo "<!doctype html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<title>$title</title>";
    echo "</head>";
    echo "<body>";
}

// Check if a user is logged in and set current user
if(!empty($_SESSION['valid_user']))  {
    $current_user = $_SESSION['valid_user'];
}

// Function to redirect user to a specified URL
function redirect_to($url) {
    header('Location: ' . $url);
    exit;
}

// Function to check if a user is logged in
function loggedIn() {
	return isset($_SESSION['valid_user']);
}

// Function to check if a product is in the user's watchlist
function inWatchlist($code) {
	global $db;
	if (isset($_SESSION['valid_user'])) {
		$query = "SELECT COUNT(*) FROM watchlist WHERE productCode=? AND email=?";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ss',$code, $_SESSION['valid_user']);
		$stmt->execute();
		$stmt->bind_result($count);
	    return ($stmt->fetch() && $count > 0);
	}
	return false;
}

// Function to sanitize user input for security
function sanitizeInput($var) {
    $var = mysqli_real_escape_string($_SESSION['connection'], $var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}
?>