<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'News & Events';
	$szTitle = 'University News & Events';
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {
  $insertSQL = sprintf("INSERT INTO news (received, fromid, message,recepient) VALUES (now(), %s, %s,%s)",
                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['message'], "text"),
		       GetSQLValueString($_POST['recepient'], "text"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($insertSQL, $zalongwa) or die(mysql_error());

  //$insertGoTo = "housingcheckmessage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<meta http-equiv = "refresh" content ="0; 
				 url = studentNews.php">';
}

mysql_select_db($database_zalongwa, $zalongwa);
$query_suggestionbox = "SELECT received, fromid, toid, message FROM news ORDER BY received DESC";
$suggestionbox = mysql_query($query_suggestionbox, $zalongwa) or die(mysql_error());
$row_suggestionbox = mysql_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysql_num_rows($suggestionbox);

$RegNo = $_GET['from'];
 ?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


<?php
include('styles.inc');

function viewers()
{
echo"<select name='recepient'>";
$v=array("Students","Registrar","Examofficer","Administrar","All");
for($k=0;$k<count($v);$k++)
{
echo"<option value='$v[$k]'>$v[$k]</option>";
}
echo"</select>";
}
?>


           <form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">
            <table width="529" border="0">
              <tr>
                <td class='formfield'>Message:</td>
                <td><textarea name="message" cols="70" rows="20" class="normaltext" id="message"></textarea></td>
		<input name="regno" type="hidden" id="regno" value="<?php echo $name?>">
              </tr>
               <tr>
		<td class='formfield'>Recepients(Viewers)</td>
                <td><?php viewers();?></td></tr>
		<tr>
                <td class='formfield'>Post Message:</td>
                <td nowrap><input name="Send" type="submit" value="Post Message">
               <input type="reset" name="Reset" value="Clear Message">
                </td>
              </tr>
            </table>
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>
<?php
//}
include('../footer/footer.php');
mysql_free_result($suggestionbox);
?>
