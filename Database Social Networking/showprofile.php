<?php
include 'SharedInformation.php';
$visit=$_GET['id'];
$sqlName = "SELECT user_name FROM USERS WHERE USER_ID = $1";
$resource = pg_prepare($db, "", $sqlName);
$resource = pg_execute($db, "", array($visit));
$array = pg_fetch_array($resource);
$userName = $array["user_name"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>show profile</title>
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
				  <a class="navbar-brand" href="http://localhost:8888/new_mainPage.php?id=<?php echo $visit; ?>"> <?php echo $userName; ?></a>
				</div>

				
				
			  </div><!-- /.container-fluid -->
			  

		</nav>

</body>

<?php
include 'SharedInformation.php';

$query_result = pg_query($db, "SELECT FIRST_NAME,LAST_NAME,AGE,APT,STREET,CITY,STATE,ZIP,SELF_INTRODUCTION FROM PROFILE  WHERE USER_ID = " . $visit);
echo '
			<div class="panel panel-default">
						  
						  <div class="panel-heading"> 
								
									<h5>Profile:</h5>
									
							</div>
							<div class="panel-body">
								<table>';
while($comment_row = pg_fetch_array($query_result)){
	echo '<tr>'. 'NAME: '.$comment_row['first_name'] . ' ' . $comment_row['last_name'] . '    AGE: ' .$comment_row['age']. '</tr><br/>';
	echo '<tr>'. 'APT: ' .$comment_row['apt'] . '    STREET: ' . $comment_row['street']  . '    CITY: ' . $comment_row['city']  . '    STATE: ' . $comment_row['state']  . '    ZIP: ' . $comment_row['zip'] . '</tr><br/>';
	echo '<tr>'. 'SELF INTRODUCTION: ' . $comment_row['self_introduction'] .' </tr><br/>';
}
echo '</table>
							</div>
					</div>
		';
?>

</html>
