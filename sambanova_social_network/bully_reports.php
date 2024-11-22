<?php
error_reporting(0); 
session_start();
include ('backend/session_authenticate.php');
include ('backend/settings.php');

$userid_sess =  htmlentities(htmlentities($_SESSION['uid'], ENT_QUOTES, "UTF-8"));
$fullname_sess =  htmlentities(htmlentities($_SESSION['fullname'], ENT_QUOTES, "UTF-8"));
$photo_sess =  htmlentities(htmlentities($_SESSION['photo'], ENT_QUOTES, "UTF-8"));
?>





</script>


<!DOCTYPE html>
<html lang="en">

<head>
 <title><?php echo $title; $titlex = $title; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="<?php echo $description; ?>" />

<link rel="stylesheet" href="css/index_dashboard1.css">
<link rel="stylesheet" href="bootstraps/bootstrap.min.css">
<script src="jquery/jquery.min.js"></script>
<script src="bootstraps/bootstrap.min.js"></script>
<script src="javascript/moment.js"></script>
<script src="javascript/livestamp.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
<script>

// stopt all bootstrap drop down menu from closing on click inside
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});



</script>






<!-- start column nav-->


<div class="text-center">
<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navgator">
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span> 
        <span class="navbar-header-collapse-color icon-bar"></span>                       
      </button>
     
<li class="navbar-brand home_click imagelogo_li_remove" ><img title='<?php  echo $titlex; ?>-logo' alt='<?php  echo $titlex; ?>-logo' class="img-rounded imagelogo_data" src="image/logo.png"></li>
    </div>
    <div class="collapse navbar-collapse" id="navgator">


      <ul class="nav navbar-nav navbar-right">





 <li class="navgate_no"><a href='dashboard_discussion.php' title='Back to dashboard' style="color:white;font-size:14px;">
<button class="category_post1">Back to Dashboard</button></a></li>


             
<li class="navgate"><img style="max-height:40px;max-width:40px;" class="img-circle" width="40px" height="40px" src='backend/users_photos/<?php echo $photo_sess; ?>'>



<span class="dropdown">
  <a style="color:white;font-size:14px;cursor:pointer;" title='' class="btn1 btn-default1 dropdown-toggle"  data-toggle="dropdown">
<br><?php echo $fullname_sess; ?></span></a>

</span>

</li>


 <li style=''class="navgate_no"><a title='Logout' href='logout.php'  style="color:white;font-size:14px;">
<button class="category_post1 ">Logout</button></a></li>


      </ul>




    </div>
  </div>



</nav>


    </div><br /><br />

<!-- end column nav-->





<br>
<br>
<br>

<div class='row'>



<center><h3>Welcome  <b><?php echo $fullname_sess; ?></b></h3></center>

<div class='col-sm-1'></div>
<div class='col-sm-10'>
<center><h3>Social Content Bully Detection System Powered by <b style='color:#800000'>Sambanova AI</b></h3></center>


</div>

<div class='col-sm-1'></div>

<!--left starts-->
<!--left ends-->







<div class="col-sm-12">



<!---start --->
 <div class="content">

          
       <?php    

echo '<table border="0" cellspacing="2" cellpadding="2" class="table table-striped_no table-bordered table-hover"> 
      <tr> 
          <th> <font face="Arial">Photo</font> </th> 
          <th> <font face="Arial">Poster</font> </th> 
          <th> <font face="Arial">Content</font> </th> 
<th> <font face="Arial">Bully Words</font> </th> 
          <th> <font face="Arial">Category</font> </th> 
<th> <font face="Arial">Time Created</font> </th> 
<th> <font face="Arial">Action</font> </th> 

      </tr>';

?>
<?php
include('backend/db_connection.php');

$result = $db->prepare("SELECT * FROM bully_notification WHERE bully_status=:bully_status order by id desc");
$result->execute(array(':bully_status'=>'1'));

$count_post = $result->rowCount();
if($count_post == 0){
  echo "<div style='color:white;background:red;padding:10px;border:none;'>No Bully Data Found Yet...</div>";
}

while($row = $result->fetch()){
//foreach($json['invoices'] as $row){



$id = htmlentities(htmlentities($row['id'], ENT_QUOTES, "UTF-8"));
$postid = $id;
$title = htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
$content = htmlentities(htmlentities($row['desco'], ENT_QUOTES, "UTF-8"));
$fullname = htmlentities(htmlentities($row['creator_fullname'], ENT_QUOTES, "UTF-8"));
$userphoto = htmlentities(htmlentities($row['creator_photo'], ENT_QUOTES, "UTF-8"));
$timer1 = htmlentities(htmlentities($row['timing'], ENT_QUOTES, "UTF-8"));
$userid = htmlentities(htmlentities($row['creator_userid'], ENT_QUOTES, "UTF-8"));
$category = htmlentities(htmlentities($row['category'], ENT_QUOTES, "UTF-8"));
$microcontent = substr($content, 0, 120)."...";
$microtitle = substr($title, 0, 80)."..";

$bully_word = htmlentities(htmlentities($row['bully_word'], ENT_QUOTES, "UTF-8"));
$bully_status = htmlentities(htmlentities($row['bully_status'], ENT_QUOTES, "UTF-8"));





if ($bully_status == '1') {

$bully_statusx = "<span style='color:red;font-size:14px;'>$bully_word </span>";
}


if ($category == 'Post') {

$categoryx = "<span style='color:#800000;font-size:14px;'>$category </span>";
}

if ($category == 'Comment') {

$categoryx = "<span style='color:purple;font-size:14px;'>$category </span>";
}

        echo "<tr> 
<td><img style='max-height:40px;max-width:40px;' class='img-circle' src='backend/users_photos/$userphoto' alt='User Image'></td>
<td>$fullname</td>              
                  <td><b>$categoryx:</b> $content</td> 
<td>$bully_statusx</td>
                  <td>$categoryx</td> 
<td><span style='color:#800000;' data-livestamp='$timer1'></span></td> 


 <td><button disabled class='btn btn-primary btn-xs ban_btn' title='Ban User'>Ban User</button>  
<button disabled class='btn btn-danger btn-xs del_btn' title='Delete Content'>Delete Content</button>
</td> 
              </tr>";

   



}



?>        



</div>
<!---end --->


    </div>

</div>
<!---end row--->


















  </body>
</html>
