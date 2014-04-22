<?php
function checkImageIf($cond)
{
	if($cond) return '<span class="glyphicon glyphicon-ok"></span>';
	return '<span class="glyphicon glyphicon-remove"></span>';
}
?>
<div class="container">
	<h1>Benötigte Konfiguration</h1>
	<table class="table">
		<tr <?=(!$tpl_phpversion)?'class="danger"':''?>>
			<td>PHP-Version (größer gleich 5.3.0, nowdoc support)</td>
			<td><?=checkImageIf($tpl_phpversion)?></td>
		</tr>
		<tr <?=(!$tpl_pdo_active)?'class="danger"':''?>>
			<td>PDO-Treiber (mysql-Treiber installiert)</td>
			<td><?=checkImageIf($tpl_pdo_active)?></td>
		</tr>
		<tr <?=(!$tpl_apache)?'class="danger"':''?>>
			<td>Apache-Server (benötigt wegen mod_rewrite)</td>
			<td><?=checkImageIf($tpl_apache)?></td>
		</tr>
		<tr <?=(!$tpl_mod_rewrite)?'class="danger"':''?>>
			<td>mod_rewrite (benötigt zur Adressumschreibung)</td>
			<td><?=checkImageIf($tpl_mod_rewrite)?></td>
		</tr>
	</table>
	<p class="pull-right">
		<a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-chevron-left"> Zurück</span></a>
		<a class="btn btn-primary <?=($tpl_next)?'':'disabled'?>" href="?step=db">Weiter <span class="glyphicon glyphicon-chevron-right"></span></a>
	</p>
	
</div>
