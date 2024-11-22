<?php
error_reporting(0);

$userid = strip_tags($_POST['userid_sess_data']);
$photo = strip_tags($_POST['photo_sess_data']);
$fullname = strip_tags($_POST['fullname_sess_data']);

$post_id = strip_tags($_POST['post_id']);
//$title = strip_tags($_POST['title']);
$postid  = $post_id;
$likex = '1';


if ($post_id == ''){
exit();
}

include('db_connection.php');



if($post_id != ''){

$timer = time();


//check if User has already like the post

$resu = $db->prepare('SELECT * FROM post_like WHERE  postid=:postid and userid=:userid');
$resu->execute(array(':postid' => $post_id, ':userid' => $userid));
$rowpu = $resu->fetch();
$c_count= $resu->rowCount();
if($c_count == '1'){

$return_arr = array("msg"=>"failed");
echo json_encode($return_arr);
exit();
}
  


// insert into post_like table
$statement = $db->prepare('INSERT INTO post_like
(postid,like_count,timer1,userid,fullname,photo)
 
                          values
(:postid,:like_count,:timer1,:userid,:fullname,:photo)');

$statement->execute(array( 
':postid' => $post_id,
':like_count' => $likex,
':timer1' => $timer,
':userid' => $userid,
':fullname' => $fullname,
':photo' => $photo

));



//$res = $db->query("SELECT LAST_INSERT_ID()");
//$commentID = $res->fetchColumn();


$result = $db->prepare('SELECT * FROM posts WHERE id =:id');
$result->execute(array(':id' => $post_id));
$db_count = $result->rowCount();

if($db_count ==0){
echo "<div style='background:red;color:white;padding:10px;border:none;'>This post does not exist Yet.. <b></b></div>";
}
$row = $result->fetch();


$t_like= htmlentities(htmlentities($row['total_like'], ENT_QUOTES, "UTF-8"));
$postid= htmlentities(htmlentities($row['id'], ENT_QUOTES, "UTF-8"));
$totallike = $t_like + 1;
$post_userid= htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
$reciever_userid = $post_userid;
$title= htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
$title_seo= htmlentities(htmlentities($row['title_seo'], ENT_QUOTES, "UTF-8"));
 

 


// update like conts for posts

$cct = $db->prepare('select * from posts where id=:id');
$cct->execute(array(':id' =>$post_id));
$rct_row = $cct->fetch();
$totallikes = $rct_row['total_like'];
$total_l = $totallikes + 1;

$update2= $db->prepare('UPDATE posts set total_like =:total_like where id=:id');
$update2->execute(array(':total_like' => $total_l, ':id' =>$post_id));
   

}

//$resultp = $db->prepare('SELECT COUNT(*) AS cnt FROM post_like WHERE postid=:postid');
$resultp = $db->prepare('SELECT COUNT(*) AS cnt FROM post_like WHERE  postid=:postid');
$resultp->execute(array(':postid' => $post_id));
$rowp = $resultp->fetch();
$totalliking = $rowp['cnt'];   

$return_arr = array("like"=>$totalliking, "msg"=>"success");
echo json_encode($return_arr);