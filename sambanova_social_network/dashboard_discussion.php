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



 <li class="navgate_no"><a title='Add New Post' data-toggle='modal' data-target='#myModal_post' style="color:white;font-size:14px;">
<button class="category_post1">Add New Posts</button></a></li>



 <li class="navgate_no"><a href='bully_reports.php' title='View Bully AI Reports' style="color:white;font-size:14px;">
<button class="category_post1">View Bully Reports<br> By Sambanova AI</button></a></li>


             
<li class="navgate"><img style="max-height:40px;max-width:40px;" class="img-circle" width="40px" height="40px" src='backend/users_photos/<?php echo $photo_sess; ?>'>



<span class="dropdown">
  <a style="color:white;font-size:14px;cursor:pointer;" title='' class="btn1 btn-default1 dropdown-toggle"  data-toggle="dropdown">
<br><?php echo $fullname_sess; ?></span></a>

</span>

</li>


 <li style=''class="navgate_no"><a title='Logout' href='logout.php' style="color:white;font-size:14px;">
<button class="category_post1 ">Logout</button></a></li>


      </ul>




    </div>
  </div>



</nav>


    </div><br /><br />

<!-- end column nav-->






<br>
<br>

<div class='row'>



<center><h3>Welcome  <b><?php echo $fullname_sess; ?></b></h3></center>

<div class='col-sm-1'></div>
<div class='col-sm-10'>
<h3>Post Discussion Safeguard by <b>Sambanova AI</b>
</h3>


</div>

<div class='col-sm-1'></div>

<!--left starts-->
<!--left ends-->



  <script>
// Get Data for Comment
$(document).ready(function(){
$('.comment_btns').click(function(){



var postid = $(this).data('postid');
var title = $(this).data('title');
$('.postid_p').html(postid);
$('.title_p').html(title);
//$('.title_value').val(title).value;
var post_id = postid;


var comment_count = $(this).data('comment_countx');
//$("#comment_totalx_"+postid).html(comment_count);
$("#comment_totalx").html(comment_count);

if(post_id == ''){
alert('Post Id cannot be empty');
return false;
}
$("#loader-comment").fadeIn(400).html('<span style="color:;background:;padding:10px;"><img src="loader.gif">&nbsp;Please Wait, Loading Comments.</span>');
        $.ajax({
            url: 'backend/comment_loading.php',
            type: 'post',
            data: {post_id:post_id},
            dataType: 'html',
            success: function(data){
$("#result_comment").html(data);
$("#loader-comment").hide();

            }
        });

});
});





// Get Data for Comment for Post Pagination
$(document).ready(function(){
//$('.comment_btns2').click(function(){
$(document).on( 'click', '.comment_btns2', function(){ 


var postid = $(this).data('postid');
var title = $(this).data('title');
$('.postid_p').html(postid);
$('.title_p').html(title);
//$('.title_value').val(title).value;
var post_id = postid;


var comment_count = $(this).data('comment_countx');
//$("#comment_totalx_"+postid).html(comment_count);
$("#comment_totalx").html(comment_count);

if(post_id == ''){
alert('Post Id cannot be empty');
return false;
}
$("#loader-comment").fadeIn(400).html('<span style="color:;background:;padding:10px;"><img src="loader.gif">&nbsp;Please Wait, Loading Comments.</span>');
        $.ajax({
            url: 'backend/comment_loading.php',
            type: 'post',
            data: {post_id:post_id},
            dataType: 'html',
            success: function(data){
$("#result_comment").html(data);
$("#loader-comment").hide();

            }
        });

});
});



// report to admin
$(document).ready(function(){
$(document).on( 'click', '.report_btnx', function(){ 
//$(".report_btnx").click(function(){

alert('Report Sent');
});
});




// post comments


