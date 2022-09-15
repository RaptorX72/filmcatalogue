<footer>
<?php
	$authors = array("Schneider Sigfrid", "Szekeres Laura", "Tóth Bagi Bence", "Mackovic Daniel", "Róka Tamás");
	$str = "<!--© 2019 ";
	for ($i = 0; $i < count($authors); $i++) {
		$str .= $authors[$i];
		if ($i != count($authors) - 1) $str .= ", ";
	}
	$str .= "-->";
	echo $str;
?>
</footer>
</body>
</html>