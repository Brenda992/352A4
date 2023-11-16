<?php
include('function.php');
require_SSL();

if (isset($_POST['submit'])) { // detect form submission

    // detect if each variable is set (fname, lname, email, password, sid, faculty)
    $fname = !empty($_POST["fname"]) ? trim($_POST["fname"]) : "";
    $lname = !empty($_POST["lname"]) ? trim($_POST["lname"]) : "";
    $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = !empty($_POST["password"]) ? $_POST["password"] : "";
    $password2 = !empty($_POST["password2"]) ? $_POST["password2"] : "";
    
    if($password != $password2) {
        $message = "Passwords do not match.";
    }
    else if (!$fname || !$lname || !$email || !$password) {
    	$message = "All fields manadatory.";
    }
    else {
        $pw_encrypted = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, password, firstName,lastName) ";
        $query .= "VALUES (?,?,?,?)";
      
      	$stmt = $db->prepare($query);
		$stmt->bind_param('ssss',$email,$pw_encrypted,$fname,$lname);
		$stmt->execute();
        echo $query;
        redirect_to('sign-in.php');
    }
}
else {
    $fname = "";
    $lname = "";
    $email = "";
    $s_id = "";
    $faculty = "";
}

require('header.php');
?>

            <h2>Register for a Classic Models account</h2>
            <form action="register.php" method="post">
                <label for="fname">First Name: <input name="fname" type="text" value="<?php $fname ?>"></label>
				<br/>
                <label for="lname">Last Name: <input type="text" name="lname" value="<?php $lname ?>"></label>
				<br/>
                <label for="email">Email Address: <input type="email" name="email" value="<?php $email ?>"></label>
				<br/>

                <label for="password">Password: <input type="password" name="password" value=""></label>
				<br/>
                <label for="password2">Password: <input type="password" name="password2" value=""></label>
				<br/>


                <input type="submit" name="submit" value="Register">
                <?php if(!empty($message)) echo '<p class="message">' . $message . '</p>' ?>
            </form>


<?php
	require('footer.php');
    $db->close();
?>