$(document).ready(function(){
$(document).on( 'click', '.comment_send_btn', function(){ 
 //$("."comment_send_btn").click(function(){
var postid = $(this).data('postid');
var id = this.id; 
var comdesc = $('#comdesc').val();
var userid_sess_data = '<?php echo $userid_sess; ?>';
var fullname_sess_data =  '<?php echo $fullname_sess; ?>';
var photo_sess_data = '<?php echo $photo_sess; ?>';
if(comdesc == ''){
alert('comment cannot be empty');
return false;
}
        // AJAX Request


$("#loader_comments_send").fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif">&nbsp;Please Wait, Comments is being Proccessed by Sambanova AI For Bully and Offensive Words.</div>');

        $.ajax({
            url: 'backend/comment_sambanova_bully_detection.php',
            type: 'post',
            data: {postid:postid,comdesc:comdesc,userid_sess_data:userid_sess_data,fullname_sess_data:fullname_sess_data,photo_sess_data:photo_sess_data},
            dataType: 'json',
            success: function(data){



  var error_msg = data['error_msg'];
 var error_status = data['error_status'];
if(error_status == 1){

alert(error_msg);
$("#loader_comments_send").hide();
}




                var comment = data['comment'];
                var comdesc = data['comdesc'];
                var comment_username = data['comment_username'];
                 var comment_fullname = data['comment_fullname'];
 var comment_photo = data['comment_photo'];
 var comment_time = data['comment_time'];
 var bully_status = data['bully_status'];
 var bully_status_trim = bully_status.trim();;
//$("#comment_total").text(comment);
$("#comment_total_"+postid).text(comment);
$("#comment_totalx").html(comment);

var com_counting =comment;
if(com_counting > 0){
$("#no_comment_hide").hide();
}



//check occurrence of word (Please provide) from output
var word_check = bully_status;
var bcount = (word_check.match(/Please/g) || []).length;
//var bcount2 = (word_check.match(/provide/g) || []).length;
//alert(bcount);


if(bully_status_trim == 'No-Bully-Words-Found-by-Sambanova-AI' || bcount >0){
var comment_status2 = 'No Bully Words Found by Sambanova AI.';
var comment_status3 =  "<span style='font-size:12px;text-align:left;background:green;color:white;padding:4px;border:none;'> " + comment_status2 + "</span>" ;

}else{
var comment_status2 = bully_status;
var comment_status3 =  "<span style='font-size:12px;text-align:left;background:red;color:white;padding:4px;border:none;'>Bully Words Found by Sambanova AI: --- " + comment_status2 + "</span>" ;

}


  var comment_json = "<div class='comment_css' style=''>" +
                   
 "<img style='border-style: solid; border-width:3px; border-color:#ec5574; width:40px;height:40px; max-width:40px;max-height:40px;border-radius: 50%;' src='backend/users_photos/" + comment_photo +"' /><br>" +
      "<span style='font-size:14px;text-align:left;color:#ec5574;'><b>Name</b>: " + comment_fullname + "</span><br>" +              
                    "<b style='font-size:12px;text-align:left;'>Comment: </b>" + comdesc + "<br>" +
                    //"<b style='font-size:12px;text-align:left;'>Bully Status: </b>" + comment_status3 + "<br>" +
"<div>" +  comment_status3 + "</div>" +
"<span style='color:#800000'><b> <span class='fa fa-calendar'></span>Time:</b> <span data-livestamp='" + comment_time + "'></span></span>"+
                    "</div><br>";
$("#result_comments_send").append(comment_json)
alert('Comment Added Successfully');

$('#comdesc').val('');

$("#loader_comments_send").hide();

            }
        });

    });

});






$(document).ready(function(){

 //$(".plike_btns").click(function(){
$(document).on( 'click', '.plike_btns', function(){ 

 var post_id = this.id; 
var id = post_id;
var title = $(this).data('title');
var userid_sess_data = '<?php echo $userid_sess; ?>';
var fullname_sess_data =  '<?php echo $fullname_sess; ?>';
var photo_sess_data = '<?php echo $photo_sess; ?>';
if(id == ''){
alert('Post Id cannot be empty');
return false;
}
        // AJAX Request


$("#loader-plike_"+id).fadeIn(400).html('<span style="color:;background:;padding:10px;"><img src="loader.gif">&nbsp;Please Wait, Sending your Likes.</span>');

        $.ajax({
            url: 'backend/post_like.php',
            type: 'post',
            data: {post_id:post_id, title:title,userid_sess_data:userid_sess_data,fullname_sess_data:fullname_sess_data,photo_sess_data:photo_sess_data},
            dataType: 'json',
            success: function(data){

var msg = data['msg'];
if(msg=='failed'){
alert('You Already Like This Posts');
$("#loader-plike_"+id).hide();
}
if(msg=='success'){
                var like = data['like'];       
$("#plike_total_"+id).text(like);
alert('Like Sent Successfully');
$("#loader-plike_"+id).hide();
}

            }
        });
    });
});

