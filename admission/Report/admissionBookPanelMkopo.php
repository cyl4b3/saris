<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Registration Form';
	$szTitle = 'Student Registration Form';
	include('admissionheader.php');


echo "
<form action='./Report/hslbreport.php' method='POST'>
<table>
<tr>
<td class='formfield'>Academic Year:</td>
<td>";
?>
<select name="ayear" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Academic Year]</option>";
$nm=mysql_query("SELECT AYear FROM academicyear where AYear!='$ayear' ORDER BY AYear DESC");
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[AYear]'>$show[AYear]</option>";      
}
?>										                                        												 
</select>
</td>
<td>


</td>
</tr>

<tr>
<td class='formfield'>Department/Faculty:</td>
<td>

<select name="faculty" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Department]</option>";
echo"<option  value='all'>All departments</option>";  
$nm=mysql_query("SELECT * FROM faculty ORDER BY FacultyName DESC");
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[FacultyID]'>$show[FacultyName]</option>";
   
}
echo"<option  value='all'>All departments</option>";   
?>										                                        												 
</select>
</td>
<td>


</td>
</tr>

<tr>
<td class='formfield'>Sponsor:</td>
<td>
<select name="sponsors" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Sponsor]</option>";
$nm=mysql_query("SELECT * FROM sponsors");
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[Name]'>$show[Name]</option>";  
}
?>										                                        												 
</select>
</td>
<td>


</td>
</tr>


<tr><td></td><td>
<input type='submit' name='Go' value='Go'>
</td>
</tr>
</table>
</form>
