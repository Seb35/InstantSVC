{{include file="admin-tool/admin-tool-header.tpl"}}
{{include file="admin-tool/admin-tool-navi.tpl"}}
<div id="main">
  <p>W&auml;hlen Sie eine Klasse aus, um sich deren Methoden anzeigen zu lassen.</p>
  <form method="POST" action="?view={{$view}}">
    <h3>Registrierte Klassen:</h3>
    <p>{{html_radios name="class_id" options=$class_list separator="<br/>"}}</p>
    <p>
    <input type="submit" name="select_class" value="Weiter" />
	</p>
  </form>
</div>
{{include file="admin-tool/admin-tool-footer.tpl"}}
