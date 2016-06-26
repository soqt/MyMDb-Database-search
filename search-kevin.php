<?php
/*
Yumeng Wang
CSE 154
Home work 5
This is the search-kevin.php page, using SQL to search out same movies
acted by both Kevin Bacon and typed actor.
*/
	include("common.php");
	parameter_check();

	$first_name = strtolower($_GET["firstname"]);
	$last_name = strtolower($_GET["lastname"]);

	heading();
	$db = database();

	$actor_id = id($db, $last_name, $first_name);

	if (!$actor_id) { ?>
		<p> Actor <?= $first_name ?> <?= $last_name ?> not found</p>
	<?php } else { ?>
		<h1>Results for <?=$first_name ?> <?=$last_name ?></h1>
	<?php
		
		$actor_id  = $db->quote($actor_id );
		$kevin_id = id($db, "Bacon", "kevin");
		$kevin_id = $db->quote($kevin_id);

		$rows = $db->query("SELECT name, year 
							FROM movies m 
							JOIN roles r1 ON r1.movie_id = m.id
							JOIN actors a1 ON r1.actor_id = a1.id 
							JOIN roles r2 ON r2.movie_id = m.id 
							JOIN actors a2 ON r2.actor_id = a2.id
							WHERE a1.id = $actor_id  AND a2.id = $kevin_id
							ORDER BY m.year DESC, m.name");
		if ($rows->rowCount() == 0) { ?>
			<p><?= $first_name ?> <?= $last_name ?> wasn't in any films with Kevin Bacon</p>
		<?php }else {
			$caption = "Films with {$first_name} {$last_name} and Kevin Bacon";
			table($rows, $caption);
		}
	}
	footer(); 
?>	

