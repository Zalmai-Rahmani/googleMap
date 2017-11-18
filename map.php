<?php

require("db.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);



// Select all the rows in the markers table

$query = "SELECT * FROM procurement_plans WHERE component='Comp.A1'";
$result = mysqli_query($GLOBALS['DB'],$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  $id = $row['id'];
  $select_procurement_approval_echo  = "select * from procurement_approval where procurement_plans_stages_id = '$id'";
						$row_procurement_approval_echo = mysqli_query($GLOBALS['DB'],$select_procurement_approval_echo)or die(mysqli_error());	
                        $row_procurement_approval_echo = mysqli_fetch_assoc($row_procurement_approval_echo);	
                        $area_before = number_format($row_procurement_approval_echo['area_before']);
                        $area_after = number_format($row_procurement_approval_echo['area_after']);
                        $householde = number_format($row_procurement_approval_echo['householde']);
                        $length = number_format($row_procurement_approval_echo['length']);
						
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("code", $row['code']);
  $newnode->setAttribute("area_before", $area_before);
  $newnode->setAttribute("area_after", $area_after);
  $newnode->setAttribute("householde", $householde);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("status", $row['status']);
}

echo $dom->saveXML();

?>