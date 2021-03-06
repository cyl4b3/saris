<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

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
//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
  $insertSQL = sprintf("INSERT INTO campus (Campus, Location, Address, Tel, Email) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtName'], "text"),
                       GetSQLValueString($_POST['txtPhyAdd'], "text"),
                       GetSQLValueString($_POST['txtAdd'], "text"),
                       GetSQLValueString($_POST['txtTel'], "text"),
                       GetSQLValueString($_POST['txtEmail'], "text"));

  mysqli_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
  $updateSQL = sprintf("UPDATE campus SET Campus=%s, Location=%s, Address=%s, Tel=%s, Email=%s WHERE CampusID=%s",
                       GetSQLValueString($_POST['txtName'], "text"),
                       GetSQLValueString($_POST['txtPhyAdd'], "text"),
                       GetSQLValueString($_POST['txtAdd'], "text"),
                       GetSQLValueString($_POST['txtTel'], "text"),
                       GetSQLValueString($_POST['txtEmail'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($zalongwa));

  $updateGoTo = "admissionInst.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysqli_select_db($database_zalongwa, $zalongwa);
$query_inst = "SELECT CampusID, Campus, Location, Address, Tel, Email FROM campus ORDER BY Campus ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysqli_query($zalongwa, $query_limit_inst) or die(mysqli_error($zalongwa));
$row_inst = mysqli_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysqli_query($zalongwa, $query_inst);
  $totalRows_inst = mysqli_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Institution Information';
	$szSubSection = 'Institution';
	include("admissionheader.php");
	
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


<p><?php echo "<a href=\"admissionInst.php?new=1\">"?>Add New Institution</a> </p>
<?php @$new=$_GET['new'];
if (@$new<>1){
?>

<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong>Campus</strong></td>
    <td><strong>Location</strong></td>
    <td><strong>Address</strong></td>
    <td><strong>Tel</strong></td>
    <td><strong>Email</strong></td>
  </tr>
  <?php do { ?>
  <tr>
    <td nowrap><?php $id = $row_inst['CampusID']; $name = $row_inst['Campus'];
	echo "<a href=\"admissionInst.php?edit=$id\">$name</a>"?></td>
    <td><?php echo $row_inst['Location']; ?></td>
    <td><?php echo $row_inst['Address']; ?></td>
    <td><?php echo $row_inst['Tel']; ?></td>
    <td><?php echo $row_inst['Email']; ?></td>
  </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">.............</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1">..............</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Institution:</div></th>
      <td><input name="txtName" type="text" id="txtName" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Address:</div></th>
      <td><input name="txtAdd" type="text" id="txtAdd" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row">Physical Address: </th>
      <td><input name="txtPhyAdd" type="text" id="txtPhyAdd" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Telephone:</div></th>
      <td><input name="txtTel" type="text" id="txtTel" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Email:</div></th>
      <td><input name="txtEmail" type="text" id="txtEmail" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row">&nbsp;</th>
      <td><div align="center">
        <input type="submit" name="Submit" value="Add Record">
      </div></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="frmInst">
</form>
<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];
mysqli_select_db($database_zalongwa, $zalongwa);
$query_instEdit = "SELECT * FROM campus WHERE CampusID ='$key'";
$instEdit = mysqli_query($zalongwa, $query_instEdit) or die(mysqli_error($zalongwa));
$row_instEdit = mysqli_fetch_assoc($instEdit);
$totalRows_instEdit = mysqli_num_rows($instEdit);

$queryString_inst = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_inst") == false && 
        stristr($param, "totalRows_inst") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_inst = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_inst = sprintf("&totalRows_inst=%d%s", $totalRows_inst, $queryString_inst);
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInstEdit" id="frmInstEdit">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Institution:</div></th>
      <td><input name="txtName" type="text" id="txtName" value="<?php echo $row_instEdit['Campus']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Address:</div></th>
      <td><input name="txtAdd" type="text" id="txtAdd" value="<?php echo $row_instEdit['Address']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row">Physical Address: </th>
      <td><input name="txtPhyAdd" type="text" id="txtPhyAdd" value="<?php echo $row_instEdit['Location']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Telephone:</div></th>
      <td><input name="txtTel" type="text" id="txtTel" value="<?php echo $row_instEdit['Tel']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Email:</div></th>
      <td><input name="txtEmail" type="text" id="txtEmail" value="<?php echo $row_instEdit['Email']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
      <td><div align="center">
        <input type="submit" name="edit" value="Edit Record">
      </div></td>
    </tr>
  </table>
      <input type="hidden" name="MM_update" value="frmInstEdit">
</form>
  <?php
}
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);
?>