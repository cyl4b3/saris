<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Delete Students';
	$szTitle = 'Search Student Record';
	include('admissionheader.php');
?>

<script type="text/javascript">
checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>

<script type='text/javascript'>
function confirmdelete( data)
{
if(confirm("Are you sure you want to delete the record      "+data))
{
return true;
}else
{
return false;
}
}
</script>
<?php
if(isset($_POST['delete']))
{
$Eq=$_POST[Eq];
$count=count($Eq);
if($count<=0)
{
echo "<table>
<tr><td>
<font color='red'>Choose Student please.</font>
</td></tr>
</table>";
}
else
{
$e=1;
for($j=0;$j<$count;$j++)
{
#Fetch Records
$sql = "SELECT * FROM student WHERE Id ='$Eq[$j]'"; 
$update = mysql_query($sql) or die(mysql_error());
$update_row = mysql_fetch_array($update)or die(mysql_error());
	$regno = addslashes($update_row['RegNo']);
	$stdid = addslashes($update_row['Id']);
	$AdmissionNo = addslashes($update_row['AdmissionNo']);     
	$degree = addslashes($update_row['ProgrammeofStudy']);
	$faculty = addslashes($update_row['Faculty']);
	$ayear = addslashes($update_row['EntryYear']);
	$combi = addslashes($update_row['Subject']);
	$campus = addslashes($update_row['Campus']);
	$manner = addslashes($update_row['MannerofEntry']);
	$surname = addslashes($update_row['Name']);
	$dtDOB = addslashes($update_row['DBirth']);
	$age = addslashes($update_row['age']);
	$sex = addslashes($update_row['Sex']);
	$sponsor = addslashes($update_row['Sponsor']);
	$country = addslashes($update_row['Nationality']);
	$district =addslashes($update_row['District']);
	$region =addslashes($update_row['Region']);
	$maritalstatus = addslashes($update_row['MaritalStatus']);
	$address = addslashes($update_row['Address']);
	$religion = addslashes($update_row['Religion']);
	$denomination = addslashes($update_row['Denomination']);
	$postaladdress =addslashes($update_row['postaladdress']);
	$residenceaddress = addslashes($update_row['residenceaddress']);
	$disabilityCategory = addslashes($update_row['disabilityCategory']);
	$status = addslashes($update_row['Status']);
	$gyear = addslashes($update_row['GradYear']);
	$phone1 = addslashes($update_row['Phone']);
	$email1 = addslashes($update_row['Email']);
	$formsix = addslashes($update_row['formsix']);
	$formfour = addslashes($update_row['formfour']);
	$diploma = addslashes($update_row['diploma']);
	$School_attended_olevel = addslashes($update_row['School_attended_olevel']);
	$School_attended_alevel =addslashes($update_row['School_attended_alevel']);
	$name = $surname;//", ".$firstname." ".$middlename;
//Added fields
$account_number=addslashes($update_row['account_number']);
$bank_branch_name=addslashes($update_row['bank_branch_name']);
$bank_name=addslashes($update_row['bank_name']);
$form4no=addslashes($update_row['form4no']);
$form4name=addslashes($update_row['form4name']);
$form6name=addslashes($update_row['form6name']);
$form6no=addslashes($update_row['form6no']);
$form7name=addslashes($update_row['form7name']);
$form7no=addslashes($update_row['form7no']);
$paddress=addslashes($update_row['paddress']);
$currentaddaress=addslashes($update_row['currentaddaress']);
$f4year=addslashes($update_row['f4year']);
$f6year=addslashes($update_row['f6year']);
$f7year=addslashes($update_row['f7year']);
#next of kin info
$kin=addslashes($update_row['kin']);
$kin_phone=addslashes($update_row['kin_phone']);
$kin_address=addslashes($update_row['kin_address']);
$kin_job=addslashes($update_row['kin_job']);
$studylevel=addslashes($update_row['studylevel']);
$ActUser=$_SESSION['username'];
$Action="Deleted";
//***********             
#insert record
$sql="INSERT INTO studentlog
(Name,AdmissionNo,
Sex,DBirth,
MannerofEntry,MaritalStatus,
Campus,ProgrammeofStudy,
Faculty,
Sponsor,GradYear,
EntryYear,Status,
Address,Nationality,
Region,District,Country,
Received,user,
Denomination, Religion,
Disability,formfour,
formsix,diploma,
f4year,f6year,f7year,
kin,kin_phone,
kin_address,kin_job,
disabilityCategory,Subject,
account_number,
bank_branch_name,
bank_name,
form4no,
form4name,
form6name,
form6no,
form7name,
form7no,
paddress,
Phone,
Email,
currentaddaress,
RegNo,
studylevel,
ActionDate,
Action,
ActUser
) 
VALUES
('$name','$AdmissionNo',
'$sex','$dtDOB',
'$manner','$maritalstatus',
'$campus','$degree',
'$faculty',' $sponsor',
'$gyear','$ayear',
'$status','$address',
'$country',
'$region','$district',
'$country',now(),
'$username','$denomination', 
'$religion','$disability',
'$formfour','$formsix',
'$diploma','$f4year',
'$f6year','$f7year',
'$kin','$kin_phone',
'$kin_address','$kin_job',
'$disabilityCategory','$Subject',
'$account_number',
'$bank_branch_name',
'$bank_name',
'$form4no',
'$form4name',
'$form6name',
'$form6no',
'$form7name',
'$form7no',
'$paddress',
'$phone1',
'$email1',
'$currentaddaress',
'$regno',
'$studylevel',
now(),
'$Action',
'$ActUser'
)";
//echo $sql;
$plg=mysql_query($sql)or die(mysql_error());
if($plg)
{
$delete=mysql_query("delete from student where Id='$Eq[$j]'");
}else
{

}
}
}
}


