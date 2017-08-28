<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="<?= base_url(); ?>public/css/vendor.min.css">
		<link rel="stylesheet" href="<?= base_url(); ?>public/css/app.min.css">
		<title>Planeador</title>
	</head>
	<body>
		<div id="app" ng-app="app">
			<div ng-include="'public/views/navbar/navbar.html'"></div>
			<ui-view></ui-view>
		</div>

		<script src="<?= base_url(); ?>public/js/vendor.min.js"></script>
		<script src="<?= base_url(); ?>public/js/app.min.js"></script>
	</body>
</html> 
