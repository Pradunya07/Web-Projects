<?php

	session_start();
	$link=mysqli_connect("localhost","root","","webD practice");

	if(mysqli_connect_error()){
		die("CONNECTION fAILED");
	}
	$query="";
	$result="";
	$error="";
	//$count=0;
	/*
	if(array_key_exists('logout',$_GET)){
		unset($_SESSION);
		setcookie("id","",time()-60*60);
		$_COOKIE["id"]="";

	}

	else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
		header("location: loggedInPage.php");
	}
*/

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

	
	
	else{
			
		if($_POST['signUp']=='1'){

			$query="select * from d_u where email='".mysqli_real_escape_string($link,$mail)."' limit 1";
		
			if(!mysqli_query($link,$query))
				echo"Cannot sign-in(2)";
		
			$result=mysqli_query($link,$query);

			if(	mysqli_num_rows($result)>0){
				
				echo"Error! Please Try again";
			}

			else{

				$query="insert into d_u(email,password,diary) values('".mysqli_real_escape_string($link,$mail)."','".mysqli_real_escape_string($link,$password)."','')";                  
				//echo$count;

				if(!mysqli_query($link,$query)){
					$error.="<br>Couldn't sign-up. Please try again later(3)";

				}
				else{
					echo "Successful";
					$recent_id=mysqli_insert_id($link);
					$query="update d_u set password='".md5(md5($recent_id).$password)."' where id=".$recent_id." limit 1 ";
					mysqli_query($link,$query);
						
					$_SESSION['id']=$recent_id;
				    if($_POST["stayLoggedIn"]==1){
				    	setcookie("id",$recent_id,time()+60*60*24*365);
				    }
					header("location: loggedInPage.php");

				}
				
			}

		}

		else{

			$query="select * from d_u where email='".mysqli_real_escape_string($link,$mail)."'";
			$result=mysqli_query($link,$query);
			$row=mysqli_fetch_array($result);

			if(isset($row)){
				$hashed_password=md5(md5($row['id']).$password);
				if($hashed_password==$row['password']){
					$_SESSION['id']=$row['id'];
					 if($_POST["stayLoggedIn"]==1){
				    	setcookie("id",$recent_id,time()+60*60*24*365);
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
	}

	if($error!=""){
		$error='<div class="alert alert-danger" role="alert"><strong>There were error message(s) in your form:</strong>'.$error.'</div>';
	}
		

}



?>





<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Secret_Diary</title>


<style type="text/css">
	
	#errorMessage{
	
		border-radius:5px;
		padding:2px;
	}

</style>

</head>

<body>

	<div class="container">
		<h1>Secret Diary</h1>
	
	<div id="errorMessage" class="form-group col-8">
		<?php echo $error; ?>	
	</div>


	<form method="post">	
	
	    <input type="email" placeholder="email" name="email">
	
	    <input name="password" type="password" placeholder="password">

	  	<input type="checkbox" name="stayLoggedIn">

	  	<input type="hidden" name="signUp" value="1">
	  	<button type="submit" id="s_bt">Sign-up</button>
		
	
	
	</form>
</p>

	<p>
		<form method="post">	
		
		
  		<input type="email" placeholder="email" name="email">
	
	    <input name="password" type="password" placeholder="password">

	  	<input type="checkbox" name="stayLoggedIn">
	  	<input type="hidden" name="signUp" value="0">
	  	<button type="submit" id="s_bt">Log-in</button>
		</div>

	
	</form>

	

</div>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