// post like ends




// Sambanova AI Summarization starts
$(document).ready(function(){

 //$(".Summarize").click(function(){
$(document).on( 'click', '.Summarize', function(){ 
var post_id = this.id; 
var id = post_id;
var content = $(this).data('content');

$("#result_ai_"+id).empty();
if(content == ''){
alert('Content cannot be empty');
return false;
}
        // AJAX Request


$("#loader_ai_"+id).fadeIn(400).html('<center><span style="color:black;background:#ddd;padding:2px;font-size:12px;"><img src="loader.gif">&nbsp; Summarizing Post Discussion.</span></center>');

        $.ajax({
            url: 'backend/sambanova_ai_summarization.php',
            type: 'post',
            data: {content:content},
            dataType: 'html',
            success: function(data){
$("#loader_ai_"+id).hide();
$("#result_ai_"+id).html(data);
$(".alerts_summarize").delay(5000).fadeOut('slow');
            }
        });
    });
});

// Sambanova AI Summarization ends






// Sambanova AI Keywords starts
$(document).ready(function(){

 //$(".Keywords").click(function(){
$(document).on( 'click', '.Keywords', function(){ 
var post_id = this.id; 
var id = post_id;
var content = $(this).data('content');

$("#result_ai_"+id).empty();
if(content == ''){
alert('Content cannot be empty');
return false;
}
        // AJAX Request


$("#loader_ai_"+id).fadeIn(400).html('<center><span style="color:black;background:#ddd;padding:2px;font-size:12px;"><img src="loader.gif">&nbsp;  Post Discussion Keywords Analysis.</span></center>');

        $.ajax({
            url: 'backend/sambanova_ai_keywords.php',
            type: 'post',
            data: {content:content},
            dataType: 'html',
            success: function(data){
$("#loader_ai_"+id).hide();
$("#result_ai_"+id).html(data);
$(".alerts_keywords").delay(5000).fadeOut('slow');
            }
        });
    });
});

// Sambanova AI Keywords ends




// Sambanova AI Bully Detection starts
$(document).ready(function(){

 //$(".Bully").click(function(){
$(document).on( 'click', '.Bully', function(){ 
var post_id = this.id; 
var id = post_id;
var content = $(this).data('content');

$("#result_ai_"+id).empty();
if(content == ''){
alert('Content cannot be empty');
return false;
}
        // AJAX Request


$("#loader_ai_"+id).fadeIn(400).html('<center><span style="color:black;background:#ddd;padding:2px;font-size:12px;"><img src="loader.gif">&nbsp;  Post Discussion Bully Words Detection Analysis.</span></center>');

        $.ajax({
            url: 'backend/sambanova_ai_bully.php',
            type: 'post',
            data: {content:content},
            dataType: 'html',
            success: function(data){
$("#loader_ai_"+id).hide();
$("#result_ai_"+id).html(data);
$(".alerts_bully").delay(5000).fadeOut('slow');
            }
        });
    });
});

// Sambanova AI Bully Detection ends





// Sambanova AI Sentiments starts
$(document).ready(function(){

 //$(".Sentiments").click(function(){
$(document).on( 'click', '.Sentiments', function(){ 
var post_id = this.id; 
var id = post_id;
var content = $(this).data('content');

$("#result_ai_"+id).empty();
if(content == ''){
alert('Content cannot be empty');
return false;
}
        // AJAX Request


$("#loader_ai_"+id).fadeIn(400).html('<center><span style="color:black;background:#ddd;padding:2px;font-size:12px;"><img src="loader.gif">&nbsp;  Post Discussion Sentiments Analysis.</span></center>');

        $.ajax({
            url: 'backend/sambanova_ai_sentiments.php',
            type: 'post',
            data: {content:content},
            dataType: 'html',
            success: function(data){
$("#loader_ai_"+id).hide();
$("#result_ai_"+id).html(data);
$(".alerts_sentiments").delay(5000).fadeOut('slow');
            }
        });
    });
});

