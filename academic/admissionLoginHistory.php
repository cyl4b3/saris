<?php 
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# include the header

	include("security.php");

//include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Security';
	$szTitle = 'Security';
	$szSubSection = 'Security';
	//$additionalStyleSheet = './general.css';
//	include("lecturerheader.php");
//page content starts here

@$username = $_SESSION['username'];
$sql = "SELECT stats.ip,
       stats.page,
       stats.received,
       stats.page
FROM stats WHERE stats.page LIKE '$username%'  ORDER BY stats.received DESC LIMIT 10";

//(((roomapplication.Hall)='$hall') And
$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

$all_query = mysqli_query($zalongwa, $query);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) > 0){
echo "Frequencies of User \"$username\" in Visiting the Website";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Computer Used</td><td> Webpage </td><td> Date of Visit </td></tr>";
$i=1;
while($result = mysqli_fetch_array($query)) {
		$ip = stripslashes($result["ip"]);
		$browser = stripslashes($result["page"]);
		$received = stripslashes($result["received"]);
		
			echo "<tr><td>$i</td>";
			echo "<td>$ip</td>";
			echo "<td>$browser</td>";
			echo "<td>$received</td></tr>";
		$i=$i+1;
		}
echo "</table>";
}else{
echo "User \"$username\" has never visited the Website <br>";
}
mysqli_close($zalongwa);
?>
<?php

	# include the footer
	include("../footer/footer.php");
?>