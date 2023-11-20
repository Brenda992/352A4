<?php
include('function.php');
require_SSL();


if (!isset($_POST['submit'])) { // detect form submission

    $email = $pass = "";

} else {
    $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = !empty($_POST["password"]) ? trim($_POST["password"]) : "";

    $query = "SELECT email, password FROM users ";
    $query .= "WHERE email = ?";

	$stmt = $db->prepare($query);
	$stmt->bind_param('s',$email);
	$stmt->execute();
	$stmt->bind_result($email2,$pass2_hash);
	

    if($stmt->fetch() && password_verify($password,$pass2_hash)) {
        $_SESSION['valid_user'] = $email;
        $callback_url = "showwatchlist.php";
        if (isset($_SESSION['callback_url']))
        	$callback_url = $_SESSION['callback_url'];
        //switch back to non-secure http
        redirect_to($callback_url);
    }
    else $message = "Sorry, email and password combination not registered. <a href=\"\">Forgot?</a>";
}

require('header.php');
?>

	<h2>Sign in </h2>
    <?php if(!empty($message)) echo '<p>' . $message . '</p>' ?>

    <form action="login.php" method="post">
    <label for="email">Email Address: <input type="email" name="email" value="<?php $email ?>"></label>
    <br/>
    <label for="password">Password: <input type="password" name="password" value=""></label>
    <br/>
    <input type="submit" name="submit" value="Submit">
            </form>
	<p><a href="register.php">Not registered yet? Register here.</a></p>

<?php 
	require('footer.php');
?>