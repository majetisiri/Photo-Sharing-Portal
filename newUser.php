<?php

include 'functions.php';
include 'navHeader.php';

session_start();

$uid = $_SESSION['id'];

$postErr = "";
if(isset($_POST["post_data"]) && isset($_FILES['fileToUpload'])){
	$file_new_name = fileupload();
	$post =$_POST["post_data"];
	if($post!= NULL && $file_new_name!= NULL){
		$uid= $_SESSION['id'];
		
		$result= QueryBuilder::insertPost($conn,$post, $file_new_name, $uid);
	}
	else{
		$postErr = "No post";
	}
	
}

postModal($postErr);
echo '

<div class="container">
  <div class="jumbotron col-md-6">
    <h2>Welcome to Photo Sharing Portal <i class="fa fa-camera-retro" aria-hidden="true"></i></h2> </br>
     <div>
     	<h3><i class="fa fa-arrow-right" aria-hidden="true"></i> Step 1: Upload a profile picture and fill details.</h3>
     	<span class="help-block">Click on photo sharing portal in the navigation bar</span>
        <img src="http://www.hbc333.com/data/out/190/47199326-profile-pictures.png" alt="upload"/>
     </div>
     <hr class="style16">
     <div>
     	<h3><i class="fa fa-arrow-right" aria-hidden="true"></i> Step 2: Add friends you know who are already in PSP.</h3>
     	<span class="help-block">Click on find friends in the navigation bar</span>
     </div>
     <hr class="style16">
     <div>
     	<h3><i class="fa fa-arrow-right" aria-hidden="true"></i> Step 3: Upload picture, add description and POST!!</h3>
     	<span class="help-block">Click on post in the navigation bar</span>
     </div></br></br>
     <button class="btn btn-primary starttour" id="one">Start Tour</button>
  </div>
  <div class="col-md-6">
     <div>
     	<img src="https://img.clipartfest.com/866b05e489cf9ba04221074335737785_camera20clipart20black20and-black-camera-clipart_440-445.jpeg" alt="camera" class="col-md-offset-2" width="250px" height="250px">
     </div>
     <div>
     	<img src="https://img.clipartfest.com/9a50045c143e3768d51d6c01cab5bee0_color-black-white-say-cheese-for-a-photo-black-and-white-clipart_1500-961.jpeg" alt="say cheese"  class="col-md-offset-10" width="250px" height="250px"/>
     </div>
     <div>
     	<img src="http://img.clipartall.com/face-transparent-background-smile-clipart-1024_1024.jpg" alt="upload" class="col-md-offset-2" width="250px" height="250px"/>
     </div>
  </div>
</div>

<script type="text/javascript">
var uid = '.$_SESSION["id"].'
</script>
<script>
    var tour = new Tour({
      steps: [
      {
        element: "#one",
        title: "Welcome",
        content: "Welcome to our app, take this tour to be familirized with it."
      },
      {
        element: "#two",
        title: "Your profile",
        content: "Click this to look at your profile."
      },
      {
        element: "#three",
        title: "View Posts",
        content: "Click this tab to view posted photos."
      },
      {
        element: "#four",
        title: "Add Friends",
        content: "Click this tab to view people in the app and add them as your friend."
      },
      {
        element: "#five",
        title: "Accept/Decline Friend Request",
        content: "Click this to view your friend requests."
      },
      {
        element: "#six",
        title: "Post",
        content: "Click this to post pictures."
      },
      {
        element: "#seven",
        title: "Logout",
        content: "Click this to Logout."
      },
      {
        element: "#eight",
        title: "Settings",
        content: "Click this tab to upload your profle picture and update your personal information."
      }
    ]
    });

    tour.init();

    $(".starttour").click(function(){
      tour.start();
    });
</script>

';
?>