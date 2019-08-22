<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Share Documents';
	$szTitle = 'Share Documents';
	$szSubSection = '';
	include("admissionheader.php");
	

$CourseCode = $_GET['CourseCode'];

$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 13;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = "SELECT docs.docId, docs.received, docs.doc, docs.filename FROM docs ORDER BY received DESC";
$query_limit_Recordset1 = sprintf($query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($zalongwa, $query_limit_Recordset1) or die(mysqli_error($zalongwa));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysqli_query($zalongwa, $query_Recordset1);
  $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<?php print "<a href=\"UploadDocs.php?docId=$docId\">Add Document</a>";?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

		<table width="662" border="1">
          <tr>
            <td width="87">Published</td>
			
            <td width="559">Document Link</td>
			<td width="559">Remove</td>
          </tr>
          <?php do { ?>
          <tr>
              <td nowrap><?php echo $row_Recordset1['received']; ?></td>
			  
              <td nowrap><?php echo $row_Recordset1['doc']; ?></td>
			  <td><?php $id =$row_Recordset1['docId']; $file =$row_Recordset1['filename']; print "<a href=\"DeleteDoc.php?id=$id&file=$file\">Drop</a>";?></td>
		  </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
        </table> 
      
            <p><a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a> <span class="style64"><span class="style1">....</span><span class="style34">Record:<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> of <?php echo $totalRows_Recordset1 ?> </span><span class="style1">...</span></span><a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next </a> </p>
        
<?php
mysqli_free_result($Recordset1);

mysqli_close($zalongwa);
	# include the footer
	include('../footer/footer.php');
?>