// Sambanova AI Sentiments ends





// Sambanova AI Translate starts
$(document).ready(function(){

 //$(".Translate").click(function(){
$(document).on( 'click', '.Translate', function(){ 
var post_id = this.id; 
var id = post_id;
var content = $(this).data('content');
var lang = $("#lang_"+id).val();

if(lang ==''){
alert("Please Select Language to be Translated Content Description to");
return false;
}

$("#result_ai_"+id).empty();
if(content == ''){
alert('Content cannot be empty');
return false;
}
        // AJAX Request


$("#loader_ai_"+id).fadeIn(400).html('<center><span style="color:black;background:#ddd;padding:2px;font-size:12px;"><img src="loader.gif">&nbsp;  Post Discussion is being Translated.</span></center>');

        $.ajax({
            url: 'backend/sambanova_ai_translate.php',
            type: 'post',
            data: {content:content, lang:lang},
            dataType: 'html',
            success: function(data){
$("#loader_ai_"+id).hide();
$("#result_ai_"+id).html(data);
$(".alerts_translate").delay(5000).fadeOut('slow');
            }
        });
    });
});

// Sambanova AI Translate ends



</script>





<div class="col-sm-12">

<!---start --->
 <div class="content">

            <?php

include('backend/db_connection.php');
		
            $rowpage = 1000;
            $limit = 1000;


$res= $db->prepare("SELECT count(*) as totalcount FROM posts");
$res->execute(array());
$t_row = $res->fetch();
$totalcount = $t_row['totalcount'];

if($totalcount == 0){
echo "<div style='background:red;color:white;padding:10px;border:none;'>No Content Posted  Yet...</div>";
//exit();
}


$result = $db->prepare("SELECT * FROM posts order by id desc");
$result->execute(array());

$count_post = $result->rowCount();

