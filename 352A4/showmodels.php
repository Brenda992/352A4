<?php
include('function.php');
no_SSL();



$query_str = "SELECT productCode, productName FROM products";
$res = $db->query($query_str);

function format_model_name_as_link($id,$name,$page) {
	echo "<a href=\"$page?productCode=$id\">$name</a>";
	}

include('header.php');

echo "<h2>All Models</h2>";

echo "<ul>";
while ($row = $res->fetch_assoc()) {
	echo "<li>";
	format_model_name_as_link($row["productCode"], $row["productName"],"modeldetails.php");
	echo "</li>\n";
};
echo "</ul>";

include('footer.php');
$res->free_result();
$db->close();
?>