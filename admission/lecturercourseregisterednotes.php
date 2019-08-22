<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Learning';
	$szTitle = 'Lecturer Notes and Assignments';
	$szSubSection = '';
	include("admissionheader.php");
	

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_coursecandidate = 13;
$pageNum_coursecandidate = 0;
if (isset($_GET['pageNum_coursecandidate'])) {
  $pageNum_coursecandidate = $_GET['pageNum_coursecandidate'];
}
$startRow_coursecandidate = $pageNum_coursecandidate * $maxRows_coursecandidate;

$colname_coursecandidate = "1";
if (isset($_COOKIE['username'])) {
  $colname_coursecandidate = (get_magic_quotes_gpc()) ? $_COOKIE['username'] : addslashes($_COOKIE['username']);
}
mysqli_select_db($database_zalongwa, $zalongwa);
$query_coursecandidate = "SELECT examregister.CourseCode, course.CourseName, examregister.RegNo
FROM course INNER JOIN examregister ON course.CourseCode = examregister.CourseCode
WHERE (((examregister.RegNo)='$username')) ORDER BY CourseCode";
$query_limit_coursecandidate = sprintf("%s LIMIT %d, %d", $query_coursecandidate, $startRow_coursecandidate, $maxRows_coursecandidate);
$coursecandidate = mysqli_query($zalongwa, $query_limit_coursecandidate) or die(mysqli_error($zalongwa));
$row_coursecandidate = mysqli_fetch_assoc($coursecandidate);

if (isset($_GET['totalRows_coursecandidate'])) {
  $totalRows_coursecandidate = $_GET['totalRows_coursecandidate'];
} else {
  $all_coursecandidate = mysqli_query($zalongwa, $query_coursecandidate);
  $totalRows_coursecandidate = mysqli_num_rows($all_coursecandidate);
}
$totalPages_coursecandidate = ceil($totalRows_coursecandidate/$maxRows_coursecandidate)-1;

$queryString_coursecandidate = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_coursecandidate") == false && 
        stristr($param, "totalRows_coursecandidate") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_coursecandidate = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_coursecandidate = sprintf("&totalRows_coursecandidate=%d%s", $totalRows_coursecandidate, $queryString_coursecandidate);

@$CourseCode = $_GET['CourseCode'];
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmCourseRegister")) {
  $insertSQL = sprintf("INSERT INTO coursecandidate (RegNo, CourseCode) VALUES (%s, %s)",
                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['coursecode'], "text"));

  mysqli_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die("You have already registered for this course, <br>duplicate Records are not allowed");

  $insertGoTo = "studentindex.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 
?>
   <table width="200" border="1">
            <tr>
              <td nowrap>Course Notes </td>
			  <td nowrap>Course Code</td>
			  <td nowrap>Course Title</td>
            </tr>
            <?php do { ?>
            <tr>
                <td nowrap><?php $CourseCode = $row_coursecandidate['CourseCode']; echo "<a href=\"lecturerlecturenotes.php?CourseCode=$CourseCode\"> Check Notes </a>"; ?></td>
				<td nowrap><?php echo $row_coursecandidate['CourseCode']; ?></td>
				<td nowrap><?php echo $row_coursecandidate['CourseName']; ?></td>
            </tr>
            <?php } while ($row_coursecandidate = mysqli_fetch_assoc($coursecandidate)); ?>
          </table>
          
            <p><a href="<?php printf("%s?pageNum_coursecandidate=%d%s", $currentPage, max(0, $pageNum_coursecandidate - 1), $queryString_coursecandidate); ?>">Previous</a> <span class="style64"><span class="style1">..</span><span class="style34">Record: <?php echo min($startRow_coursecandidate + $maxRows_coursecandidate, $totalRows_coursecandidate) ?> of <?php echo $totalRows_coursecandidate ?> </span><span class="style1">..</span></span><a href="<?php printf("%s?pageNum_coursecandidate=%d%s", $currentPage, min($totalPages_coursecandidate, $pageNum_coursecandidate + 1), $queryString_coursecandidate); ?>">Next </a> </p>
      
<?php
mysqli_free_result($coursecandidate);
	# include the footer
	include('../footer/footer.php');
?>
