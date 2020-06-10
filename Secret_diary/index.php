<?php

	session_start();
	
	include("connection.php");

	$query="";
	$result="";
	$error="";
	//$count=0;
	if(array_key_exists("logout",$_GET)){
		unset($_SESSION["id"]);
		//echo $_SESSION["id"];
		setcookie("id","",time()-60*60);
		$_COOKIE["id"]="";

	}

	else if((array_key_exists("id",$_SESSION) AND $_SESSION["id"] ) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE["id"])){
		header("location: loggedInPage.php");
	}


if($_POST){
	$mail=$_POST["email"];
	$password=$_POST["password"];

	//$error="";

	if($mail=="")
		$error.="<br>An email address is required.";
	if($password=="")
		$error.="<br>Password is required";

 	if($mail!="" && !filter_var($mail, FILTER_VALIDATE_EMAIL))
 		$error.="<br>Invalid email format";

 	if($error!=""){
		$error='<div ><strong>There were error message(s) in your form:</strong>'.$error.'</div>';
	}
 	
	else{
			
		if($_POST['signUp']=='1'){

			$query="select * from diary_users where email='".mysqli_real_escape_string($link,$mail)."' limit 1";
		
			if(!mysqli_query($link,$query))
				echo"Cannot sign-in(2)";
		
			$result=mysqli_query($link,$query);

			if(	mysqli_num_rows($result)>0){
				
				$error.="<br>User already exists.";
			}



			else{

				$query="insert into diary_users(email,password,diary) values('".mysqli_real_escape_string($link,$mail)."','".mysqli_real_escape_string($link,$password)."','')";                  
				//echo$count;

				if(!mysqli_query($link,$query)){
					$error.="<br>Couldn't sign-up. Please try again later(3)";

				}
				else{
					//echo "Successful";
					//$recent_id=mysqli_insert_id($link);
					$query="update diary_users set password='".md5(md5(mysqli_insert_id($link)).$password)."' where id=".mysqli_insert_id($link)." limit 1 ";
					mysqli_query($link,$query);
						
					$query="select id from diary_users where email='".mysqli_real_escape_string($link,$mail)."'";
					$row=(mysqli_fetch_array(mysqli_query($link,$query)));
					$current_id=$row["id"];
					$_SESSION['id']=$current_id;
					echo "Session id: ".$_SESSION['id'];
				    if($_POST["stayLoggedIn"]=='1'){
				    	setcookie("id",$current_id,time()+60*60*24*365);
				    }
					header("location: loggedInPage.php");

				}
				
			}

		}

		else{

			$query="select * from diary_users where email='".mysqli_real_escape_string($link,$mail)."'";
			$result=mysqli_query($link,$query);
			$row=mysqli_fetch_array($result);

			if(isset($row)){
				$hashed_password=md5(md5($row['id']).$password);
				if($hashed_password==$row['password']){
					$_SESSION['id']=$row['id'];
					echo "Session id: ".$_SESSION["id"];
					 if($_POST["stayLoggedIn"]=='1'){
				    	setcookie("id",$row["id"],time()+60*60*24*365);
				    }
					header("location: loggedInPage.php");

				}
				else{
					$error.="<br>Incorrect email/Password Entered.";
				}
			}
			else{
				$error.="<br>The email/password couldn't not found";
			}
			
		}

		if($error!=""){
			$error='<div ><strong>There were error message(s) in your form:</strong>'.$error.'</div>';
		}
	}
		
	

}



?>

	<?php include("header.php") ?>

	<div class="container" id="homepagecontainer">
		<h1>Secret Diary</h1>
		<p><strong>Store your thoughts securely and permanently</strong>

			<div id="errorMessage" class="form-group col-12">
		<?php echo $error; ?>	
	</div>

	<form method="post" id="signUpForm">	
		
		<p>Interested? Signup now.</p>

	    <fieldset class="form-group">
	    	<input type="email" class="form-control" placeholder="email" name="email">
		</fieldset>

		<fieldset class="form-group">
	    	<input name="password" class="form-control" type="password" placeholder="password">
		</fieldset>

		<div class="form-check">
		<label>
	  		<input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
	 		Stay Logged In
	 	</label>
	  	</div>
	  	<input type="hidden" name="signUp" value="1">

		<fieldset>
		  	<input type="submit" class="btn btn-primary col-3" value="Sign-up">
		</fieldset>
			<p></p>
			<p><a href="#" class="toggleForm">Log in </a></p>

	</form>

	
	<form method="post" id="logInForm">	
		
		<p>Login using your username and password.</p>
    	<fieldset class="form-group">
	    	<input type="email" class="form-control" placeholder="email" name="email">
		</fieldset>

		<fieldset class="form-group">
	    	<input name="password" class="form-control" type="password" placeholder="password">
	</fieldset>
		<div class="form-check">
		<label>
	  		<input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
	 		Stay Logged In
	 	</label>
	  	</div>

	  	<input type="hidden" name="signUp" value="0">
	<fieldset class="form-group">		
	  	<input type="submit" class="btn btn-primary col-3" value="Log-in">
	</fieldset> 
	<p><a href="#" class="toggleForm">Sign-up</a></p>
	</form>
		

</div>

<?php include("footer.php");?>