while($row = $result->fetch()){


$id = htmlentities(htmlentities($row['id'], ENT_QUOTES, "UTF-8"));
$postid = $id;
$title = htmlentities(htmlentities($row['title'], ENT_QUOTES, "UTF-8"));
$title_seo = htmlentities(htmlentities($row['title_seo'], ENT_QUOTES, "UTF-8"));
$content = htmlentities(htmlentities($row['content'], ENT_QUOTES, "UTF-8"));
$fullname = htmlentities(htmlentities($row['fullname'], ENT_QUOTES, "UTF-8"));
$userphoto = htmlentities(htmlentities($row['userphoto'], ENT_QUOTES, "UTF-8"));
$timer1 = htmlentities(htmlentities($row['timer'], ENT_QUOTES, "UTF-8"));
$post_userid = htmlentities(htmlentities($row['userid'], ENT_QUOTES, "UTF-8"));
$category = htmlentities(htmlentities($row['category'], ENT_QUOTES, "UTF-8"));
$microcontent = substr($content, 0, 120)."...";
$microtitle = substr($title, 0, 80)."..";

$total_comment = htmlentities(htmlentities($row['total_comments'], ENT_QUOTES, "UTF-8"));
$t_like = htmlentities(htmlentities($row['total_like'], ENT_QUOTES, "UTF-8"));

$bully_word = htmlentities(htmlentities($row['bully_word'], ENT_QUOTES, "UTF-8"));
$bully_status = htmlentities(htmlentities($row['bully_status'], ENT_QUOTES, "UTF-8"));
//style='display:inline-block;height:600px;'


if ($bully_status == '0') {
$bully_statusx =  "<span class='alert alert-success'> 
<span style='color:green;font-size:12px;'>No Bully Words Found by Sambanova AI ....</span>
</span>";


} 



if ($bully_status == '1') {

$bully_statusx = "<span class='alert alert-danger'> 
<span style='color:red;font-size:12px;'>
<b>Bully Words Detected by Sambanova: </b>$bully_word </span>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='report_btnx' style='color:#800000;cursor:pointer;font-size:12px' title='Report to Admin'>Report to Admin</span>
</span>";
}



      ?>

                    <div class="post col-sm-4_no well" id="post_<?php echo $id; ?>">



<img style='max-height:60px;max-width:60px;' class='img-circle' src='backend/users_photos/<?php echo $userphoto; ?>' alt='User Image'>

<span style='color:blue;'><b>Created By: </b> <?php echo $fullname;?></span>




<h3 style='font-size:18px;color:<?php echo $header_color; ?>'>Title: <?php echo $title; ?></h3>
<b>Content Description:</b> <span id="post_data_<?php echo $postid; ?>"><?php echo $content; ?></span><br>
<br><span style='font-size:16px;color:#800000'><?php echo $bully_statusx; ?></span><br><br>

<span>

&nbsp;<span data-comment_countx='<?php echo $total_comment; ?>' data-title='<?php echo $title; ?>' data-postid='<?php echo $postid; ?>' id="<?php echo $postid; ?>" data-toggle='modal' data-target='#myModal_comments' style="color:#800000;font-size:26px;cursor:pointer;" title="Comments" class="fa fa-comments-o comment_btns" title='Comments' data-toggle='modal' data-target='#myModal_comments' id='<?php echo $postid; ?>' data-total_comment='<?php echo $total_comment; ?>'> <span style='font-size:14px;'>Comments</span>  </span>
<span style='font-size:14px;color:#800000;'>(<span id="comment_total_<?php echo $postid; ?>"><?php echo $total_comment; ?></span>)</span>

</span>


<span>

<span data-title='<?php echo $title; ?>' style="font-size:26px;color:#800000;cursor:pointer;" class="plike_btns fa fa-heart-o" id="<?php echo $postid; ?>" title="Like">
&nbsp;<span id="<?php echo $postid; ?>"  style="color:#800000;" /></span>
<span style='font-size:14px'>(<span id="plike_total_<?php echo $postid; ?>"><?php echo $t_like; ?></span>)</span>
</span> 

<span id="loader-plike_<?php echo $postid; ?>"></span>
</span>

<br>
<span style='color:#800000;'><b> Created Since: </b> <span data-livestamp="<?php echo $timer1;?>"></span></span>

         
<div class='row'>
<center><b style='font-size:12px;color:#800000'>Sambanova AI Discussion Analysis</b></center>
<span id="loader_ai_<?php echo $postid; ?>"></span>
<div id="result_ai_<?php echo $postid; ?>"></div>


<select  id="lang_<?php echo $postid; ?>" name="lang_<?php echo $postid; ?>" style='min-width:170px;min-height:20px;max-width:170px;max-height:20px;'>
    <option value=''>--- Select Languages ----</option>
    <option value="Arabic"  >Arabic</option>
    <option value="Bengali">Bengali</option>
    <option value="Bosnian">Bosnian</option>
    <option value="Chinese">Chinese</option>
    <option value="Croatian">Croatian</option>
    <option value="Czech">Czech</option>
    <option value="Danish">Danish</option>
    <option value="Dutch - Nederlands">Dutch - Nederlands</option>
    <option value="English">English</option>
    <option value="Estonian">Estonian</option>
    <option value="Finnish">Finnish</option>
    <option value="French">French</option>
    <option value="Galician">Galician</option>
    <option value="Georgian">Georgian</option>
    <option value="German">German</option>
    <option value="Greek">Greek</option>
    <option value="Guarani">Guarani</option>
    <option value="Gujarati">Gujarati</option>
    <option value="Hausa">Hausa</option>
    <option value="Hawaiian">Hawaiian</option>
    <option value="Hindi">Hindi</option>
    <option value="Hebrew">Hebrew</option>
    <option value="Hungarian">Hungarian</option>
    <option value="Icelandic">Icelandic</option>
    <option value="Indonesian">Indonesian</option>
    <option value="Irish">Irish</option>
    <option value="Italian">Italian</option>
    <option value="Japanese">Japanese</option>
    <option value="Kannada">Kannada</option>
    <option value="Korean">Korean</option>
    <option value="Kurdish">Kurdish - Kurdî</option>
    <option value="Kyrgyz">Kyrgyz</option>
    <option value="Lao">Lao</option>
    <option value="latin">Latin</option>
    <option value="Latvian">Latvian</option>
    <option value="Lingala">Lingala</option>
    <option value="Lithuanian">Lithuanian</option>
    <option value="Macedonian">Macedonian</option>
    <option value="Malay">Malay</option>
    <option value="Malayalam">Malayalam</option>
    <option value="Maltese">Maltese</option>
    <option value="Marathi">Marathi</option>
    <option value="Mongolian">Mongolian</option>
    <option value="Nepali">Nepali</option>
    <option value="Norwegian">Norwegian</option>
    <option value="Persian">Persian </option>
    <option value="Polish">Polish</option>
    <option value="Portuguese">Portuguese</option>
    <option value="Punjabi">Punjabi</option>
    <option value="Romanian">Romanian</option>
    <option value="Russian">Russian</option>
    <option value="Scottish">Scottish</option>
    <option value="Serbian">Serbian</option>
    <option value="Serbo-Croatian">Serbo-Croatian</option>
    <option value="Slovenian">Slovenian</option>
    <option value="Somali">Somali</option>
    <option value="Spanish">Spanish</option>
    <option value="Sundanese">Sundanese</option>
    <option value="Swedish">Swedish</option>
    <option value="Tajik">Tajik</option>
    <option value="Tamil">Tamil</option>
    <option value="Telugu">Telugu</option>
    <option value="Turkish">Turkish</option>
    <option value="Turkmen">Turkmen</option>
    <option value="Ukrainian">Ukrainian</option>
    <option value="Urdu">Urdu</option>
    <option value="Vietnamese">Vietnamese</option>
</select><br>

<div style='font-size:12px;text-align:center' title='Translate' class='col-sm-3 Translate  translate_css' data-toggle='modal' id='<?php echo $id;?>' data-content='<?php echo $content; ?>' data-target='#myModal_translate'>
 Translate</div>
<div style='font-size:12px;text-align:center' title='Summarize' class='col-sm-3 Summarize  translate_css' id='<?php echo $id;?>' data-content='<?php echo $content; ?>'> Summarize</div>
<div style='font-size:12px;text-align:center' title='Sentiments' class='col-sm-3 Sentiments translate_css' id='<?php echo $id;?>' data-content='<?php echo $content; ?>'> Sentiments</div>
<div style='font-size:12px;text-align:center' title='Keywords' class='col-sm-3 Keywords translate_css' id='<?php echo $id;?>' data-content='<?php echo $content; ?>'> Keywords</div>
<div style='display:none;font-size:12px;' title='Bully Detection' class='col-sm-4 Bully translate_css' id='<?php echo $id;?>' data-content='<?php echo $content; ?>'> Bully Detection</div>

</div>



</div>





            <?php

                }
            ?>
