<?php
include('function.php');
no_SSL();


// Define a query string to select product codes and names from the products table
$query_str = "SELECT productCode, productName FROM products";
$res = $db->query($query_str);

// Function to create a clickable link for each product model
function format_model_name_as_link($id,$name,$page) {
	echo "<a href=\"$page?productCode=$id\">$name</a>";
	}

include('header.php');

echo "<h2>All Models</h2>";

echo "<ul>";
// Iterate through each row in the query result
while ($row = $res->fetch_assoc()) {
	echo "<li>";
	// Format each product model as a link
	format_model_name_as_link($row["productCode"], $row["productName"],"modeldetails.php");
	echo "</li>\n";
};
echo "</ul>";

include('footer.php');
$res->free_result();
$db->close();
?>