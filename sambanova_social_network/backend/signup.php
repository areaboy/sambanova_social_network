<?php
error_reporting(0);

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

include('settings.php');
include('db_connection.php');

$password = strip_tags($_POST['password']);
$fullname = strip_tags($_POST['fullname']);
$email = strip_tags($_POST['email']);

$file_content = strip_tags($_POST['file_fname']);
	
$timer= time();
$mt = microtime(true);
$mdx = md5($mt);
$uidx = uniqid();
$userid = $uidx.$timer.$mdx;



if ($file_content == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>Files Upload is empty</div>";
exit();
}


if ($password == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>password is empty</div>";
exit();
}

if ($fullname == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>fullname Name is empty</div>";
exit();
}

if ($email == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>Email Address is empty</div>";
exit();
}

$em= filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$em){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>Email Address is Invalid</div>";
exit();
}



// check if user with this email already exits
$result_verified = $db->prepare('select * from users where email=:email');
$result_verified->execute(array(':email' =>$email));

 $rows= $result_verified->fetch();
$norows= $result_verified->rowCount();

if($norows ==1){
echo "<div style='background:red;padding:8px;color:white;border:none;'>This Email Address already exist</div>";
exit();
}	 




$upload_path = "users_photos/";

$filename_string = strip_tags($_FILES['file_content']['name']);
// thus check files extension names before major validations

$allowed_formats = array("PNG", "png", "gif", "GIF", "jpeg", "JPEG", "BMP", "bmp","JPG","jpg");
$exts = explode(".",$filename_string);
$ext = end($exts);

if (!in_array($ext, $allowed_formats)) { 
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>File Formats not allowed. Only Images are allowed.<br></div>";
exit();
}


$fsize = $_FILES['file_content']['size']; 
$ftmp = $_FILES['file_content']['tmp_name'];

if ($fsize > 50 * 1024 * 1024) { // allow file of less than 5 mb
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>File greater than 50 mb not allowed<br></div>";
exit();
}



$allowed_types=array(
'image/gif',
'image/jpeg',
'image/png',
'image/jpg',
'image/GIF',
'image/JPEG',
'image/PNG',
'image/JPG'
);

if ( ! ( in_array($_FILES["file_content"]["type"], $allowed_types) ) ) {
 echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>Only Images are allowed<br><br></div>";
exit();
}

//validate image using file info  method
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file_content']['tmp_name']);


if ( ! ( in_array($mime, $allowed_types) ) ) {
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_signup'>Only Images are allowed...<br></div>";
exit();
}
finfo_close($finfo);

//insert into database
$final_filename =$userid.$filename_string;
//hash password before sending it to database...
$options = array("cost"=>4);
$hashpass = password_hash($password,PASSWORD_BCRYPT,$options);



	

if (move_uploaded_file($ftmp, $upload_path . $final_filename)) {

$statement = $db->prepare('INSERT INTO users
(email,fullname,password,timing,userid,photo)
                          values
(:email,:fullname,:password,:timing,:userid,:photo)');

$statement->execute(array( 
':email' => $email,
':fullname' => $fullname,
':password' => $hashpass,		
':timing' => $timer,
':userid' =>$userid,
':photo' =>$final_filename
));


$stmtx = $db->query("SELECT LAST_INSERT_ID()");
$lastInserted_Id = $stmtx->fetchColumn();

if($statement){
echo  "<script>alert('Account Successfully Created. You can Login Now');</script>";
echo "<div style='background:green;padding:8px;color:white;border:none;'>Account Successfully Created. You can Login Now...</div>";
echo "<script>
$('#myModal_signup').modal('hide');
$('#myModal_login').modal('show');
</script>
";

}else{
echo "<div style='background:red;padding:8px;color:white;border:none;'>Account Creation Failed...</div>";
}

}// close file upload

}


?>



