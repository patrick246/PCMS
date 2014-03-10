<h3>Rechte bearbeiten</h3>
<div>
	<a href='/<?=$tpl_root?>/admin/roles/showAll' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-th-list'></span>
		Zurück zur Übersicht
	</a>
	<a href='/<?=$tpl_root?>/admin/roles/edit/<?=$tpl_id?>' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-arrow-left'></span>
		Zurück zum Bearbeiten
	</a>
</div>
<br>
<table class='table'>
	<tr>
		<th>Recht</th>
		<th>Vorhanden?</th>
	</tr>
	<?=$tpl_entries?>
</table>