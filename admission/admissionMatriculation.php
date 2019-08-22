<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Application Process';
	$szSubSection = 'Matriculation';
	$szTitle = 'Matriculation';
	include('admissionheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


//Print Room Allocation Report
if (isset($_POST['search']) && ($_POST['search'] == "Search")) {
#get post variables
$key = $_POST['key'];
			
require_once('../Connections/zalongwa.php'); 
$sql = "SELECT student.Id, student.Name, student.Sex, student.ProgrammeofStudy, student.Faculty, student.Sponsor, student.EntryYear, student.RegNo, hostel.HName, allocation.RNumber, allocation.AYear, hostel.HID
FROM (allocation RIGHT JOIN student ON allocation.RegNo = student.RegNo) LEFT JOIN hostel ON allocation.HID = hostel.HID
WHERE (student.Name LIKE '%$key%') OR (student.RegNo LIKE '%$key%') ORDER BY student.Name, allocation.AYear  DESC";

$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error());
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error());

$all_query = mysqli_query($zalongwa, $query);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) > 0){
echo "<p>Total Records Found: $totalRows_query </p>";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Sex </td><td> Degree </td><td> Faculty </td><td> Sponsor </td><td> Registered </td><td> Hostel </td><td> Room No.: </td><td> Academic Year </td></tr>";
$i=1;
while($result = mysqli_fetch_array($query)) {
		$id = stripslashes($result["Id"]);
		$year = stripslashes($result["AYear"]);
		$Name = stripslashes($result["Name"]);
		$RegNo = stripslashes($result["RegNo"]);
		$sex = stripslashes($result["Sex"]);
		$degree = stripslashes($result["ProgrammeofStudy"]);
		$faculty = stripslashes($result["Faculty"]);
		$sponsor = stripslashes($result["Sponsor"]);
		$entryyear = stripslashes($result["EntryYear"]);
		$hall = stripslashes($result["HName"]);
		$citeria = stripslashes($result["RNumber"]);
			echo "<tr><td><a href=\"admissionRegistrationForm.php?id=$id&RegNo=$RegNo\">$i</a></td>";
			echo "<td>$Name</td>";
			echo "<td>$RegNo</td>";
			echo "<td>$sex</td>";
			echo "<td>$degree</td>";
			echo "<td>$faculty</td>";
			echo "<td>$sponsor</td>";
			echo "<td>$entryyear</td>";
			echo "<td>$hall</td>";
			echo "<td>$citeria</td>";
			echo "<td>$year</td></tr>";
		$i=$i+1;
		}
echo "</table>";
}else{
$key= stripslashes($key);
echo "Sorry, No Records Found <br>";
echo "That Match With Your Searck Key \"$key \" ";
}
mysqli_close($zalongwa);

}else{

?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="284" border="0">
        <tr>
          <td colspan="2" nowrap><div align="center"></div>
          </td>
        </tr>
        <tr>
          <td width="111" nowrap><div align="right"><span class="style67">Name or RegNo:</span></div></td>
          <td width="157" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          <input name="key" type="text" id="key" size="40" maxlength="40">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right">Click Search: </div></td>
          <td bgcolor="#CCCCCC"><input type="submit" name="search" value="Search"></td>
        </tr>
      </table>
                    </form>
<?php
}
include('../footer/footer.php');
?>
