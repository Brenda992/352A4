<?php

function no_SSL() {
	if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
		header("Location: http://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
}
function require_SSL() {
	if($_SERVER['HTTPS'] != "on") {
		header("Location: https://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
}
session_start();
$db =  connection('localhost', 'root', '', 'classicmodels');

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

function createHeader($title, $css) {

    echo "<!doctype html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<title>$title</title>";
    echo "</head>";
    echo "<body>";
}

if(!empty($_SESSION['valid_user']))  {
    $current_user = $_SESSION['valid_user'];
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function loggedIn() {
	return isset($_SESSION['valid_user']);
}

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

function sanitizeInput($var) {
    $var = mysqli_real_escape_string($_SESSION['connection'], $var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}
?>