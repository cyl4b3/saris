<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Search';
	$szTitle = 'Examination Result';
	include('lecturerheader.php');
	
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
if(isset($_POST['coursecode'])){
$regno=addslashes($_POST['regno']);
$ayear=addslashes($_POST['ayear']);
$test2=addslashes($_POST['test2']);
$exam=addslashes($_POST['exam']);
$sup=addslashes($_POST['sup']);
$special=addslashes($_POST['special']);
$tp=addslashes($_POST['tp']);
$pt=addslashes($_POST['pt']);
$pro=addslashes($_POST['pro']);
$key=addslashes($_POST['coursecode']);
$status=addslashes($_POST['status']);

#
#update coursework
	if (("$test2"!="$test2" && "$test2" <> "") || $test2>40){
	   echo $test2.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
		$chkdb = mysqli_query($zalongwa, $qchk);
		if (mysqli_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamScore = '$test2'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
			mysqli_select_db($zalongwa, $database_zalongwa);
			$Result1 = mysqli_query($zalongwa, $updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 4,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							ExamScore = '$test2'
						";
			mysqli_select_db($zalongwa, $database_zalongwa);
			$Result1 = mysqli_query($zalongwa, $updateSQL);
		}
	}
 #update Semester Exam
	if (("$exam"!="$exam" && "$exam" <> "") || $exam>100){
	   echo $exam.' Is Invalid Semester Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
		$chkdb = mysqli_query($zalongwa, $qchk);
		if (mysqli_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamScore = '$exam'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
			mysqli_select_db($zalongwa, $database_zalongwa);
			$Result1 = mysqli_query($zalongwa, $updateSQL); 
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 4,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							ExamScore = '$exam'
						";
			mysqli_select_db($zalongwa, $database_zalongwa);
			$Result1 = mysqli_query($zalongwa, $updateSQL);
		}
	}

		#update supplimentary
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$sup'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 6";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update"); 

		#update special
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$special'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 7";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");
			
		#update exam
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$exam'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");
		
		#update tp
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$exam'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 9";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");

		#update pt
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$exam'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 10";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");

		#update pro
		$updateSQL = "UPDATE examresult 
					SET 
						Recorder = '$username', 
						RecordDate = now(), 
						ExamScore = '$exam'
					WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 8";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");

		#update Status
		$updateSQL = "UPDATE examregister 
					SET 
						Status = '$status',
						Recorder = '$username',  
						RecordDate = now() 
					WHERE RegNo='$regno' AND CourseCode='$key'";
		mysqli_select_db($zalongwa, $database_zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");
		
		echo "Database Updated Successfuly!";
}

if (isset($_GET['Candidate'])) {
  $key=addslashes($_GET['Candidate']);
  $course=addslashes($_GET['Course']);
  $ayear=addslashes($_GET['AYear']);
  echo "Editing Examination Results for Candidate: ".$key;
	
							#query Coursework
							$qtest2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=4";
							$dbtest2=mysqli_query($zalongwa, $qtest2);
							$row_test2=mysqli_fetch_array($dbtest2);
							$test2date=$row_test2['ExamDate'];
							$test2score=$row_test2['ExamScore'];

							#query Annual Exam
							$qae = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=5";
							$dbae=mysqli_query($zalongwa, $qae);
							$row_ae=mysqli_fetch_array($dbae);
							$aedate=$row_ae['ExamDate'];
							$aescore=$row_ae['ExamScore'];
							
							#query Special Exam
							$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=7";
							$dbsp=mysqli_query($zalongwa, $qsp);
							$row_sp=mysqli_fetch_array($dbsp);
							$row_sp_total=mysqli_num_rows($dbsp);
							$spdate=$row_sp['ExamDate'];
							$spscore=$row_sp['ExamScore'];
							#query Exam
							
							#query Supplimentatary Exam
							$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=6";
							$dbsup=mysqli_query($zalongwa, $qsup);
							$row_sup=mysqli_fetch_array($dbsup);
							$row_sup_total=mysqli_num_rows($dbsup);
							$supdate=$row_sup['ExamDate'];
							$supscore=$row_sup['ExamScore'];

							#query Supplimentatary Exam
							$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=6";
							$dbsup=mysqli_query($zalongwa, $qsup);
							$row_sup=mysqli_fetch_array($dbsup);
							$row_sup_total=mysqli_num_rows($dbsup);
							$supdate=$row_sup['ExamDate'];
							$supscore=$row_sup['ExamScore'];
							
							#query Project Exam
							$qpro = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=8";
							$dbpro=mysqli_query($zalongwa, $qpro);
							$row_pro=mysqli_fetch_array($dbpro);
							$row_pro_total=mysqli_num_rows($dbpro);
							$prodate=$row_pro['ExamDate'];
							$proscore=$row_pro['ExamScore'];
							
							#query Traching Practice Exam
							$qtp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=9";
							$dbtp=mysqli_query($zalongwa, $qtp);
							$row_tp=mysqli_fetch_array($dbtp);
							$row_tp_total=mysqli_num_rows($dbtp);
							$tpdate=$row_tp['ExamDate'];
							$tpscore=$row_tp['ExamScore'];
							
							#query Practical Training Exam
							$qpt = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=10";
							$dbpt=mysqli_query($zalongwa, $qpt);
							$row_pt=mysqli_fetch_array($dbpt);
							$row_pt_total=mysqli_num_rows($dbpt);
							$ptdate=$row_pt['ExamDate'];
							$ptscore=$row_pt['ExamScore'];

				#query status
				$qstatus = "SELECT Status FROM examregister WHERE CourseCode='$course' AND RegNo='$key'";
				$dbstatus=mysqli_query($zalongwa, $qstatus);
				$row_status=mysqli_fetch_array($dbstatus);

				//display results in editable form
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="frmEdit">
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                  <tr>
                    <td>CourseCode</td>
					<td>Cwk</td>
                    <td>Exam</td>
					<td>Sup</td>
					<td>Spec</td>
					<td>TP</td>
					<td>PT</td>
					<td>Proj</td>
                    <td nowrap>Core/Elective</td>
					<td nowrap>DropCourse</td>
                  </tr>
                  <tr>
                    <td><?php echo $course?><input name="coursecode" type="hidden" value="<?php echo $course?>"></td>
					<td><div align="center">
                      <input name="test2" type="text" value="<?php echo $test2score?>" size="4" maxlength="4">
                      <input name="regno" type="hidden" value="<?php echo $key?>">
					  <input name="ayear" type="hidden" value="<?php echo $ayear?>">
					</div></td>
					<td><div align="center">
                      <input name="exam" type="text" value="<?php echo $aescore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="sup" type="text" value="<?php echo $supscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="special" type="text" value="<?php echo $spscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="tp" type="text" value="<?php echo $tpscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="pt" type="text" value="<?php echo $ptscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="pro" type="text" value="<?php echo $proscore?>" size="4" maxlength="4">
                    </div></td>
                    <td><select name="status" size="1">
					<?php
					#populate status combo box
					$sta=$row_status['Status'];
					$qoption="select Id,Description from courseoption where Id='$sta'";
					$dboption=mysqli_query($zalongwa, $qoption);
					$row_option=mysqli_fetch_array($dboption);
					?>
				   <option value="<?php echo $row_option['Id'] ?>"><?php echo $row_option['Description'] ?></option>
					  <option value="1" >Core </option>
					  <option value="2">Elective</option>
				   </select></td>
                <td><?php print "<a href=\"lecturersingleresultdelete.php?RegNo=$key&key=$course\">Drop</a>";?></td>
                  </tr>
                </table>
				<input name="update" type="submit" value="Update Record">
				</form>
				<?php
 }
?>