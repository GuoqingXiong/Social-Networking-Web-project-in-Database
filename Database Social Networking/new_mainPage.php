<?php

include 'SharedInformation.php';
session_start();
$user_phone=$_SESSION['phone'];
$visit=$_GET['id'];
$searchName=$user_phone;
if($visit!==null){ $searchName=$visit; }
$sqlName = "SELECT user_name FROM USERS WHERE USER_ID = $1";
$resource = pg_prepare($db, "", $sqlName);
$resource = pg_execute($db, "", array($searchName));
	$array = pg_fetch_array($resource);
	$userName = $array["user_name"];
?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>mainpage</title>
		<style type="text/css">
		body {background-image:url(http://www.tercihisi.com/style/bg.jpg)}
		</style>
		
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

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
						<li> 
							<div class="container-fluid" style="margin-top:-5px">
								<div class="navbar-header">
								  <a class="navbar-brand" href="http://localhost:8888/updateprofile.html">
									<img src="http://localhost:8888/upload/<?php echo $user_phone; ?>.jpg" width="35px" height="40px" border="0" />
									
								  </a>
								</div>
							</div>
						</li>
						<!-- profile -->
						<li>
							<a href="http://localhost:8888/showprofile.php?id=<?php echo $searchName; ?>"><?php echo $userName; ?></a>
						</li>
						
						<!-- friend_list -->
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Friends <span class="caret"></span></a>
						  <ul class="dropdown-menu">
								
							<?php
							require "./SharedInformation.php";
							$user_id = $user_phone;
							$sql1 = "SELECT list_friends($1)";
							$resource = pg_prepare($db, "", $sql1);
							$resource = pg_execute($db, "", array($user_id));

							$friend_list = array();
							if ($resource == false || pg_num_rows($resource) == 0) {
							} else {
								$index = 0;
								while ($array = pg_fetch_array($resource)) {
									$friend_list[$index]["user_id"] = $array["list_friends"];
									$index++;
								}
							}

							for ($index = 0; $index < count($friend_list); $index++) {

								$sql2 = "SELECT user_name, url FROM USERS WHERE USER_ID = $1";
								$resource = pg_prepare($db, "", $sql2);
								$resource = pg_execute($db, "", array($friend_list[$index]["user_id"]));
								if ($resource == false || pg_num_rows($resource) == 0) {
								} else {
									$array = pg_fetch_array($resource);
									$friend_list[$index]["user_name"] = $array["user_name"];
									$friend_list[$index]["url"] = $array["url"];
								}
							}

							for ($i=0; $i < count($friend_list); $i++){
								echo '<li> <a href=" '. $friend_list[$i]["url"] .' ">' . $friend_list[$i]["user_name"] .'</a></li>';
								}
							
									
							?>	
											
						  </ul>
						</li>
						
						<!-- request from friends-->
						
						<!-- accept-->
						<script language="javascript" type="text/javascript">
								function AJAXAccept(request_id, accept_id) {
									var hr = new XMLHttpRequest();
									var url = "DBFriendRequestAccept.php";
									var vars = "request_id=" + request_id + "&accept_id=" + accept_id;
									hr.open("POST", url, true);
									hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
									hr.onreadystatechange = function () {
										if(hr.readyState == 4 && hr.status == 200) {
											var return_data = hr.responseText;
											document.getElementById("status").innerHTML = return_data;
											location.href = return_data;
										}
									};
									hr.send(vars);
									document.getElementById("status").innerHTML = "processing...";
								}

							</script>	
						
						<!-- decline-->
						<script language="javascript" type="text/javascript">
								function decline(request_id, accept_id) {
									var hr = new XMLHttpRequest();
									var url = "DBFriendRequestDecline.php";
									var vars = "request_id=" + request_id + "&accept_id=" + accept_id;
									hr.open("POST", url, true);
									hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
									hr.onreadystatechange = function () {
										if(hr.readyState == 4 && hr.status == 200) {
											var return_data = hr.responseText;
											document.getElementById("status").innerHTML = return_data;
											location.href = return_data;
										}
									}
									hr.send(vars);
									document.getElementById("status").innerHTML = "processing...";
								}

							</script>
						
						<!--request friend list -->
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">New Friends Request<span class="caret"></span></a>
							<ul class="dropdown-menu">
							<?php
							require "./SharedInformation.php";
							$user_id = $user_phone;
							$sql = "SELECT REQUEST_ID FROM FRIENDSHIP WHERE ACCEPT_ID = $1 AND SUCCESSFUL = FALSE";
							$resource = pg_prepare($db, "", $sql);
							$resource = pg_execute($db, "", array($user_id));

							$friend_list = array();
							if ($resource == false || pg_num_rows($resource) == 0) {
							} else {
								$index = 0;
								while ($array = pg_fetch_array($resource)) {
									$friend_list[$index]["request_id"] = $array["request_id"];
									$index++;
								}
							}

							for ($index = 0; $index < count($friend_list); $index++) {
								$sql2 = "SELECT * FROM USERS WHERE USER_ID = $1";
								$resource = pg_prepare($db, "", $sql2);
								$resource = pg_execute($db, "", array($friend_list[$index]["request_id"]));
								if ($resource == false || pg_num_rows($resource) == 0) {
								} else {
									$array = pg_fetch_array($resource);
									$friend_list[$index]["user_name"] = $array["user_name"];
									$friend_list[$index]["url"] = $array["url"];
									$friend_list[$index]["user_id"] = $array["user_id"];
								}
							}
							
							/* post request list and button*/
							for($i=0; $i<count($friend_list);$i++){
								echo '<li> <a href= " '. $friend_list[$i]["url"] .'">'. $friend_list[$i]["user_name"] .'</a>';
								echo '<a href="" onclick="AJAXAccept(3,1)" class="btn btn-default">accept</a>';
//								echo '<a href="" onclick=\"AJAXAccept(' . $friend_list[$i]["request_id"] . ',' . $friend_list[$i]["user_id"] . ');\" class="btn btn-default">accept</a>';
								echo '<a href="" onclick="decline(3,1)" class="btn btn-default">decline</a>
								</li>' ;
							}
						?>

							</ul>
						</li>
					  </ul>

					 
					<!-- search -->


						<form class="navbar-form navbar-left" action="friendlist.php" method="post">
							<input type="text" class="form-control" name="search_content" placeholder="Search new Friend">
							<input type="submit" name="submit" value="submit"/>
						</form>



					  <ul class="nav navbar-nav navbar-right">
						<li><a href="http://localhost:8888/logout.php">Sign out</a></li>
						
					  </ul>
					</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
		</nav>
		

	





<div class="col-sm-8">
<?php
$theUserID=$user_phone;
if($visit !==null){
	$theUserID=$visit;
}

/* greeting */
$comment_result = pg_query($db, "SELECT BODY,USER_NAME FROM GREETING JOIN USERS ON GREETING.FROM_USER_ID=USERS.USER_ID WHERE TO_USER_ID = " . $theUserID);
echo '
			<div class="panel panel-default">
						  
						  <div class="panel-heading"> 
								
									<h5>Greeting from friends:</h5>
									
							</div>
							<div class="panel-body">
								<table>';
							/*post greetings*/
							while($comment_row = pg_fetch_array($comment_result)){
								echo '<tr>'. $comment_row['body'] . ' from <h6 style="font-family:cursive"><em>' . $comment_row['user_name'] . '</em></h6></tr><br/>';
							}
							/*write new greeting*/
							echo '</table>
							
									<form action="putGreeting.php" method="post">';
							echo '<input type="text" class="form-control" placeholder="say sth..." name="comment" />';
							echo '<input type="hidden" name="from_user_id" value=' . $user_phone .' />';
							echo '<input type="hidden" name="to_user_id" value=' . $theUserID .' />';
							echo '<input type="submit" class="btn btn-default" name="submit" value="submit"/>
									</form>
							</div>
					</div>
		';
?>
</div>

<!-- new dairy-->
<form action="postDiary.php" method="post" enctype="multipart/form-data"  <?php if($visit!==null && $visit!=$user_phone){echo 'hidden="hidden"';} ?>>
    <div class="col-sm-4">
		<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading" > 
						
						<h5>New Dairy</h5>	
						
				  </div>
				  <div class="panel-body">
					<table>
						<tr>
							<input type="text" class="form-control" name="title" placeholder="Put your title here">
						</tr>
						<br/ >
						<tr>
							<input type="text" class="form-control" name="content" placeholder="Put your content here">
						</tr>
						<br/>
						<tr>
							<div class="input-group">
								<span class="input-group-addon">Privacy Level</span>
								<input type="number" class="form-control" name="level" placeholder="0,1,2">
							</div>
						</tr>
						<br/ >
						<tr>
							<label for="file">Filename:</label>
							<input type="file" name="fileUpload" id="file"/>
						</tr>
						<br/ >
						<tr>
							<input type="hidden" name="user_id" value="<?php echo $user_phone; ?>">
							<input type="submit" class="btn btn-default" name="submit" value="submit"/>
						</tr>
					</table>
				  </div>
		</div>
	</div>
	
	
</form>

<?php
/* post dairy loop*/
$theUserID=$user_phone;
if($visit !==null){
	$theUserID=$visit;
}
if($user_phone==$theUserID){
	$query_result = pg_query($db, "SELECT TITLE,BODY,CREATE_TIMESTAMP,DIARY_ID FROM DIARY  WHERE USER_ID = " . $theUserID  . " ORDER BY CREATE_TIMESTAMP DESC");
}else{
	$sqlName="SELECT TITLE,BODY,CREATE_TIMESTAMP,DIARY_ID FROM DIARY  WHERE (USER_ID = " . $theUserID . " AND PUBLICITY_LEVEL=0) or (USER_ID = " . $theUserID . " AND PUBLICITY_LEVEL=1 AND (". $user_phone . " IN (SELECT list_friends($1)))) or (USER_ID = " . $theUserID . " AND PUBLICITY_LEVEL=2 AND (". $user_phone . " IN (SELECT list_fof($2)))) ORDER BY CREATE_TIMESTAMP DESC";
	$query_result = pg_prepare($db, "", $sqlName);
	$query_result = pg_execute($db, "", array($theUserID,$theUserID));
}

while($row = pg_fetch_array($query_result)){
    echo '<div class="col-sm-8">
				<div class="panel panel-default">
						  
						  <div class="panel-heading"> 
								
									<h5>' . $row['title'] . '</h5>
									
						  </div>
						  <div class="panel-body">
							<table>
								<tr>
									<td>' . $row['body'] . '</td>
								</tr>
								<tr>
									<td>' . 'Time:<h6 style="font-family:cursive"><em> ' . $row['create_timestamp'] . '</em></h6></td>
								</tr>
								<tr>
									<td> 
										<img src="http://localhost:8888/diary/' . $row['title'] . $theUserID . '.jpg" border="0" />
									</td>
								</tr>
							</table>';  
	
				
						/* comment loop*/ 
							$comment_result = pg_query($db, "SELECT BODY,CREATE_TIMESTAMP,USER_NAME FROM COMMENT_FOR_DIARY JOIN USERS ON COMMENT_FOR_DIARY.USER_ID=USERS.USER_ID WHERE DIARY_ID = " . $row['diary_id']);
						   
						while($comment_row = pg_fetch_array($comment_result)){
							echo ' 	
									<tr>
										<td>'. $comment_row['body'] . ' From <h6 style="font-family:cursive"><em>' . $comment_row['user_name'] . '</em></h6> Time: <h6 style="font-family:cursive"><em>' . $comment_row['create_timestamp'] . '</em></h6></td></br>
									</tr>  ';
			}
				$arr=$row['diary_id'];
				echo '</table>
				
							<form action="putComment.php" method="post">';
				echo '<table>
							<tr>
								<input type="text" name="comment" placeholder="Put your comment here">
							</tr>
							<tr>
								<input type="submit" class="btn btn-default" name="submit" value="submit"/></form>
							</tr>
					  </table>
						';
				echo '<input type="hidden" name="diary_id" value=' . $arr .'>
					  <input type="hidden" name="userPhone" value=' . $user_phone .'>
					  <input type="hidden" name="theUserID" value=' . $theUserID .'>
						</div>
					</div>
		</div>';
    
}


?>



	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
</body>
</html>