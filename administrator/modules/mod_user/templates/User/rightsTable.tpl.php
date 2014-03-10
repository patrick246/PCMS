<h1>Rechte von <?=$tpl_username?></h1>
<form action='/<?=$tpl_root?>/admin/user/setRights' method='POST'>
	<div>
		<a href='/<?=$tpl_root?>/admin/user/showAll ' class='btn btn-default btn-sm'>
			<span class='glyphicon glyphicon-th-list'></span>
			Zurück zur Liste
		</a>
		<a href='/<?=$tpl_root?>/admin/user/detail/<?=$tpl_id?>' class='btn btn-default btn-sm'>
			<span class='glyphicon glyphicon-arrow-left'></span>
			Zurück zur Übersicht
		</a>
		<button type='submit' class='btn btn-primary btn-sm'>
			<span class='glyphicon glyphicon-floppy-disk'></span>
			Speichern
		</button>
	</div>
	<br>
	<table class='table'>
		<tr>
			<th>Recht</th>
			<th>Vorhanden?</th>
		</tr>
		
			<?php 
			foreach($tpl_rights as $rightID=>$right)
			{
			?>
			<tr>
				<td><?=$right['name']?></td>
				<td><input type='checkbox' name='right_<?=$rightID?>' <?=($right['granted'])?'checked':''?>></td>
			</tr>
			<?php 
			}
			?>
	</table>
</form>

