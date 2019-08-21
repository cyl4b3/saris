<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Administration';
	$szSubSection = 'Exam Register';
	$szTitle = 'Course/Subject Registration Report; <a href="lecturerExamregister.php">Register Student </a>';
	include('lecturerheader.php');
$editFormAction = $_SERVER['PHP_SELF'];

mysqli_select_db($zalongwa, $database_zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysqli_query($zalongwa, $query_studentlist) or die(mysql_error());
$row_studentlist = mysqli_fetch_assoc($studentlist);
$totalRows_studentlist = mysqli_num_rows($studentlist);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysqli_query($zalongwa, $query_degree) or die(mysqli_error($zalongwa));
$row_degree = mysqli_fetch_assoc($degree);
$totalRows_degree = mysqli_num_rows($degree);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysqli_query($zalongwa, $query_ayear) or die(mysqli_error($zalongwa));
$row_ayear = mysqli_fetch_assoc($ayear);
$totalRows_ayear = mysqli_num_rows($ayear);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysqli_query($zalongwa, $query_dept) or die(mysqli_error($zalongwa));
$row_dept = mysqli_fetch_assoc($dept);
$totalRows_dept = mysqli_num_rows($dept);
?>
<?php
			
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<h4 align="center">UNIVERSITY OF DAR ES SALAAM <br><br>
<?php 
$prog=$_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysqli_query($zalongwa, $qprog);
$row_prog = mysqli_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysqli_query($zalongwa, $qyear);
$row_year = mysqli_fetch_array($dbyear);
$year = $row_year['AYear'];
echo $progname;
echo " - ".$year;
echo "<br><br>Course Registration for Academic Year - ".$ayear;
?>
<br>
</h4>
<?php

//$reg = $_POST['regno'];
@$checkdegree = $_POST['checkdegree'];
@$checkyear = $_POST['checkyear'];
@$checkdept = $_POST['checkdept'];
$checkcohot = $_POST['checkcohot'];

$c=0;

if (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on') && ($checkyear == 'on')){
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			
			//query depts where the student has courses registered for
			$qdept = " SELECT DISTINCT examresult.CourseCode, Grade
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') AND
							  (course.Department = '$dept') AND
							  (examresult.AYear = '$year')
						    )";
			
			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
				  </tr>				
				
        			
</table>
<?php $i++;}

}elseif (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){

//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
		
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT CourseCode
						FROM examresult
						WHERE 
						   (
							  (examresult.RegNo = '$regno')
							  AND
							  (examresult.AYear = '$year')
						    )";
			
			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
				  </tr>				
				
        			
</table>
			<?php $i++;}
}elseif (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on')){
//query student list
$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
		
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT examresult.CourseCode, Grade
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') AND
							  (course.Department = '$dept') 
						    )";
			
			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
				  </tr>				
				
        			
</table>
			<?php $i++;}
}elseif (($checkdegree=='on') && ($checkcohot == 'on')){				
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			
			//query depts where the student has courses registered for
			$qdept = " SELECT DISTINCT examresult.CourseCode, Grade
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') 
						    )";
			
			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysql_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
				  </tr>				
				
        			
</table>
<?php $i++;}
}
}else{
?>

<form name="form1" method="post" action="<?php echo $editFormAction ?>">
            <div align="center">
			<table width="200" border="0">
                <tr>
                  <td colspan="3"><span class="style61">if you want to filter the results by  criteria <span class="style34">Tick the corresponding check box first</span> then select appropriately </span></td>
                </tr>
                <tr>
                  <td nowrap><input name="checkdegree" type="checkbox" id="checkdegree" value="on"></td>
                  <td nowrap><div align="left">Degree Programme:</div></td>
                  <td>
                      <div align="left">
                        <select name="degree" id="degree">
                          <?php
do {  
?>
                          <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
                          <?php
} while ($row_degree = mysqli_fetch_assoc($degree));
  $rows = mysqli_num_rows($degree);
  if($rows > 0) {
      mysqli_data_seek($degree, 0);
	  $row_degree = mysqli_fetch_assoc($degree);
  }
?>
                        </select>
                    </div></td></tr>
                <tr>
                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on"></td>
                  <td nowrap><div align="left">Cohot of the  Year: </div></td>
                  <td><div align="left">
                    <select name="cohot" id="cohot">
                        <?php
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
                  </div></td>
                </tr>
            	<tr>
                  <td><input name="checkyear" type="checkbox" id="checkyear" value="on"></td>
                  <td nowrap><div align="left">Results of the  Year: </div></td>
                  <td><div align="left">
                    <select name="ayear" id="ayear">
                        <?php
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
                  </div></td>
                </tr>
                <tr>
                  <td><input name="checkdept" type="checkbox" id="checkdept" value="on"></td>
                  <td nowrap><div align="left">From Department: </div></td>
                  <td><div align="left">
                    <select name="dept" id="dept">
                        <?php
do {  
?>
                        <option value="<?php echo $row_dept['DeptName']?>"><?php echo $row_dept['DeptName']?></option>
                        <?php
} while ($row_dept = mysqli_fetch_assoc($dept));
  $rows = mysqli_num_rows($dept);
  if($rows > 0) {
      mysqli_data_seek($dept, 0);
	  $row_dept = mysqli_fetch_assoc($dept);
  }
?>
                    </select>
                  </div></td>
                </tr>
                <tr>
                  <td colspan="3"><div align="center"></div></td>
                </tr>
              </table>

              <input name="action" type="submit" id="action" value="Print Results"> 
              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
  </div>
</form>
<?php
}
include('../footer/footer.php');
?>