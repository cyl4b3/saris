<?php require_once('../Connections/zalongwa.php');
#get connected to the database and verfy current session	require_once('../Connections/sessioncontrol.php');    require_once('../Connections/zalongwa.php');
	# initialise globals	include('admissionMenu.php');
	# include the header	global $szSection, $szSubSection;
	$szSection = 'Communication';	$szSubSection = 'Suggestion Box';	$szTitle = 'Suggestion Box';
	include('admissionheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
  switch ($theType) {
    case "text":      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";      break;    
    case "long":
    case "int":      $theValue = ($theValue != "") ? intval($theValue) : "NULL";      break;
    case "double":      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";      break;
    case "date":      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";      break;
    case "defined":      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;      break;  }  return $theValue;}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {
  $insertSQL = sprintf("INSERT INTO suggestion (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",                       GetSQLValueString($_POST['regno'], "text"),                       GetSQLValueString($_POST['toid'], "text"),                       GetSQLValueString($_POST['message'], "text"));

  mysql_select_db($database_zalongwa, $zalongwa);  $Result1 = mysql_query($insertSQL, $zalongwa) or die(mysql_error());
//show replied$id=addslashes($_GET['id']);$t=date('l dS \of F Y h:i:s A');
$qreplied="UPDATE suggestion SET replied='The message was replied by \'$username\', on: $t' WHERE id='$id'";mysql_query($qreplied) or die(mysql_error());

  //$insertGoTo = "housingcheckmessage.php";  if (isset($_SERVER['QUERY_STRING'])) {    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";    $insertGoTo .= $_SERVER['QUERY_STRING'];  }
  echo '<meta http-equiv = "refresh" content ="0; url = admissionCheckMessage.php">';
}
mysql_select_db($database_zalongwa, $zalongwa);$query_suggestionbox = "SELECT suggestion.received, suggestion.fromid, suggestion.toid, suggestion.message FROM suggestion";$suggestionbox = mysql_query($query_suggestionbox, $zalongwa) or die(mysql_error());$row_suggestionbox = mysql_fetch_assoc($suggestionbox);$totalRows_suggestionbox = mysql_num_rows($suggestionbox);

$RegNo = $_GET['from']; ?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">            <table width="529" border="0">              <tr>
                <td width="95" height="21"><div align="right"><strong>Send To:</strong></div></td>
                <!--
                <td width="424" nowrap> <?php //echo $RegNo; ?>
                  <input name="regno" type="hidden" id="regno" value="admin">
                  <input name="received" type="hidden" id="received" value="<?php //$today = date("F j, Y"); echo $RegNo; ?>">
                  <select name="toid" id="toid">
  						<option value="<?php //echo $RegNo?>"><?php //echo $RegNo?></option>
                  </select></td>
				-->
				<td nowrap>
					<?php
					$user = $_SESSION['username'];
					$sql = mysql_query("SELECT RegNo FROM security WHERE UserName='$user'");			
					$sql = mysql_fetch_array($sql);
					$sender = $sql['RegNo'];
					echo "<input type='text' name='toid' value='".$RegNo."' readonly style='width:200px' >"; 
					echo "<input type='hidden' name='regno' value='".$sender."'></td>";
					?>	
              </tr>
              <tr>
                <td height="189"><div align="right"><strong>Message:</strong></div></td>
                <td><textarea name="message" cols="75" rows="13" class="normaltext" id="message"></textarea></td>
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
//}include('../footer/footer.php');mysql_free_result($suggestionbox);
?>
