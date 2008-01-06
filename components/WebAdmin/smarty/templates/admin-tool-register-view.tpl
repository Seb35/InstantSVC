{{include file="admin-tool-header.tpl"}}
{{include file="admin-tool-navi.tpl"}}

<div id="main">
<form method="POST" action="?view={{$view}}" enctype="multipart/form-data">

{{if $subview eq "Suchen"}}
<p>Folgende Klassen wurden gefunden:</p>
<table>
  <tr>
  	<th></th>
    <th>Klassenname</th>
    <th>Pfad</th>
    <th>Bemerkung</th>
  </tr>
  {{foreach item=classfile key=name from=$tabledata}}
  <tr>
  	<td><input type="checkbox" name="class[]" value="{{$name}}" /></td>
    <td>{{$name}}</td>
    <td>{{$classfile}}</td>
    <td></td>
  </tr>
  {{/foreach}}
</table>
<p>
  <input type="reset" name="action" value="Abbrechen" />
  <input type="submit" name="action" value="Registrieren">
</p>

{{else}}

  <p><b>Web Service Klassen registrieren</b></p>
  Web Service Klassen suchen:
  <table>
    <tr>
      <td><input type="radio" name="searchmethod" value="byPath" checked="checked"><label>Verzeichnis durchsuchen:</label></td>
      <td>
        <input type="text" value="{{$searchpath}}" name="searchpath" size="70"/><br/>
        <input type="checkbox" {{$only_ws_tag}} name="only_ws_tag" value="checked">
        Nur Klassen mit @webservice-Tag ber&uuml;cksichtigen
      </td>
    </tr>
    <!-- <tr>
      <td><input type="radio" name="searchmethod" value="byClass">Datei angeben:</td>
      <td><input type="file" name="file" size="70" accept="text/*"></td>
    </tr> -->
  </table>
  <p>
    <input type="reset" name="action" value="Abbrechen" />
    <input type="submit" name="action" value="Suchen">
  </p>
</form>
<br>
<p>Bisher registrierte Klassen:</p>
<table>
  <tr>
    <th>Klassen-ID</th>
    <th>Klassenname</th>
    <th>Pfad</th>
    <th>Policy-Status</th>
    <th>Bemerkung</th>
  </tr>
  {{foreach item=row from=$tabledata}}
  <tr>
    <td>{{$row.class_table_id}}</td>
    <td>{{$row.class_name}}</td>
    <td></td>
    <td></td>
    <td>{{$row.description}}</td>
  </tr>
  {{/foreach}}
</table>
{{/if}}
</div>

{{include file="admin-tool-footer.tpl"}}
