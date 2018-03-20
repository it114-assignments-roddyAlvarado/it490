<!DOCTYPE html>
<html>
<head>
	<title>Hop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/profile.css" type="text/css">
</head>
<body>
	<nav class="navbar navbar-dark bg-success justify-content-between">
		<div class="container">
			<h2 class="title">HOPS</h2>
			<form class="form-inline" method="post" action="search.php">
				<input class="form-control mr-sm-2" type="search" placeholder="Find Beers or Breweries" aria-label="Search" name='search'>
				<input class="btn btn-default my-2 my-sm-2" type="submit" value="Search">
		  	</form>
		  </div>
	</nav>

	<?php foreach ($response as $information) : ?>
		<h2><?php echo $information['name']; ?></h2>
		<h2>Category: </h2>
		<p><?php echo $information['category']; ?></p>
		<h2>Description: </h2>
		<p><?php echo $information['description']; ?></p>
		<p>abv: <?php echo $information['abv']; ?></p>
		<p>Available: <?php echo $information['available']; ?></p>

	<?php endforeach; ?>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html>
