<?php
	if(!$_GET['url'])
	{
		echo "null param";
		exit;
	}
	if(!strpos($_SERVER["HTTP_USER_AGENT"], "Trident") == true)
	{
		header("Location: ./HDD/Ani/".rawurlencode($_GET['url']));
		exit;
	}
?>

<html>
	<head>
	</head>
	<body style = "padding: 0; margin: 0;">
		<video width="100%" height="100%" controls autoplay>
			<source src="<?php echo './HDD/Ani/'.$_GET['url'] ?>" type="video/mp4" />				
		</video>
	</body>
</html>