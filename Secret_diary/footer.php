
	

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script type="text/javascript">
		
		//console.log("abc");
		$(".toggleForm").click(function(){
			$("#signUpForm").toggle();
			$("#logInForm").toggle();

		});

	/*
	$.ajax("updatedatabase.php")
		.done(function(data){
		$("#diary").html(data);
	})
		.fail(function (){
		alert("Couldn't get data");
	});
*/
	$('#diary').bind('input propertychange', function() {
		$.ajax({
			  type: "POST",
			  url: "updatedatabase.php",
			  data: { content: $("#diary").val()}
		})
		
    });
	
		
	</script>


	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>

