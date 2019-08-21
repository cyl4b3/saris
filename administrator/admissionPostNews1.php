<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('administratorMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'News & Events';
	$szTitle = 'University News & Events';
	include('administratorheader.php');

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {
  $insertSQL = sprintf("INSERT INTO news (received, fromid, message) VALUES (now(), %s, %s)",
                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['message'], "text"));

  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$insertSQL) or die(mysqli_error($zalongwa));

  //$insertGoTo = "housingcheckmessage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<meta http-equiv = "refresh" content ="0; 
				 url = studentNews.php">';
}

mysqli_select_db($zalongwa,$database_zalongwa);
$query_suggestionbox = "SELECT received, fromid, toid, message FROM news ORDER BY received DESC";
$suggestionbox = mysqli_query($zalongwa,$query_suggestionbox) or die(mysqli_error($zalongwa));
$row_suggestionbox = mysqli_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysqli_num_rows($suggestionbox);

$RegNo = $_GET['from'];
 ?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">
            <table width="529" border="0">
              <tr>
                <td width="95" height="189"><div align="right"><strong>Message:</strong></div></td>
                <td width="424"><textarea name="message" cols="75" rows="13" class="normaltext" id="message"></textarea></td>
				<input name="regno" type="hidden" id="regno" value="<?php echo $name?>">
              </tr>
			  <tr>
                <td height="28" nowrap><div align="right"><strong>Post Message:</strong></div></td>
                <td nowrap><div align="center">
                  <input name="Send" type="submit" value="Post Message">
                  <span class="style64 style1">................................................</span>
                  <input type="reset" name="Reset" value="Clear Message">
                </div></td>
              </tr>
            </table>
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>
<?php
//}
include('../footer/footer.php');
mysqli_free_result($suggestionbox);
?>