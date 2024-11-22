<?php
error_reporting(0);
$email = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);
if ($email == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;'>Email is Empty.</div>";
exit();
}
if ($password == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;'>Password is Empty..</div>";
exit();
}

include('db_connection.php');
$result = $db->prepare('SELECT * FROM users where email = :email');

		$result->execute(array(
			':email' => $email

    ));

$count = $result->rowCount();

$row = $result->fetch();

if( $count == 1 ) {
$password = strip_tags($_POST['password']);

//start hashed passwordless Security verify
if(password_verify($password,$row["password"])){
            //echo "Password verified and ok";

// initialize session if things where ok

session_start();
session_regenerate_id();
$timer = time();

// initialize session

$_SESSION['uid'] = $row['userid'];
$_SESSION['fullname'] = $row['fullname'];
$_SESSION['photo'] = $row['photo'];

echo "<div style='background:green;padding:8px;color:white;border:none;'>Login sucessful <img src='image/loader.gif'></div>";
echo "<script>window.location='dashboard_discussion.php'</script>";
}
else{

echo "<div style='background:red;padding:8px;color:white;border:none;'>Password does not match..</div>";

}


}
else {

echo "<div style='background:red;padding:8px;color:white;border:none;'>User with this Email does not Exist</div>";
}
?>

<?php ob_end_flush(); ?>
