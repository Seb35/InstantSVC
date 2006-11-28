{{include file="admin-tool/admin-tool-header.tpl"}}
{{include file="admin-tool/admin-tool-navi.tpl"}}
<div id="main">
  <p>Hier werden alle Details einer Methode angezeigt. Die Source-Code
     Kommentare k&ouml;nnen durch benutzerdefinierte Kommentare ersetzt
     werden</p><br/>
  <form method="get" action="">
    <input type="hidden" name="view" value="{{$view}}" />
    <input type="hidden" name="method_id" value="{{$method_id}}" />
    <input type="hidden" name="class_id" value="{{$class_id}}" />
    <p>Methode <b>{{$method_name}}</b> der Klasse <b>{{$class_name}}</b>:</p><br />
    <p>
    Source-Code-Kommentar:
    <br/>
    <textarea id="form_method_details" name="source_code_comment" readonly="true">{{$source_code_comment}}</textarea>
    </p>
    <p>
    Eigenes Kommentar (wird in wsdl-Datei &uuml;bernommen):
    <br/>
    <textarea id="form_method_details" name="user_comment">{{$user_comment}}</textarea>
    <br/>

    <input type="submit" name="methodDetailsView_action" value="Zur&uuml;ck" />
    <input type="submit" name="methodDetailsView_action" value="Speichern" />

  </form>
</div>
{{include file="admin-tool/admin-tool-footer.tpl"}}
