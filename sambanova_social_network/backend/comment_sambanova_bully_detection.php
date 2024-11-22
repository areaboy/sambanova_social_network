<?php
//error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
include('settings.php');
include('db_connection.php');

$userid = strip_tags($_POST['userid_sess_data']);
$photo = strip_tags($_POST['photo_sess_data']);
$fullname = strip_tags($_POST['fullname_sess_data']);

$postid = strip_tags($_POST['postid']);
$comdesc = strip_tags($_POST['comdesc']);

$content = $comdesc;





$timer=time();


$content = $comdesc;
// Check Sambanova API Key has been Set
if($sambanova_api_key == ''){
$msg="Contact Admin to Set Sambanova API Key at (backend/settings.php) File";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();
}


if ($content == ''){
$msg="AI Content to be Analyzed cannot be empty";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();
}

///$text_prompt ="List all the insultive words, offensive words, bully words in the text only. Each seperated by comma Or in Comma delimeted?. $content";
$text_prompt ="List any or all the bully words, offensive words, insultive words in the text only. Each seperated by comma Or in Comma delimeted and if not offensive or bully please say 'no-bully-word-found' only once?  Here is the text. '$content'";


$url =$sambanova_api_url;
$payload ='{
	"stream": true,
	"model": "'.$sambanova_api_model.'",
	"messages": [
		{
			"role": "system",
			"content": "You are a helpful assistant"
		},
		{
			"role": "user",
			"content": "'.$text_prompt.'"
		}
	]
	}' ;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $sambanova_api_key" , 'Content-Type:application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$output = curl_exec($ch); 


if($output == ''){
$msg="API Call to Sambanova AI Failed. Ensure there is an Internet  Connections";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();

}

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   //echo $error_msg = curl_error($ch);
}

curl_close($ch);

if($http_status == 400){
$msg="Server Unable to understand Your Request. Ensure The Sambanova Model is Correct";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();
}

if($http_status == 401){
$msg="Invalid Authentication Keys";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();
}


if($http_status == 408){
$msg="Request Timeout";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();

}


if($http_status == 429){
$msg="Too Many Request. Insufficient Quota";
$return_arr = array("error_msg"=>$msg, "error_status"=>1);
echo json_encode($return_arr);
exit();

}

if($http_status == 200){


// Split the output into individual JSON strings
$json_strings = explode('data: ', trim($output, ' data: [DONE]'));

// Initialize an empty string to store the content
$allContent = "";

// Loop through each string, decode, and access the content
foreach ($json_strings as $json_string) {
  $json = json_decode($json_string, true);
  if (isset($json['choices'][0]['delta']['content'])) {
    $allContent .= $json['choices'][0]['delta']['content'] . "\n";
  }
}


$char = "no-bully-word-found";



if (strpos($allContent, $char) !== false) {
$content_generated ='No-Bully-Words-Found-by-Sambanova-AI';
$token= md5(uniqid());
$timer = time();


$statement = $db->prepare('INSERT INTO comments
(postid,comment,timer1,userid,fullname,photo,data)
 
                          values
(:postid,:comment,:timer1,:userid,:fullname,:photo,:data)');

$statement->execute(array( 
':postid' => $postid,
':comment' => $comdesc,
':timer1' => $timer,
':userid' => $userid,
':fullname' => $fullname,
':photo' => $photo,
':data' => 'No-Bully-Words-Found-by-Sambanova-AI'
));





$statement = $db->query("SELECT LAST_INSERT_ID()");
$commentID = $statement->fetchColumn();


// query table posts to get data
$result = $db->prepare('SELECT * FROM posts WHERE id =:id');
$result->execute(array(':id' => $postid));
$db_count = $result->rowCount();

if($db_count ==0){
echo "<div style='background:red;color:white;padding:10px;border:none;'>This Post does not exist Yet.. <b></b></div>";
}
$row = $result->fetch();

//$post_userid= htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
//$reciever_userid = $post_userid;
$title= htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
$desco= htmlentities(htmlentities($row['content'], ENT_QUOTES, "UTF-8"));




$stmt = $db->prepare('INSERT INTO bully_notification
(post_id,title,desco,creator_userid,creator_fullname,creator_photo,timing,bully_word,bully_status,category)

                          values
(:post_id,:title,:desco,:creator_userid,:creator_fullname,:creator_photo,:timing,:bully_word,:bully_status,:category)');

$stmt->execute(array( 
':post_id' => $postid,
':title' => $title,
':desco' => $comdesc,	
':creator_fullname' => $fullname,
':timing' => $timer,
':creator_userid' =>$userid,
':creator_photo' =>$photo,
':bully_word' =>'No Bully Words Found by Sambanova AI',
':bully_status' =>'0',
':category' =>'Comment',
));


} else {

$content_generated =$allContent;

$token= md5(uniqid());
$timer = time();


$statement = $db->prepare('INSERT INTO comments
(postid,comment,timer1,userid,fullname,photo,data)
 
                          values
(:postid,:comment,:timer1,:userid,:fullname,:photo,:data)');

$statement->execute(array( 
':postid' => $postid,
':comment' => $comdesc,
':timer1' => $timer,
':userid' => $userid,
':fullname' => $fullname,
':photo' => $photo,
':data' => $allContent
));





$statement = $db->query("SELECT LAST_INSERT_ID()");
$commentID = $statement->fetchColumn();


// query table posts to get data
$result = $db->prepare('SELECT * FROM posts WHERE id =:id');
$result->execute(array(':id' => $postid));
$db_count = $result->rowCount();

if($db_count ==0){
echo "<div style='background:red;color:white;padding:10px;border:none;'>This Post does not exist Yet.. <b></b></div>";
}
$row = $result->fetch();

//$post_userid= htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
//$reciever_userid = $post_userid;
$title= htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
$desco= htmlentities(htmlentities($row['content'], ENT_QUOTES, "UTF-8"));




$stmt = $db->prepare('INSERT INTO bully_notification
(post_id,title,desco,creator_userid,creator_fullname,creator_photo,timing,bully_word,bully_status,category)

                          values
(:post_id,:title,:desco,:creator_userid,:creator_fullname,:creator_photo,:timing,:bully_word,:bully_status,:category)');

$stmt->execute(array( 
':post_id' => $postid,
':title' => $title,
':desco' => $comdesc,	
':creator_fullname' => $fullname,
':timing' => $timer,
':creator_userid' =>$userid,
':creator_photo' =>$photo,
':bully_word' =>$allContent,
':bully_status' =>'1',
':category' =>'Comment',
));



}



}




              
// update comments conts for posts

$cct = $db->prepare('select * from posts where id=:id');
$cct->execute(array(':id' =>$postid));
$rct_row = $cct->fetch();
$totalcom = $rct_row['total_comments'];
$total_comment_post = $totalcom + 1;
$totalcomment=$total_comment_post;
$update2= $db->prepare('UPDATE posts set total_comments =:total_comments where id=:id');
$update2->execute(array(':total_comments' => $total_comment_post, ':id' =>$postid));



$comment_result = $db->prepare('SELECT COUNT(*) AS cntcomment FROM comments WHERE postid=:postid');
$comment_result->execute(array(':postid' => $postid));
$comment_row = $comment_result->fetch();
$totalcomment = $comment_row['cntcomment'];
$return_arr = array("comment"=>$totalcomment,"comdesc"=>$comdesc,"comment_username"=>$userid,"comment_fullname"=>$fullname,"comment_photo"=>$photo,"comment_time"=>$timer,"bully_status"=>$content_generated,"error_msg"=>'ok', "error_status"=>0);

echo json_encode($return_arr);





}


?>














