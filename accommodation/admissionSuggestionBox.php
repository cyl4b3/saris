<?php require_once('../Connections/zalongwa.php');
#get connected to the database and verfy current session
	# initialise globals
	# include the header
	$szSection = 'Communication';
	include('admissionheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
  switch ($theType) {
    case "text":
    case "long":
    case "int":
    case "double":
    case "date":
    case "defined":

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {
  $insertSQL = sprintf("INSERT INTO suggestion (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",

  mysql_select_db($database_zalongwa, $zalongwa);
//show replied
$qreplied="UPDATE suggestion SET replied='The message was replied by \'$username\', on: $t' WHERE id='$id'";

  //$insertGoTo = "housingcheckmessage.php";
  echo '<meta http-equiv = "refresh" content ="0; url = admissionCheckMessage.php">';
}


$RegNo = $_GET['from'];
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">
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
//}
?>