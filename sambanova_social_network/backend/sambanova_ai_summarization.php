
<?php
error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
include('settings.php');
$content = strip_tags($_POST['content']);
// Check Sambanova API Key has been Set
if($sambanova_api_key == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_summarize'>Contact Admin to Set Sambanova API Key at
<b>(backend/settings.php)</b> File</div>";
exit();
}


if ($content == ''){
echo "<div style='background:red;padding:8px;color:white;border:none;' id='alerts_summarize'>AI Content to be Analyzed cannot be empty</div>";
exit();
}

$text_prompt ="Summarize this text '$content' ";


//$text_prompt ="summarize the text '$content' in two sentences only. ";
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
echo "<div class='alerts_summarize' style='background:red;color:white;padding:10px;border:none;'>API Call to Sambanova AI Failed. Ensure there is an Internet  Connections...</div><br>";
exit();
}

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// catch error message before closing
if (curl_errno($ch)) {
   //echo $error_msg = curl_error($ch);
}

curl_close($ch);

if($http_status == 400){
echo "<div class='alerts_summarize' style='background:red;color:white;padding:10px;border:none;'>Server Unable to understand Your Request. Ensure The Sambanova Model is Correct</div><br>";
exit();
}

if($http_status == 401){
echo "<div class='alerts_summarize' style='background:red;color:white;padding:10px;border:none;'>Invalid Authentication Keys</div><br>";
exit();
}


if($http_status == 408){
echo "<div class='alerts_summarize' style='background:red;color:white;padding:10px;border:none;'>Request Timeout</div><br>";
exit();
}


if($http_status == 429){
echo "<div class='alerts_summarize' style='background:red;color:white;padding:10px;border:none;'>Too Many Request. Insufficient Quota</div><br>";
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

echo "
<div class='alert alert-info'> 
<div style='color:green;'>Content Summarized Successfully by Sambanova AI ....</div>
<b>Result: </b>$allContent<br>
</div></div>";

}







}


?>




