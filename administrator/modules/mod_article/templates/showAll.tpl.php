<h1>Alle Artikel</h1>
<a class='btn btn-default' href='/<?=$tpl_root?>/admin/article/add'>
	<span class='glyphicon glyphicon-plus'></span>
	Neuer Artikel
</a>
<br>
<br>
<table class='table'>
	<tr>
		<th>#</th>
		<th>Titel</th>
		<th>Author</th>
		<th>Veröffentlichungsdatum</th>
		<th>Hits</th>
		<th>Sichtbarkeit</th>
	</tr>
	<?=$tpl_article_entries?>
</table>