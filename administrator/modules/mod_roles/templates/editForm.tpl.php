<h3>Rolle bearbeiten</h3>
<div style='margin-bottom: 15px;'>
	<a href='<?=$tpl_root?>admin/roles/showAll' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-arrow-left'></span>
		Zurück zur Übersicht
	</a>
	<a href='<?=$tpl_root?>admin/roles/editRights/<?=$tpl_id?>' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-lock'></span>
		Rechte bearbeiten
	</a>
</div>
<form class='form-horizontal' action='<?=$tpl_root?>admin/roles/editAction' method='POST'>
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Name</label>
		<div class='col-sm-10'>
			<input type='text' class='form-control' name='name' value='<?=$tpl_name?>'>
		</div>
	</div>
	<div class='form-group'>
		<div class='col-sm-offset-2 col-sm-10'>
			<button type='submit' class='btn btn-default'>
				Bearbeiten
			</button>
		</div>
	</div>
	<input type='hidden' name='id' value='<?=$tpl_id?>'>
</form>