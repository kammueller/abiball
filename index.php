<?php
	if (is_file("0.php")) {
		header ("location: 0.php");
	} elseif (is_file ("2.php")) {
		header ("location: 2.php");
	}
?>