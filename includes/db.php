<?php
$conn = pg_connect("host=localhost dbname=m2nges_site user=postgres password=1")
   or die("Connection error: " . pg_last_error());
?>
