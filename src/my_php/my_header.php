
<html>
<head>
<title><?php

    if(isset($title) && !empty($title))
    {
        echo $title; 
    }
    else
    { 
        echo "Camagru"; 
	} ?></title>
	<?php if (isset($_SESSION['user_id'])) {
		if (isset($_SESSION['theme']))
		{
			if ($_SESSION['theme'] == 'Default')
				echo '<link rel="stylesheet" type="text/css" href="../resources/css/default.css" id="css2"/>';
			else if ($_SESSION['theme'] == 'beige')
				echo '<link rel="stylesheet" type="text/css" href="../resources/css/beige.css" id="css4"/>';
			else if ($_SESSION['theme'] == 'Blue')
				echo '<link rel="stylesheet" type="text/css" href="../resources/css/blue.css" id="css5"/>';
		}
		?>
	<link rel="stylesheet" type="text/css" href="<?php echo "../resources/css/style.css";?>" id="css1"/>
	<?php }
	else {
		?>
	<link rel="stylesheet" type="text/css" href="<?php echo "../resources/css/style.css";?>" id="css1"/>
	<link rel="stylesheet" type="text/css" href="<?php echo "../resources/css/default.css";?>" id="css2"/>
	<?php
	}
	?>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.0/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
</head>
<body>
<?php
if (isset($_SESSION['user_id']))
{
	$pdo = myPDO::getInstance();
	$query = "
		SELECT user_id, firstname, lastname, username FROM users
		WHERE user_id=:user_id
		";
	$sql = $pdo->prepare($query);
	$sql->execute(
			array(
				':user_id' => $_SESSION['user_id']
				)
			);
	$count = $sql->rowCount();
	if ($count > 0)
	{
	  $result = $sql->fetchAll();
	  foreach($result as $row)
		$login = $row['username'];
	}
?>
	<header class="navbar-inverse navbar-fixed-top">
  		<div class="container-fluid">
    		<div class="navbar-header">
				<a class="navbar-brand" href="gallery.php"><img src="../resources/images/imag.png" alt="Gallery" width="150" heigth="150"></a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="home_page.php"><i class="fa fa-home" style="color:white"><?php echo $login?></i></a></li>
				<li><a href="my_gallery.php"><i class="fa fa-images" style="color:white"></i></a></li>
				<li><a href="settings.php"><i class="fa fa-cog" style="color:white"></i></a></li>    
				<li><a href="logout_form.php"><i class="fa fa-sign-out-alt" style="color:white"></i></a></li>
		  	</ul>
  		</div>
	</header>
<?php
}
else
{ ?>
	<header class="navbar-inverse navbar-fixed-top">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href='gallery.php'><img src="../resources/images/imag.png" alt="Camagru" width="150" height="150"></a>
    		</div>
		<ul class="nav navbar-nav">
	  		<li><a href="login_form.php" style="color:white">Log in</a></li>
			<li><a href="registration.php" style="color:white">Register</a></li>
    	</ul>
  		</div>
	</header>
<?php
}