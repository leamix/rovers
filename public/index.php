<html>
<head>
	<title>Moonbase Rovers console</title>
	<link rel="stylesheet" href="./css/main.css" />
	<script src="./bower/jquery/dist/jquery.min.js"></script>
</head>
<body>
<section class="rv-display" id="display">
	<div class="rv-map" id="map"></div>
</section>
<section class="rv-panel" id="panel">
	<div class="rv-output-console" id="output"></div>
	<div class="rv-log" id="log"></div>
	<form action="./marsbase.php" method="post" id="input-form">
		<label for="command"></label>
		<textarea name="command" id="command" cols="20" rows="5" class="rv-input-console">5 5
1 2 N
LMLMLMLMM
3 3 E
MMRMMRMRRM</textarea>
		<input type="submit" class="rv-send-btn" id="send-btn" value="Submit">
	</form>
</section>
<script src="./js/main.js"></script>
</body>
</html>