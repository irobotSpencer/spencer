<!--  Group3-Smart_Cleaner



 Group Members


- Jin Hui Chen
- Bilal Hussain
- Ck Obieyisi
- Shixun Huang -->

<!DOCTYPE html>
<html>
<head>
	<title>Calendar</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="25123215400-79lpb10ilu1otmnnv6g449ujjj68mhtu.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="script.js"></script>

    <style>

		#google_signIn{
			margin: 15px 30px 0 5px;
			border: 1px solid red;
			float: right;
			width: 520px;
			height: 590px;
		}
		.g-signin2{
			margin-left: 30%;
		}

		#calendar{
			display: none;
		}

		#set_calendar{
			display: none;
		}

		#schedule_text{
			display: none;
		}

		#event_id_alert{
			display: none;
		}
	</style>

</head>
<body>

	<iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;mode=WEEK&amp;height=600&amp;wkst=1&amp;bgcolor=%2399ff99&amp;src=07qu68hvb57ptqkn8vk5c1j8l0%40group.calendar.google.com&amp;color=%23182C57&amp;ctz=America%2FNew_York" id="calendar"
    style="border:solid 1px #777; float:right; width:700px; height:550px; margin-right: 10px; margin-top: 30px;" frameborder="0" scrolling="no"></iframe>


	<div id="google_signIn">
		<h4 id="profile" style="border-bottom: 1px solid red; background-color: silver; margin-top: 0;text-align: center">Click the button below to sign in</h4>
		<div class="g-signin2" data-onsuccess="onSignIn"></div>




	<div class="data">
   	<img id="pic" class="img-circle" width="50" height="50" style="margin-left: 3px;">

   	<p style="margin-left:2px;">Username:</p>
   	<p id="username" class="alert alert-danger"></p>

   	<p style="margin-left:2px;">Email address:</p>
   	<p id="email" class="alert alert-danger"></p>


	


	<?php 

	require_once('./connection.php');


	$client = getClient();
	if(! is_a ($client, "Google_Client")){
		echo $client;

	}


	




	else{
		?>
		<div id ="set_calendar" class="alert alert-danger" style="margin-left:2px; margin-bottom: 20px;">
		<p style="margin-left: 2px; margin-bottom: 5px">Schedule a time here:</p>
		<input type="date" id='available_dates'>
		<select id='available_times'></select>
		<button id='submit'>Schedule</button>
		<!-- <p id='dump' style="margin-left:2px; color:black;"></p> -->
		<br><br>
		<p style="margin-left: 2px; margin-bottom: 5px">Delete an event here:</p>
		<input type="text" id="eventid" name="" placeholder="Event Id">
		<button id='delete'>Delete</button>
		<!-- <p id='dump1' style="margin-left:2px"></p> -->
		</div>

		<script>
			//window.alert(document.getElementById('email').value);
			$(document).ready(function(){
				document.getElementById('available_dates').addEventListener('change', function(){
					get_times(this);

				})
				document.getElementById('submit').addEventListener('click', function(){
					createEvent(this);
				})

				document.getElementById('delete').addEventListener('click', function(){
					delete_me(this);
				})
			})

			function get_times(date_picker){
				var date = date_picker.value;

				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						document.getElementById('available_times').innerHTML = xhttp.responseText;

					}

				};
				xhttp.open('GET', 'http://localhost:3000/spencer/calendar/calendar.php?action=get_times&date='+date+'&t=' + Math.random());
				xhttp.setRequestHeader('X-Requested-With', 'xmlhttprequest');
				xhttp.send();
			}



			function createEvent(btn){
				var date = document.getElementById('available_dates').value;
				var time = document.getElementById('available_times').value;

				var xhttp = new XMLHttpRequest();

				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						//document.getElementById('dump').innerHTML = xhttp.responseText;
						window.alert(xhttp.responseText);
						//setTimeout(function(){ window.location = 'http://localhost:8888/Group3.github.io/calendar/'; }, 1500);
						window.location = 'http://localhost:3000/spencer/calendar/';

					}
				};
				xhttp.open('GET', 'http://localhost:3000/spencer/calendar/calendar.php?action=createEvent&date='+date+'&time=' +time+ '&t=' + Math.random());
				xhttp.setRequestHeader('X-Requested-With', 'xmlhttprequest');
				xhttp.send();

			}

			function delete_me(btn){

				var del_id=document.getElementById('eventid').value;

				var xhttp = new XMLHttpRequest();


				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						//document.getElementById('dump1').innerHTML = xhttp.responseText;
						window.alert(xhttp.responseText);
						//setTimeout(function(){ window.location = 'http://localhost:8888/Group3.github.io/calendar/'; }, 1500);
						window.location = 'http://localhost:3000/spencer/calendar/';
					}


				};

				xhttp.open('GET', 'http://localhost:3000/spencer/calendar/calendar.php?action=delete_me&del_id='+del_id);

				xhttp.setRequestHeader('X-Requested-With', 'xmlhttprequest');
				xhttp.send();

			}
		</script>
	
<p id="event_id_alert" style="border:1px solid black; margin: 1px 1px 30px 1px;background-color: black;color:white;">Forget your event id?<br>Send a message to jchunhui3@gmail.com</p>
<a href="https://mail.google.com/mail/u/0/?logout" target="_blank" onclick="signOut();" class="alert alert-danger">Sign out</a>

	<?php }
	 ?>
</body>
</html>