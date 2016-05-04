<!DOCTYPE html>
<html>
	<head>
		
		<style type="text/css">
		body {background-image:url(http://www.tercihisi.com/style/bg.jpg)}
		</style>
		<title> </title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		
		
	</head>
	
	
	<body>
		<!-- navbar  -->
		
		<nav class="navbar navbar-inverse">
			
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="http://localhost:8888/new_mainPage.php">Friend Social Networking</a>
				</div>

				
				
			  </div><!-- /.container-fluid -->
			  
			  
		</nav>
		
		<!--friend list-->

			<div class="col-sm-8">
				<div class="panel panel-default">
						  <!-- Default panel contents -->
						  <div class="panel-heading" > 
								
								<h5>Search Result</h5>	
								
						  </div>
						  <div class="panel-body">
							  <table>
								  <?php
									require "./SharedInformation.php";
								   session_start();
								   $user_phone=$_SESSION['phone'];
								   $search_content = $_POST["search_content"];
								  $visit=$_GET['id'];
								  if($visit!==null){ $search_content=$visit; }
								   $sql = "SELECT * FROM USERS WHERE USER_NAME ILIKE $1";
								   $reg_exp = "%" . $search_content . "%";
								   $resource = pg_prepare($db, "", $sql);
								   $resource = pg_execute($db, "", array($reg_exp));

								   $user_name_and_url_list = array();
								   if ($resource == false || pg_num_rows($resource) == 0) { 
								   } else {
									  $index = 0;
									  while ($array = pg_fetch_array($resource)) {
										 $user_name_and_url_list[$index]["user_name"] = $array["user_name"];
										  $user_name_and_url_list[$index]["user_id"] = $array["user_id"];
										 $user_name_and_url_list[$index]["url"] = $array["url"];
										 $index++;
									  }
								   }
								   for ($i=0; $i< count($user_name_and_url_list);$i++){
									   $query_result = pg_query($db, "SELECT REQUEST_ID FROM FRIENDSHIP WHERE REQUEST_ID = " . $user_phone . " and ACCEPT_ID = " . " $user_name_and_url_list[$i]['user_id']");
								  	while($queryID = pg_fetch_array($query_result)){
									  	$query_request=$queryID['request_id'];
								  	}
									   if($query_request!==null){ $query_request="hidden='hidden'";}
									  echo '<tr><a href="'. $user_name_and_url_list[$i]["url"] .'" >'. $user_name_and_url_list[$i]["user_name"] .'</a> </tr>';
									   echo '<form action="addNewFriend.php" method = "post" >
			<input type="hidden" name="request_id" value=' . $user_phone .' />
			<input type="hidden" name="accept_id" value=' . $user_name_and_url_list[$i]["user_id"] .' />
			<input type="hidden" name="search_content" value=' . $search_content .' />
							<input class="btn btn-default" type="submit" name="submit" value="Add friend" />
    </form></br>';
								   }
									?>
								</table>
						  
						  
						  </div>
				</div>
			</div>

           

     
	
	
	
	
	
	
	
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>	
	
</html>