<center>
<div id="loader_posts" class="loader_posts"></div>
<div id="nomore_content_check_no"></div>
            <input type="hidden" id="row_limit" value="0">
            <input type="hidden" id="total_count" value="<?php echo $totalcount; ?>">
<br><br>
<button  id="loadmore_btn" title='Load More Content' class="loadmore_css col-sm-12">Load More Content</button>
<br><br>
</center>
<div class="col-sm-12">.</div>
<br class="col-sm-12"><br class="col-sm-12">



</div>
<!---end --->


    </div>

</div>
<!---end row--->
<style>

.css_aix{
background:#800000;color:white;padding:6px;border:none;border-radius:25%;
//margin: 0 1%;
margin: 0.2%;
display: inline-block;
}

.css_aix:hover{
background: orange;
color:black;

}
</style>





<script>
//Posts starts
$(document).ready(function(){
                $('#post_btn').click(function () {
				
 var category = $(".category:checked").val();
 var titleo = $('#titleo').val();
 var desco = $('.desco').val();
var userid_sess_data = '<?php echo $userid_sess; ?>';
var fullname_sess_data =  '<?php echo $fullname_sess; ?>';
var photo_sess_data = '<?php echo $photo_sess; ?>';

 if(titleo==""){
alert('Post Title Cannot be Empty');
}
else if(desco==""){
alert('Post Description Cannot be Empty');
}



else{


          var form_data = new FormData();
          form_data.append('titleo', titleo);
          form_data.append('desco', desco);
          form_data.append('userid_sess_data',userid_sess_data);
          form_data.append('photo_sess_data', photo_sess_data);
          form_data.append('fullname_sess_data', fullname_sess_data);


                    $('.upload_progress').css('width', '0');
					$('#loaderx').hide();
                    $('#loader_post').fadeIn(400).html('<br><div class="well" style="color:black"><img src="loader.gif">&nbsp;Please Wait, Your Data is being Processed by Sambanova AI.</div>');
                    $.ajax({
                        url: 'backend/discussion_post_sambanova_bully_detection.php',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        ache: false,
                        type: 'POST',
                        success: function (msg) {
				$('#loader_post').hide();
				$('.result_post').fadeIn('slow').prepend(msg);
				$('#alerts_post').delay(5000).fadeOut('slow');
                                $('#alerts_posta').delay(5000).fadeOut('slow');
                               $('#alerts_post_bully').delay(5000).fadeOut('slow');
//strip all html elemnts using jquery
var html_stripped = jQuery(msg).text();
//alert(html_stripped);

//check occurrence of word (successfully) from backend output already html stripped.
var Frombackend = html_stripped;
var bcount = (Frombackend.match(/Successfully/g) || []).length;
//alert(bcount);

if(bcount > 0){
$('#file_content').val('');
}

}
});





} // end if validate




                });
            });

