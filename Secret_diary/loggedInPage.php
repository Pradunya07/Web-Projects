<?php
	session_start();
	$diaryContent="";
	//$result="";
	//$row="";
   //	echo "COOKIE ID: ".$_COOKIE["id"];

	if(array_key_exists("id",$_COOKIE)){

		$_SESSION['id']=$_COOKIE['id'];
		//echo "COOKIE ID: ".$_COOKIE["id"];
	}

	if(array_key_exists("id",$_SESSION) && $_SESSION["id"]){
	//	echo "<br>SESSION ID: ".$_SESSION["id"];
		//echo"<p>Logged In!<a href='index.php?logout=1'>Log out</a></p>";
		
		include("connection.php");
		$query="select * from diary_users where id='".mysqli_real_escape_string($link,$_SESSION['id'])."' limit 1";
		//$result=mysqli_query($link,$query);
		//echo mysqli_num_rows($result);
		$row=mysqli_fetch_array(mysqli_query($link,$query));
		$diaryContent=$row['diary'];
		
	}

	else{
		echo" signed in";

		header("location: index.php");
	}

	include("header.php");
?>

<nav class="navbar navbar-light bg-light justify-content-between">
  <a class="navbar-brand">Secret Diary</a>
  <div>
    
   <a href="index.php?logout=1"> <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
  </div>
</nav>

	<div class="container-fluid" id="containerText">
		<textarea id="diary" class="form-control">
			<?php echo $diaryContent; ?>

		</textarea>


	</div>

<?php
	
	include("footer.php");
	
?>