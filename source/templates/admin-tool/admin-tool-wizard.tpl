{{include file="admin-tool/admin-tool-header.tpl"}}
{{include file="admin-tool/admin-tool-navi.tpl"}}
<div id="main">
<form method="POST" action="?view=wizard">
{{if $step eq "start"}}
  <!-- erster Schritt des Wizards -->
  <h2>Willkommen beim Web Service Assistenten</h2>
  <p>Bitte folgen Sie den Anweisungen, um die Methoden Ihrer Klassen als Web Services
   zur ver&ouml;ffentlichen.</p>
  <p><b>Hinweis:</b> Bei Verwendung des Assistenten werden die Klassen nicht in der internen Datenbank registriert.</p>

{{elseif $step eq "step1"}}
  <h2>Schritt 1</h2>
  <p>Bitte geben sie den Suchpfad f&uuml;r Web Service Klassen ein.</p>
  <p><label>Suchpfad:</label><input type="text" value="{{$searchpath}}" name="searchpath" style="width:500px;" /></p>
  {{if isset($pathfailed)}}
    <p class="err">Suchpfad wurde nicht gefunden oder enth&auml;lt keine passenden Klassen</p>
  {{/if}}
  <p><input type="checkbox" name="only_ws_tag" value="true" checked="checked" />Nur Klassen mit @webservice-Annotation ber&uuml;cksichtigen</p>

{{elseif $step eq "step2"}}
  <h2>Schritt 2</h2>
  <p>Folgende Klassen wurden gefunden. W&auml;hlen sie die Klassen aus, die sie als Web Service
   ver&ouml;ffentlichen wollen.</p>
  <table>
  <tr>
  	<th></th>
    <th>Klassenname</th>
    <th>Pfad</th>
  </tr>
  {{foreach item=classfile key=name from=$list_classes}}
  <tr>
  	<td><input type="checkbox" name="class[]" value="{{$name}}" checked="checked"/></td>
    <td>{{$name}}</td>
    <td>{{$classfile}}</td>
  </tr>
  {{/foreach}}
</table>
{{elseif $step eq "finish"}}
  <h2>Konfiguration</h2>
  <p>
   F&uuml;r folgende Klassen und Methoden soll ein SOAP-Server erstellt werden.</p>
  <ul>
  {{foreach item=class key=name from=$classes name=classes}}
    <li>{{$name}}
	<ul>
	{{foreach from=$class.methods item=method key=mname}}
		{{if $method.webmethod}}
		<li>{{$mname}}</li>
		{{/if}}
	{{/foreach}}
	</ul>
	<table style="margin:15px 0px;">
	<tr><th colspan="2">Service Konfiguration</th></tr>
	<tr><td><label>WSDL Style:</label></td><td><select name="wsdlstyle[{{$name}}]">
    <option selected="selected" value="{{"WSDLGenerator::DOCUMENT_WRAPPED"|constant}}">Document / Literal (wrapped)</option>
    <option value="{{"WSDLGenerator::RPC_LITERAL"|constant}}">RPC / Literal</option>
    <option value="{{"WSDLGenerator::RPC_ENCODED"|constant}}">RPC / Encoded</option>
  </select></td></tr>
      <tr><td><label>Service Name:</label></td><td><input type="text" name="servicename[{{$name}}]" value="{{$name}}" /></td></tr>
	  <tr><td><label>Service URI:</label></td><td><input type="text" name="serviceuri[{{$name}}]" value="{{$serviceuri}}{{$name}}" style="width:500px" /></td></tr>
	  <tr><td><label>Namespace:</label></td><td><input type="text" name="namespace[{{$name}}]" value="{{$serviceuri}}{{$name}}" style="width: 500px;" /></td></tr>
	  <tr><td><label>Authentifikation mit <acronym title="Web Service Security: User Token Profile">UTP</acronym>:</label></td><td><input type="checkbox" name="useutp[{{$name}}]" value="true" /></td></tr>
	</table>
	{{if !$smarty.foreach.classes.last}}
	<hr />
	{{/if}}
	</li>
  {{/foreach}}
  </ul>
  <p><label>Zielpfad:</label> <input type="text" name="targetpath" value="{{$targetpath}}" style="width: 600px;" /></p>
  <p><label><input type="checkbox" name="createTargetDirectory" value="1" />Zielverzeichnis erstellen, falls es noch nicht existiert.</label></p>
  {{if isset($pathinvalid)}}<p>Der angegebene Pfad ist nicht g&uuml;ltig.</p>
  {{/if}}
  {{elseif $step eq "generate"}}  
    {{if !isset($generationfailed)}}
    <h1>Services erfolgreich erstellt</h1>
	<p>Die WSDL-Dateien und der SOAP-Server wurden erfolgreich erstellt und konfiguriert.</p>
    {{foreach from=$generatedServices item=generatedService}}
        <a href="{{$wsdlurl}}soap.php/{{$generatedService.servicename}}?wsdl" target="_blank">{{$wsdlurl}}soap.php/{{$generatedService.servicename}}?wsdl</a>
    {{/foreach}}
	{{else}}
	<h1>Erstellen der WSDL-Datei fehlgeschlagen!</h1>
	{{/if}}
  {{else}}
   <p>Wizard falsch konfiguriert!</p>
{{/if}}

<p>
<!-- Rueckmeldung an Controller -->
<input type="hidden" name="step" value="{{$step}}">

<!-- Buttons des Wizards -->
{{if $step != 'generate'}}
<input type="submit" name="cancel" tabindex="5" value="Abbrechen">
{{if $step neq "start"}}
  <input type="submit" name="back" tabindex="4" value="Zur&uuml;ck">
{{/if}}
{{if $step eq "finish"}}
  <input type="submit" name="next" tabindex="3" value="Fertigstellen">
{{else}}
  <input type="submit" name="next" tabindex="2" value="Weiter">
{{/if}}
{{/if}}
</p>
</form>
</div>
{{include file="admin-tool/admin-tool-footer.tpl"}}