//Begin of Filter Panel
echo"<form action='$_SERVER[PHP_SELF]' method='GET'>
<table>
<tr>
<td>Enter RegNo/Admission/Name</td>
<td><input type='text' name='key'></td>
<td>";
?>
<input type='submit' name='search' value='Go' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'>

<?php
echo"</td>
<tr>
</table></form>";
if(isset($_GET['search'])||$_GET['key'])
{
$key=$_GET['key'];
$look="SELECT * FROM  student where RegNo like '%$key'OR Name like '%$key%' OR AdmissionNo like '%$key'";
}
else
{
$look="SELECT * FROM  student order by Faculty";
}

//Begin of Pagination
///START DISPLAYING RECORDS
$rowPerPage=20;
$pageNum=1;
if(isset($_GET['page']))
{
$pageNum=$_GET['page'];
}
$offset=($pageNum-1)*$rowPerPage;
$k=$offset+1;
$query=$look." LIMIT $offset,$rowPerPage";
$result=mysql_query($query) or die(mysql_error());
echo"<form action='$_SERVER[PHP_SELF]' method='POST' name='frm1'>";
echo"<center>
<table width='950' cellspacing='0' cellpadding='0'>
<tr><th>Select Students to Delete</th></tr></table>
</center>";
echo "<table cellspacing='0' border='1' width='950' cellpadding='0'>
<tr bgcolor='#ccccf'>
<th>sN</th>
<th>Student Name</th>
<th>RegNo</th>
<th>Faculty</th>
<th>Select
</th>
</tr>";
while($r=mysql_fetch_array($result))
{
echo "<tr>
<td>&nbsp;$k</td>
<td>&nbsp;$r[Name]</td>
<td>&nbsp;$r[RegNo]</td>
<td>&nbsp;$r[Faculty]</td>
<td>
<input type='checkbox' name='Eq[]' value='$r[Id]'>
</td>
</tr>";
$k++;
}
echo"</table>";


$data=mysql_query($look);
$numrows=mysql_num_rows($data);
$result=mysql_query($data);
$row=mysql_fetch_array($data);


$maxPage=ceil($numrows/$rowPerPage);

$self=$_SERVER['PHP_SELF'];
$nav='';
for($page=1;$page<=$maxPage;$page++)
{
if($page==$pageNum)
{
$nav.=" $page";
$nm=$page;
}else
{
$nav.="<a href=\"$self?page=$page&key=$key\">$page</a>";
}
}
if($pageNum>1)
{
$page=$pageNum-1;
$prev="<a href=\"$self?page=$page&key=$key\">Previous</a>";
$first="<a href=\"$self?page=1\">[First]</a>";
}
else
{
$prev='&nbsp;';
$first='&nbsp;';
}

if($pageNum<$maxPage)
{
$page=$pageNum+1;
$next="<a href=\"$self?page=$page&key=$key\">Next</a>";
$last="<a href=\"$self?page=$maxPage\" class='mymenu'>[Last Page]</a>";
}
else
{
$next='&nbsp;';
$last='&nbsp;';
}
echo"<table>
<tr>
<td width='200'>&nbsp;&nbsp;&nbsp;&nbsp;$prev&nbsp;&nbsp;</td>
<td width='200'>&nbsp;&nbsp;Page $nm of $maxPage&nbsp;&nbsp;</td>
<td width='200'>&nbsp;&nbsp;$next&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<font color='#CCCCCC'></font></td>
</tr></table></center>";
//End of Pagination


echo"<table><tr><td colspan='5'>";
?>
<input type='submit' name='delete' value='Delete' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'
id="All selected Students ?" onClick="return confirmdelete(this.id)">
<?php
echo"</td></tr></table>";
echo"</form>";

///END OF THE ISSUE OF DELETE

include('../footer/footer.php');
?>


