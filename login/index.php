<!DOCTYPE html>
<html>
	<head>
		<meta name="google-signin-client_id" content="1049698629280-prai66q0v2fba7d4vp701jo6d4mb9kct.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
	</head>
	<body>
		<?php
			require_once('connection.php');
			//verify password login and set login cookie
			if(isset($_POST['pass'])) {

			}
		?>
		<div class='section'>
			<p>Students or staff:</p>
			<div class="g-signin2" data-onsuccess="onSignIn"></div>
		</div>
		<div class='section'>
			<p>Password sign-in:</p>
			<form name="login" method="post" action="#">
    			<input name="pass" type="password" placeholder="Password" required>
			<input type="submit" name="submit" value="Sign In">
		</form>
		</div>
		<script>
			var sendUserData = function(name,imgurl) {
			    var xmlHttp = new XMLHttpRequest();
			    xmlHttp.open("GET", "auth.php?name=" + name+ "&imgurl=" + imgurl, false);
			    xmlHttp.send(null);
			    return (xmlHttp.responseText);
			}
			function signOut() {
				gapi.auth2.getAuthInstance().disconnect();
				window.location.href = window.location.href;
			}
			function onSignIn(googleUser) {
		  		var profile = googleUser.getBasicProfile();
		  		var authresult = sendUserData(profile.getName(), profile.getImageUrl());
		  		if(authresult >= 1) {
					console.log(authresult);
					if(window.location.href.includes("?to=")){
		  				window.location.href = window.location.href.split("?to=")[1];
						console.log(window.location.href.split("?to=")[1]);
					} else {
						window.location.href = "/test.php"; //change to be index
					}
		  		} else {
					signOut();
					alert("It looks like you're not a user in our database. Please try a different Google account or use password login.");
					console.log(0);
				}
			}
    </script>
</head>
</html>
