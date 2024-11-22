<?php
//error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
include('settings.php');
include('db_connection.php');

$title_post = strip_tags($_POST['titleo']);
$descox = strip_tags($_POST['desco']);
$userid = strip_tags($_POST['userid_sess_data']);
$photo = strip_tags($_POST['photo_sess_data']);
$fullname = strip_tags($_POST['fullname_sess_data']);


// remove all double or single quotes in the data
$replace1 = str_replace('"', '', $descox);
$replace2 = str_replace("'", '', $replace1);
echo $desco = $replace2;



$timer=time();
$mt = microtime(true);
$mdx = md5($mt);
$uidx = uniqid();
$tit = $uidx.$timer.$mdx;

$content = $desco;
// Check Sambanova API Key has been Set
if($sambanova_api_key == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_post_bully'>Contact Admin to Set Sambanova API Key at
<b>(backend/settings.php)</b> File</div>";
exit();
}


if ($content == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_post_bully'>AI Content to be Analyzed cannot be empty</div>";
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
echo "<div class='alerts_post_bully' style='background:red;color:white;padding:10px;border:none;'>API Call to Sambanova AI Failed. Ensure there is an Internet  Connections...</div><br>";
exit();
}

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   //echo $error_msg = curl_error($ch);
}

curl_close($ch);

if($http_status == 400){
echo "<div class='alerts_post_bully' style='background:red;color:white;padding:10px;border:none;'>Server Unable to understand Your Request. Ensure The Sambanova Model is Correct</div><br>";
exit();
}

if($http_status == 401){
echo "<div class='alerts_post_bully' style='background:red;color:white;padding:10px;border:none;'>Invalid Authentication Keys</div><br>";
exit();
}


if($http_status == 408){
echo "<div class='alerts_post_bully' style='background:red;color:white;padding:10px;border:none;'>Request Timeout</div><br>";
exit();
}


if($http_status == 429){
echo "<div class='alerts_post_bully' style='background:red;color:white;padding:10px;border:none;'>Too Many Request. Insufficient Quota</div><br>";
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



//id	post_id,title,desco,creator_userid,creator_fullname,creator_photo,timing,bully_word	




if (strpos($allContent, $char) !== false) {

$statement = $db->prepare('INSERT INTO posts
(title,title_seo,content,fullname,timer,userid,userphoto,total_comments,total_like,bully_word,bully_status)

                          values
(:title,:title_seo,:content,:fullname,:timer,:userid,:userphoto,:total_comments,:total_like,:bully_word,:bully_status)');

$statement->execute(array( 
':title' => $title_post,
':title_seo' => $tit,
':content' => $desco,		
':fullname' => $fullname,
':timer' => $timer,
':userid' =>$userid,
':userphoto' =>$photo,
':total_comments' =>'0',
':total_like' =>'0',
':bully_word' =>'No Bully Words Found by Sambanova AI',
':bully_status' =>'0',
));


$statement = $db->query("SELECT LAST_INSERT_ID()");
$lastInserted_Id = $statement->fetchColumn();


$stmt = $db->prepare('INSERT INTO bully_notification
(post_id,title,desco,creator_userid,creator_fullname,creator_photo,timing,bully_word,bully_status,category)

                          values
(:post_id,:title,:desco,:creator_userid,:creator_fullname,:creator_photo,:timing,:bully_word,:bully_status,:category)');

$stmt->execute(array( 
':post_id' => $lastInserted_Id,
':title' => $title_post,
':desco' => $desco,	
':creator_fullname' => $fullname,
':timing' => $timer,
':creator_userid' =>$userid,
':creator_photo' =>$photo,
':bully_word' =>'No Bully Words Found by Sambanova AI',
':bully_status' =>'0',
':category' =>'Post',
));



echo  "<script>alert('Content Successfully Posted');</script>";
echo "<div style='background:green;padding:8px;color:white;border:none;'>Content Successfully Posted..</div>";
echo "<script>
location.reload();
</script>
";


} else {



$statement = $db->prepare('INSERT INTO posts
(title,title_seo,content,fullname,timer,userid,userphoto,total_comments,total_like,bully_word,bully_status)

                          values
(:title,:title_seo,:content,:fullname,:timer,:userid,:userphoto,:total_comments,:total_like,:bully_word,:bully_status)');

$statement->execute(array( 
':title' => $title_post,
':title_seo' => $tit,
':content' => $desco,		
':fullname' => $fullname,
':timer' => $timer,
':userid' =>$userid,
':userphoto' =>$photo,
':total_comments' =>'0',
':total_like' =>'0',
':bully_word' =>$allContent,
':bully_status' =>'1',
));


$statement = $db->query("SELECT LAST_INSERT_ID()");
$lastInserted_Id = $statement->fetchColumn();


$stmt = $db->prepare('INSERT INTO bully_notification
(post_id,title,desco,creator_userid,creator_fullname,creator_photo,timing,bully_word,bully_status,category)

                          values
(:post_id,:title,:desco,:creator_userid,:creator_fullname,:creator_photo,:timing,:bully_word,:bully_status,:category)');

$stmt->execute(array( 
':post_id' => $lastInserted_Id,
':title' => $title_post,
':desco' => $desco,	
':creator_fullname' => $fullname,
':timing' => $timer,
':creator_userid' =>$userid,
':creator_photo' =>$photo,
':bully_word' =>$allContent,
':bully_status' =>'1',
':category' =>'Post',
));




echo  "<script>alert('Content Successfully Posted');</script>";
echo "<div style='background:green;padding:8px;color:white;border:none;'>Content Successfully Posted..</div>";
echo "<script>
location.reload();
</script>
";


}

//$allContent_trim = trim($allContent);


}







}


?>



