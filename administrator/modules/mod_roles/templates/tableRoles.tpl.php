<h3>Alle Rollen</h3>
<a href='<?=$tpl_root?>admin/user/addRoleForm' class='btn btn-default btn-sm' style='margin-bottom: 15px;'>
	<span class='glyphicon glyphicon-plus'></span>
	Rolle hinzufügen
</a>
<form action='<?=$tpl_root?>admin/roles/editAction' method='POST'>
	<table class='table'>
		<tr>
			<th>
				ID
			</th>
			<th>
				Name
			</th>
			<th>
				Anzahl User
			</th>
		</tr>
		<?=$tpl_entries?>
	</table>
</form>