<?php
session_start();
session_unset();
srand();
$challenge = "";
for ($i = 0; $i < 80; $i++) {
    $challenge .= dechex(rand(0, 15));
}
$_SESSION[challenge] = $challenge;

if (!empty($_GET['logoff'])) { header("location:../index.php"); }

$error = $_GET['error'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Login</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/roar.css" type="text/css" media="all" />
<link rel="shortcut icon" href="images/favicon.ico" />
</head>
<body>
	<div class="header">
		<div class='headerform'>
			<div>username: <input class="field" type="text" width="20" name="username" id="username" /></div>
			<div>password: <input class="field" type="password" width="20" name="password" id="password" /></div>
			<div><input id='submit-button' type="image" src="images/ok.png" border="0" /></div>
			<input type="hidden" id="challenge"  value="<?php echo $challenge; ?>"/>
		</div>
	</div>
	<div class="hline"></div>
	<form id="login-form" action="lib/php/authenticate.php" method="post">
        <div>
            <input type="hidden" name="username" id='user'/>
        	<input type="hidden" name="response" id='response'/>
		</div>
	</form>
	<script type="text/javascript" src="lib/mootools/mootools-1.2.1-core-jm.js"></script>
	<script type="text/javascript" src="js/roar.js"></script>
	<script type="text/javascript" src="js/md5.js"></script>
	<script language="JavaScript">
	window.addEvent('load', function() {
	 
		var roar = new Roar({
			position: 'upperLeft',
			duration: 3000
		});
	 
		<?php if ($error) {?>
		roar.alert('<?php echo $error; ?>', 'try again!');
		<?php } ?>

		var validate = function(){
				var username = $('username').get('value'),
				password = $('password').get('value');
			if (username == '') {
	            roar.alert("Please enter your user name.", 'try again!');
			} else if (password == '') {
	            roar.alert("Please enter your password.", 'try again!');
			} else {
				$('user').set('value', username); 
				$('response').set('value', hex_md5($('challenge').get('value') + password)); 
				$('login-form').submit();
			}
		};

		$('submit-button').addEvent('click', validate);
		window.addEvent('keydown', function(e){ if (e.key=='enter') validate(); });
	});
	</script>
</BODY>
</HTML>
