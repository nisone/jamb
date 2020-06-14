<?php
	require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jamb e-Test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page	via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
		body  {
			background-color: #AAA;
			font-family: Corbel, Constantia, Arial, sans-serif;
		}

		#footer div {
			text-align: center;
			background-color: #999;
			color: white;
		}

		#content {
			min-height: 400px;
			background-color: white;
			clear: both;
		}

		#header {
			background-color: #008811;
			color: white;
		}

		#rightContent ul {
			list-style: none;
		}

		#leftContent {
			padding: 10px 10px 10px 15px;
		}

		#timer, #timerPanel {
			text-align: center;
			background-color: #EEE;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row" id="header">
			<div class="col-md-10 col-md-offset-1">
				<h1>Welcome to JAMB e-Test</h1>
			</div>
		</div>
		<div class="row" id="content">
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
			<script src="assets/js/jquery-2.1.4.min.js"></script>
			<!-- Include all compiled plugins (below), or include individual files as needed -->
			<script src="assets/js/bootstrap.min.js"></script>