<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-signin-client_id" content="1049698629280-prai66q0v2fba7d4vp701jo6d4mb9kct.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script>
		function signOut() {
			gapi.auth2.getAuthInstance().disconnect();
			window.location.href = '../login';
		}
		function findGetParameter(parameterName) {
			var result = null,
			tmp = [];
		location.search
			.substr(1)
			.split("&")
			.forEach(function (item) {
				tmp = item.split("=");
				if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
			});
			return result;
		}
			function load(){
				if(findGetParameter('out') == 'true') {
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open("GET", "auth.php?out=" + 'true', false);
					xmlHttp.send(null);
					signOut();
				}
				if(findGetParameter('wrong') == 'true') {
					$("#wrong").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">  <strong>Wrong password.</strong> Please try again. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button></div>');
				}
				if(findGetParameter('inv') == 'true') {
					$("#wrong").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">  <strong>It looks like you\'re not a user.</strong> Please try a different account. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button></div>');
				}
			}
			window.onload = load;
		</script>
		<title>PSCS Attendance System Login</title>
	</head>
	<body style='background-color: #272626;'>
	<div id ='wrong'></div>
		<div class='container' style='height: 5rem;'></div>
		<div class="card text-white bg-dark mx-auto" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Google Login</h5>
					<div class='card-text'></div>
				</div>
				<div class="card-footer">
					<div id ='gs'class="g-signin2" data-onsuccess="onSignIn"></div>
				</div>
		</div>
		<br>
		<div class="card text-white bg-dark mx-auto" style="width: 18rem;">
			<form id = "pass" name="login" method="post" action="pass.php">
  			<div class="card-body">
    			<h5 class="card-title">Password Login</h5>
					<div class='card-text'>
		    		<input name="pass" type="password" class="form-control" id ="pass" placeholder="Password" required>
					</div>
  			</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="submit" name="submit">Sign In</button>
				</div>
			</form>
		</div>
		<script>
			var sendUserData = function(name,imgurl,email,minute) {
			    var xmlHttp = new XMLHttpRequest();
			    xmlHttp.open("GET", "auth.php?name=" + name + "&imgurl=" + imgurl + "&email=" + email + "&ver=" + minute, false);
			    xmlHttp.send(null);
			    return (xmlHttp.responseText);
			}
			$('#pass').submit(function() {
			signOut();
    	return true;
			});
			function onSignIn(googleUser) {
				if(findGetParameter('out') != 'true') {
		  		var profile = googleUser.getBasicProfile();
					var d = new Date();
    		 	var n = d.getMinutes();
					console.log(profile.getEmail());
		  		var authresult = sendUserData(profile.getName(), profile.getImageUrl(), profile.getEmail(), n);
		  		if(authresult >= 1) {
						console.log(authresult);
						if(window.location.href.includes("?to=")){
			  				window.location.href = window.location.href.split("?to=")[1];
							console.log(window.location.href.split("?to=")[1]);
						} else {
							window.location.href = "../";
						}
		  		} else {
						gapi.auth2.getAuthInstance().disconnect();
						window.location.href = '../login/?inv=true';
				}
			} else {
				var xmlHttp = new XMLHttpRequest();
				xmlHttp.open("GET", "auth.php?out=" + 'true', false);
				xmlHttp.send(null);
				signOut();
			}
			}
    </script>
</html>
