<h1>User Detailansicht: <?=$tpl_username?></h1>
<div class='mod_user_small' style='margin-bottom: 15px;'>
	<a href='<?=$tpl_root?>admin/user/showAll' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-arrow-left'></span> 
		Zurück
	</a>
	<a href='<?=$tpl_root?>admin/user/editForm/<?=$tpl_id?>' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-edit'></span> 
		Bearbeiten
	</a>
	<a href='<?=$tpl_root?>admin/user/roleRights/<?=$tpl_roleid?>' class='btn btn-default btn-sm'>
		<span class='glyphicon glyphicon-lock'></span>
		Rechte der Rolle
	</a>
</div>
<table class='table'>
	<tr>
		<th>ID</th>
		<td><?=$tpl_id?></td>
	</tr>
	<tr>
		<th>Username</th>
		<td><?=$tpl_username?></td>
	</tr>
	<tr>
		<th>Email</th>
		<td><?=$tpl_email?></td>
	</tr>
	<tr>
		<th>Rolle</th>
		<td><?=$tpl_role?></td>
	</tr>
	<tr>
		<th>Gebannt</th>
		<td><?=$tpl_banned?></td>
	</tr>
	<tr>
		<th>Letze Aktivität</th>
		<td><?=$tpl_last_action?></td>
	</tr>
	<tr>
		<th>Registrierungsdatum</th>
		<td><?=$tpl_register_date?></td>
	</tr>
</table>