<?php
	echo '<form method="post" id= "SelectionForm" name= "SelectionForm" target="_blank" action="AddNDA2.php" enctype="multipart/form-data">';
?>
	<br>
	<table class="addNDA">
		<tbody>
			<tr>
				<td class="formlabel">Docket</td>
				<td><input type="text" name="Docket" value="" onchange="document.getElementById('Submit2').disabled=false;"></td>
			</tr>
			<tr>
				<td class="formlabel">Effective Date</td>
				<td><input type="date" name="EffectiveDate" value="" onchange="document.getElementById('Submit2').disabled=false;"></td>
			</tr>
			<tr>
				<td class="formlabel">Expiration Date</td>
				<td><input type="date" name="ExpirationDate" value="" onchange="document.getElementById('Submit2').disabled=false;"></td>
			</tr>
		</tbody>

	</table>
	<br><br>

	<input name="Submit2" class="btn btn-primary" id="Submit2" type="submit" value="Submit" disabled style="width: 111px">
	<input name="Submit3" class="btn btn-primary" id="Submit3" type="submit" value="Update" style="width: 129px">
	<input name="Clear" class="btn btn-warning" type="reset" value="Clear">

	<!--<span class="style2"><br>
</span>&nbsp;-->
