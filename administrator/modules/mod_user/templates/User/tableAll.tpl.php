<h2>Alle User</h2>
<a href='<?=$tpl_root?>admin/user/addForm' class='btn btn-default btn-sm' style='margin-bottom: 15px;'>
	<span class='glyphicon glyphicon-plus'></span>
	User hinzufügen
</a>
<table class='table'>
	<tr>
		<th>
			#
		</th>
		<th>
			Name
		</th>
		<th>
			Email
		</th>
		<th>
			Rolle
		</th>
		<th>
			Aktiviert
		</th>
	</tr>
	<?=$tpl_entries?>
</table>

