<?php 
	require_once('../Connections/zalongwa.php');
	require_once('../Connections/sessioncontrol.php');

	include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Programme Information';
	$szSubSection = 'Programme';
	include("lecturerheader.php");
	
	
	
?>

<div style="height:30px; color:blue; width:900px;"><?php
     
$key = $_GET['edit'];
$keyayear = $_GET['ayear'];

if(isset($_POST['save_record'])){
  $get_data = "SELECT * FROM courseprogramme WHERE ProgrammeID='$key' AND AYear='$keyayear'";
  $result_data = mysqli_query($zalongwa,$get_data);
  $num_rows = mysqli_num_rows($result_data);
  if($num_rows > 0){
  	while ($rows = mysqli_fetch_array($result_data)) {
  		$prg = $rows['ProgrammeID'];
  		$code = $rows['CourseCode'];
  		$status = $rows['Status'];
  		$class = $rows['YearofStudy'];
  		$sem = $rows['Semester'];
  		$yr = $_POST['rayear'];
  		$insert = "INSERT INTO courseprogramme (ProgrammeID,CourseCode,Status,YearofStudy,Semester,AYear) VALUES('$prg','$code','$status','$class','$sem','$yr')";
  		$insert_data = mysqli_query($zalongwa,$insert);
  	}
  	echo "<div>Configuration is successfully copied!!!</div>";
  }
		
	}



mysqli_select_db($zalongwa,$database_zalongwa);
$prog_sql = "SELECT * FROM programme WHERE ProgrammeCode ='$key'";
$prog_result = mysqli_query($zalongwa,$prog_sql);
$fetc_prog = mysqli_fetch_assoc($prog_result);

echo 'Course Configuration - '.$fetc_prog['ProgrammeName'].' : '.$fetc_prog['Title'];
?></div>
<p></p>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>?edit=<?php echo $key ?>&ayear=<?php echo $keyayear; ?>" method="post">

<table style="width:500px; border:2px solid #98BDCF; background-color:#F7F8FB;"  cellpadding="0" cellspacing="0">
<tr><td colspan="2" style="padding:10px;" align="center"><p>Select Year to Paste the Configuration</p></td></tr>
 <tr>
 <td align="right">Select Year : </td>
 <td align="left">
 <select name="rayear">
 <?php 
 mysqli_select_db($zalongwa,$database_zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysqli_query($zalongwa,$query_ayear);
$row_ayear = mysqli_fetch_assoc($ayear);
 do {  
			?>
                    <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
                    <?php
				} while ($row_ayear = mysqli_fetch_assoc($ayear));
				  $rows = mysqli_num_rows($ayear);
				  if($rows > 0) {
			      mysqli_data_seek($ayear, 0);
				  $row_ayear = mysqli_fetch_assoc($ayear);
			  }
 
 ?>
 </select>
 </td>
 
 
 </tr>

<tr> 
<td colspan="2" align="center" style="padding:10px;">
<input type="submit" name="save_record" onclick="confirmdata()" value="Copy Config"/>
</td>
</tr>

</table>
</form>

<script type="text/javascript">
function confirmdata(){
var r=confirm("Are you sure you want to copy configuration !!");
if (r==true)
  {
return true;
  }
else
  {
  return false;
  }
}
</script>