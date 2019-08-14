<?php
	#start html
	if (isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF")){
		
		#get connected to the database and verfy current session
		require_once('../Connections/sessioncontrol.php');
		require_once('../Connections/zalongwa.php');
		
		//include '../academic/includes/print_html_annual_results.php';
		#Get Organisation Name
		$qorg = "SELECT * FROM organisation";
		$dborg = mysql_query($qorg);
		$row_org = mysql_fetch_assoc($dborg);
		$org = $row_org['Name'];

		@$checkdegree = addslashes($_POST['checkdegree']);
		@$checkyear = addslashes($_POST['checkyear']);
		@$checkcohot = addslashes($_POST['checkcohot']);
		
		$prog=$_POST['degree'];
		$cohotyear = $_POST['cohot'];
		$ayear = $_POST['ayear'];
		
		//see if all the checkboxes are checked
		if (($checkdegree<>'on') || ($checkyear <> 'on') || ($checkcohot <> 'on')){
			echo "<script language='javascript'>
					window.alert('Please tick all the CheckBoxes before making selections')
				 </script>";
			echo '<meta http-equiv="refresh" content="0; url=lecturerAnnualresultsheet.php">';
			exit;
			}
			
		//check if the results year is before intake year
		if ($cohotyear > $ayear){
			echo "<script language='javascript'>
					window.alert('Please make good selections of the Cohort and Results Year')
				 </script>";
			echo '<meta http-equiv="refresh" content="0; url=lecturerAnnualresultsheet.php">';
			exit;
			}
			
		$qprog= "SELECT * FROM programme WHERE ProgrammeCode='$prog'";
		$dbprog = mysql_query($qprog);
		$row_prog = mysql_fetch_array($dbprog);
		$progname = stripslashes($row_prog['Title']);
		$proglevel = $row_prog['Ntalevel'];
		$faculty = strtoupper($row_prog['Faculty']);
		
		if(strstr($faculty, "Faculty")){
			}
		else{
			$faculty = "DEPARTMENT OF ".$faculty;
			}
		//calculate year of study
		$entry = intval(substr($cohotyear,0,4));
		$current = intval(substr($ayear,0,4));
		$yearofstudy=$current-$entry;
		
		if($yearofstudy==0){
			$class="FIRST YEAR";
			}elseif($yearofstudy==1){
			$class="SECOND YEAR";
			}elseif($yearofstudy==2){
			$class="THIRD YEAR";
			}elseif($yearofstudy==3){
			$class="FOURTH YEAR";
			}elseif($yearofstudy==4){
			$class="FIFTH YEAR";
			}elseif($yearofstudy==5){
			$class="SIXTH YEAR";
			}elseif($yearofstudy==6){
			$class="SEVENTH YEAR";
			}
			else{
			$class="";
			}
		$yearofstudy += 1;
		global $ctrlstudent;
		$coursearray = array();
		
		if (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){
			$deg=addslashes($_POST['degree']);
			$year = addslashes($_POST['ayear']);
			$cohot = addslashes($_POST['cohot']);
			
			#determine total number of columns
			$qstd = "SELECT RegNo FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
			$dbstd = mysql_query($qstd);
			$stud_num=mysql_num_rows($dbstd);
			$totalcolms = 0;
			$whereclause=" ";
			$stud=1;
			
			while($rowstd = mysql_fetch_array($dbstd)) {
				$stdregno = $rowstd['RegNo'];
				$whereclause.=($stud<$stud_num)?"RegNo='$stdregno' OR ":"RegNo='$stdregno'";
				
				$dbstdcourse = mysql_query("SELECT DISTINCT coursecode FROM examresult 
											WHERE RegNo='$stdregno' and AYear='$year' 
											ORDER BY CourseCode");
				$totalstdcourse = mysql_num_rows($dbstdcourse);
				
				if ($totalstdcourse>$totalcolms){
					$totalcolms = $totalstdcourse;
					$ctrlstudent = $stdregno;
					}	
				$stud++;
				}
			
			$whereclause=trim($whereclause);
			
			$coursearray1 = array();
			$coursearray2 = array();
			for($x=1; $x<=2; $x++){
				$qcourse = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
							AND (YearofStudy='$yearofstudy') AND (Semester = '$x')  AND (AYear='$year') 
							ORDER BY CourseCode";
				$dbstdcourse = mysql_query($qcourse);
							
				while(list($uniqcoz,$coursestat) = mysql_fetch_array($dbstdcourse)){
					//capture distinct coursecodes
					if($x==1){
						$coursearray1[] = $uniqcoz;
						}
					else{
						$coursearray2[] = $uniqcoz;
						}
					}
				}
			
			//check if there are results found
			if($totalcolms < 1){			
				$error = urlencode("There are no results for <b>$class $progname</b> in <b>$year</b>");
				$location = "lecturerAnnualresultsheet.php?error=$error";
				echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
				exit;
				}
			
			if(count($coursearray1) > count($coursearray2)){
				$coursearray = $coursearray1;
				}
			else{
				$coursearray = $coursearray2;
				}
				
			//include pdf creator
			include 'includes/print_pdf_annual_report.php';
			undergraduateReport($progname,$class,$faculty,$deg,$cohot,$year,$coursearray);
			}
		exit;
		}
		
		
	#start excel
	if (isset($_POST['Excel']) && ($_POST['Excel'] == "Print Excel")){
		#get connected to the database and verfy current session
		require_once('../Connections/sessioncontrol.php');
		require_once('../Connections/zalongwa.php');

		#Get Organisation Name
		$qorg = "SELECT * FROM organisation";
		$dborg = mysql_query($qorg);
		$row_org = mysql_fetch_assoc($dborg);
		$org = $row_org['Name'];

		@$checkdegree = addslashes($_POST['checkdegree']);
		@$checkyear = addslashes($_POST['checkyear']);
		@$checkdept = addslashes($_POST['checkdept']);
		@$checkcohot = addslashes($_POST['checkcohot']);
		
		$prog=$_POST['degree'];
		$cohotyear = $_POST['cohot'];
		$ayear = $_POST['ayear'];
		
		//see if all the checkboxes are checked
		if (($checkdegree<>'on') || ($checkyear <> 'on') || ($checkcohot <> 'on')){
			echo "<script language='javascript'>
					window.alert('Please tick all the CheckBoxes before making selections')
				 </script>";
			echo '<meta http-equiv="refresh" content="0; url=lecturerAnnualresultsheet.php">';
			exit;
			}
			
		//check if the results year is before intake year
		if ($cohotyear > $ayear){
			echo "<script language='javascript'>
					window.alert('Please make good selections of the Cohort and Results Year')
				 </script>";
			echo '<meta http-equiv="refresh" content="0; url=lecturerAnnualresultsheet.php">';
			exit;
			}
			
		$qprog= "SELECT * FROM programme WHERE ProgrammeCode='$prog'";
		$dbprog = mysql_query($qprog);
		$row_prog = mysql_fetch_array($dbprog);
		$progname = stripslashes($row_prog['Title']);
		$proglevel = $row_prog['Ntalevel'];
		$faculty = strtoupper($row_prog['Faculty']);
		
		if(strstr($faculty, "Faculty")){
			}
		else{
			$faculty = "DEPARTMENT OF ".$faculty;
			}
		//calculate year of study
		$entry = intval(substr($cohotyear,0,4));
		$current = intval(substr($ayear,0,4));
		$yearofstudy=$current-$entry;
		
		if($yearofstudy==0){
			$class="FIRST YEAR";
			}elseif($yearofstudy==1){
			$class="SECOND YEAR";
			}elseif($yearofstudy==2){
			$class="THIRD YEAR";
			}elseif($yearofstudy==3){
			$class="FOURTH YEAR";
			}elseif($yearofstudy==4){
			$class="FIFTH YEAR";
			}elseif($yearofstudy==5){
			$class="SIXTH YEAR";
			}elseif($yearofstudy==6){
			$class="SEVENTH YEAR";
			}
			else{
			$class="";
			}
		$yearofstudy += 1;
		global $ctrlstudent;
		$coursearray = array();
		
		if (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){
			$deg=addslashes($_POST['degree']);
			$year = addslashes($_POST['ayear']);
			$cohot = addslashes($_POST['cohot']);
			//$dept = addslashes($_POST['dept']);
			//$sem = addslashes($_POST['sem']);
			$semval = ($sem=='Semester I')? 1:2;
			
			#determine total number of columns
			$qstd = "SELECT RegNo FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
			$dbstd = mysql_query($qstd);
			$stud_num=mysql_num_rows($dbstd);
			$totalcolms = 0;
			$whereclause=" ";
			$stud=1;
			
			while($rowstd = mysql_fetch_array($dbstd)) {
				$stdregno = $rowstd['RegNo'];
				$whereclause.=($stud<$stud_num)?"RegNo='$stdregno' OR ":"RegNo='$stdregno'";
				
				$qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE RegNo='$stdregno' and AYear='$year' ORDER BY CourseCode";
				$dbstdcourse = mysql_query($qstdcourse);
				$totalstdcourse = mysql_num_rows($dbstdcourse);
				
				if ($totalstdcourse>$totalcolms){
					$totalcolms = $totalstdcourse;
					$ctrlstudent = $stdregno;
					}	
				$stud++;
				}
			
			$whereclause=trim($whereclause);
			
			$qcourse = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
						AND (YearofStudy='$yearofstudy') AND (AYear='$year') 
						ORDER BY CourseCode";
			$dbstdcourse = mysql_query($qcourse);
						
			while(list($uniqcoz,$coursestat) = mysql_fetch_array($dbstdcourse)){
				//capture distinct coursecodes
				$coursearray[] = $uniqcoz;
				}
			
			//check if there are results found
			if($totalcolms < 1){			
				$error = urlencode("There are no results for <b>$class $progname</b> in <b>$year</b>");
				$location = "lecturerAnnualresultsheet.php?error=$error";
				echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
				exit;
				}
			
			include 'includes/print_excel_annual.php';							
			}
		}
 
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Annual Results';
	$szTitle = 'Printing Semester Examinations Results Report';
	include('lecturerheader.php');
	$editFormAction = $_SERVER['PHP_SELF'];

	mysql_select_db($database_zalongwa, $zalongwa);
	$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
	$studentlist = mysql_query($query_studentlist, $zalongwa) or die(mysql_error());
	$row_studentlist = mysql_fetch_assoc($studentlist);
	$totalRows_studentlist = mysql_num_rows($studentlist);

	mysql_select_db($database_zalongwa, $zalongwa);
	$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
	$degree = mysql_query($query_degree, $zalongwa) or die(mysql_error());
	$row_degree = mysql_fetch_assoc($degree);
	$totalRows_degree = mysql_num_rows($degree);

	mysql_select_db($database_zalongwa, $zalongwa);
	$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
	$ayear = mysql_query($query_ayear, $zalongwa) or die(mysql_error());
	$row_ayear = mysql_fetch_assoc($ayear);
	$totalRows_ayear = mysql_num_rows($ayear);

	mysql_select_db($database_zalongwa, $zalongwa);
	$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
	$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
	$row_sem = mysql_fetch_assoc($sem);
	$totalRows_sem = mysql_num_rows($sem);

	mysql_select_db($database_zalongwa, $zalongwa);
	$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
	$dept = mysql_query($query_dept, $zalongwa) or die(mysql_error());
	$row_dept = mysql_fetch_assoc($dept);
	$totalRows_dept = mysql_num_rows($dept);

	
	?>
	
	<form name="form1" method="post" action="<?php echo $editFormAction ?>">
	            <div align="center">
				<table width="200" border="0" cellpadding="3" bgcolor="#CCCCCC">
	            <tr>
	                  <td colspan="3"><span class="style61">if you want to filter the results by  criteria <span class="style34">Tick the corresponding check box first</span> then select appropriately </span></td>
	                </tr>
	                <tr>
	                  <td nowrap><input name="checkdegree" type="checkbox" id="checkdegree" value="on" checked></td>
	                  <td nowrap><div align="left">Degree Programme:</div></td>
	                  <td>
	                      <div align="left">
	                        <select name="degree" id="degree">
	                          <?php
	do {  
	?>
	                          <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
	                          <?php
	} while ($row_degree = mysql_fetch_assoc($degree));
	  $rows = mysql_num_rows($degree);
	  if($rows > 0) {
	      mysql_data_seek($degree, 0);
		  $row_degree = mysql_fetch_assoc($degree);
	  }
	?>
	                        </select>
	                    </div></td></tr>
	                <tr>
	                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on" checked></td>
	                  <td nowrap><div align="left">Cohort of the  Year: </div></td>
	                  <td><div align="left">
	                    <select name="cohot" id="cohot">
	                        <?php
	do {  
	?>
	                        <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
	                        <?php
	} while ($row_ayear = mysql_fetch_assoc($ayear));
	  $rows = mysql_num_rows($ayear);
	  if($rows > 0) {
	      mysql_data_seek($ayear, 0);
		  $row_ayear = mysql_fetch_assoc($ayear);
	  }
	?>
	                    </select>
	                  </div></td>
	                </tr>
	            	<tr>
	                  <td><input name="checkyear" type="checkbox" id="checkyear" value="on" checked></td>
	                  <td nowrap><div align="left">Results of the  Year: </div></td>
	                  <td><div align="left">
	                    <select name="ayear" id="ayear">
	                        <?php
	do {  
	?>
	                        <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
	                        <?php
	} while ($row_ayear = mysql_fetch_assoc($ayear));
	  $rows = mysql_num_rows($ayear);
	  if($rows > 0) {
	      mysql_data_seek($ayear, 0);
		  $row_ayear = mysql_fetch_assoc($ayear);
	  }
	?>
	                    </select>
	                  </div></td>
	                </tr>
  <?php 

	                //check if paid

				if($userFaculty==31){

					echo '<input name="checkwh" type="hidden" id="checkwh" value="on" checked>';

					}

		?>          	                                   
	                <tr>
	                  <td colspan="3"><div align="center">
	                    <input type="submit" name="PDF"  id="PDF" value="Print PDF">
	                  </div>
	                  </td>
	                  </tr>
	                  <tr>
			   <td colspan="3"><div align="center">
	                    <input type="submit" name="Excel"  id="Excel" value="Print Excel">
	                  </div>
	                  </td>
	                  
	              </tr>
	              </table>
	              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
	  </div>
	</form>
	<?php

include('../footer/footer.php');
?>