{{include file="admin-tool/admin-tool-header.tpl"}}
{{include file="admin-tool/admin-tool-navi.tpl"}}
<div id="main">
  <p>W&auml;hlen sie die Methoden aus, die mittels WebService ver&ouml;ffentlicht werden sollen.</p>
  <form method="POST" action="?view={{$view}}&amp;class_id={{$class_id}}">
    <h3>Methoden:</h3>
    <p>{{html_checkboxes name="method_ids" selected=$method_list_checked options=$method_list separator="<br />"}}</p>
    <p>
    <input type="submit" name="methodView_action" value="back" />
    <input type="submit" name="methodView_action" value="Speichern" />
    <input type="submit" name="methodView_action" value="Web Service erstellen" /></p>
  </form>
</div>
{{include file="admin-tool/admin-tool-footer.tpl"}}
