<h1>Dashboard</h1>
<div class='mod_dashboard_main'>
	<h3>Aktive User (Frontend)</h3>
	<?php 
	if(count($tpl_users) != 0)
	{
	?>
	<table class='table'>
		<tr>
			<th>Username</th><th>Letzte Aktivität</th><th>Rolle</th>
		</tr>
		<?php
			foreach($tpl_users as $user)
			{
		?>
				<tr>
					<td><?=$user->name?></td><td><?=date('d. M. Y H:i:s', $user->last_action)?></td><td><?=$tpl_roles[$user->role_id]?></td>
				</tr>
		<?php 
			}
		?>
	</table>
	<?php 
	}
	else
	{
	?>
	<p class='alert alert-info'>Keine Useraktivität</p>
	<?php 
	}
	?>
	<h3>Die letzten Zugriffe</h3>
	<table class='table'>
		<tr>
			<th>#</th><th>IP</th><th>Zugriffsdatum</th><th>Query-String</th><th>Referrer</th><th>User-Agent</th>
		</tr>
		<?php 
			foreach($tpl_visitors as $visitor)
			{
		?>
				<tr<?=($visitor->ip == "127.0.0.1" || $visitor->ip == "::1")?' class="success"':''?>>
					<td><?=$visitor->id?></td><td><?=$visitor->ip?></td><td><?=date('d.M.Y H:i:s', $visitor->time_visited)?></td><td><?=$visitor->querystring?></td><td><?=$visitor->referrer?></td><td><?=$visitor->user_agent?></td>
					
				</tr>
		<?php
			}
		?>
	</table>
</div>