// Posts ends

</script>




<!-- Comments starts here -->


<div class="container_map">

  <div class="modal fade" id="myModal_comments" role="dialog">
    <div class="modal-dialog modal-lg  modal-appear-center1 pull-right1_no modaling_sizing1  full-screen-modal_no">
      <div class="modal-content">
        <div class="modal-header" style="color:black;background:#c1c1c1">
 

      
 <button type="button" class="close btn btn-warning" data-dismiss="modal">Close</button>

      <h4 class="modal-title">Comments System For:  <span style='color:purple' class='title_p'></span></h4>

<center><b>Total Comments: </b> <span id="comment_totalx"></span></center><br>

        </div>
        <div class="modal-body">


<!-- start-->

<!--start comment-->


<div id="loader-comment"></div>
<div id="result_comment"></div>





<!--end comment-->


<!-- end -->


<br><br>
<br><span style='font-size:12px;color:red'> Comments Monitored for Insults, Bullies etc. by Sambanova AI</span>

        </div>
      

   <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>


      </div>


      </div>
    </div>
  </div>
</div>



<!-- Comments modal ends here -->











<!-- Post Modal starts -->



<div id="myModal_post" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"  style='background: black;color:white;padding:10px;'>
        <h4 class="modal-title">Post New Contents</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">







<div class="form-group">
<label style="">Post Title</label>
<input style="" class="col-sm-12 form-control" type="text" id="titleo" name="titleo" placeholder="Post Tile"/>

</div><br>


<div class="form-group">
<label style="">Post Description</label>
<textarea class="col-sm-12 form-control " rows="5" cols="10" id="content1"  placeholder="Post Description"></textarea><br>

<input type='text' id='content2' placeholder='Enter Text Contents' class='desco' style='width:10px;height:10px;'>

</div>
<div class='col-sm-12'></div>


 <div class="form-group col-sm-12">
                        
						<div id="loader_post"></div>
                        <div class="result_post"></div>
                    </div>

                    <input type="button" id="post_btn" class="btn btn-primary" value="Post Now" />

<br><br>
<br><span style='font-size:12px;color:red'> Post Discussion Monitored for Insults, Bullies etc. by Sambanova AI</span>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- Post  Modal ends -->






<script>
const textarea = document.getElementById('content1');
const inputField = document.getElementById('content2');

// Add event listeners to both elements
textarea.addEventListener('input', () => {
  inputField.value = textarea.value;
});

inputField.addEventListener('input', () => {
  textarea.value = inputField.value;
});

</script>





  </body>
</html>
