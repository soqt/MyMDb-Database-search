<?php
/*
Yumeng Wang
CSE 154
Home work 5
This is a page contains repeated code in other pages.
*/


//This is a function of page's header
function heading() { ?>
<!DOCTYPE html>
<html>
	<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div id="frame">
			<div id="banner">
				<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
				My Movie Database
			</div>
		<div id="main">
<?php 
}
//This is bottom part of pages, containning two forms and footer.
function footer() { ?>
<form action="search-all.php" method="get">
	<fieldset>
		<legend>All movies</legend>
		<div>
			<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
			<input name="lastname" type="text" size="12" placeholder="last name" /> 
			<input type="submit" value="go" />
		</div>
	</fieldset>
</form>
<!-- form to search for movies where a given actor was with Kevin Bacon -->
<form action="search-kevin.php" method="get">
	<fieldset>
		<legend>Movies with Kevin Bacon</legend>
		<div>
			<input name="firstname" type="text" size="12" placeholder="first name" /> 
			<input name="lastname" type="text" size="12" placeholder="last name" /> 
			<input type="submit" value="go" />
		</div>
	</fieldset>
</form>
</div> <!-- end of #main div -->
<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div> <!-- end of #frame div -->
	</body>
</html>
<?php 
} 

//This is a function to call database by using PDO
function database() {
	$db = new PDO("mysql:dbname=imdb", "yw47", "OQiv22xDp7");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

//This is a query getting the ID of any actor.
function id($db, $last_name, $first_name) {
	$firstname = $db->quote($first_name.'%');
	$lastname = $db->quote($last_name);
	$id = $db->query("SELECT id 
					FROM actors 
					WHERE last_name = $lastname AND first_name LIKE $firstname 
					ORDER BY film_count DESC, id 
					LIMIT 1");
	$id_number = $id->fetch()["id"];
	return $id_number;
}

//This is a function to make a table
function table($rows, $caption) { ?>
	<table>
		<caption><?= $caption ?></caption>
		<tr><th>#</th><th>Title</th><th>Year</th></tr>
	<?php
	$count = 1; 
	foreach ($rows as $row ) { ?>
		<tr><td><?= $count ?></td><td><?= htmlspecialchars($row["name"]) ?></td><td> <?= htmlspecialchars($row["year"]) ?></td></tr>
	<?php 
		$count++;
	} ?>
	</table>
<?php
} 

//extra feature, if user didn't type in either firstname or lastname, abort the page
//and output message.
function parameter_check(){
	if (!$_GET["firstname"] || !$_GET["lastname"]) {
		die("please type both first name and last name of actor");
	}
} ?>
