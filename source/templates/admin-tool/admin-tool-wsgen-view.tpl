{{include file="admin-tool/admin-tool-header.tpl"}}
{{include file="admin-tool/admin-tool-navi.tpl"}}
<div id="main">
<form method="POST" action="?view=build">
{{if $step == 0}}
  <h2>Web Service erstellen </h2>
  <p>Folgende Klassen sind registriert, bitte w&auml;hlen Sie die Klassen aus, die Sie als Web Service
   ver&ouml;ffentlichen wollen:</p>
  <table>
  <tr>
    <th></th>
    <th>Klassenname</th>
    <th>Pfad</th>
  </tr>
  {{foreach item=class key=id from=$list_classes}}
  <tr>
    <td><input type="checkbox" name="class[]" value="{{$id}}" /></td>
    <td>{{$class.class_name}}</td>
    <td>{{$class.class_file}}</td>
  </tr>
  {{/foreach}}
</table>
{{elseif $step == 1}}
  {{if $type == 'soap'}}
  <h2>SOAP-Services: Konfiguration</h2>
  <p>
   F&uuml;r folgende Klassen und Methoden soll ein SOAP-Server erstellt werden.</p>
  <ul>
  {{foreach item=class key=id from=$classes name=classes}}
    <li>{{$class.class_name}}
    <ul>
    {{foreach from=$class.methods item=method key=mid}}
        <li>{{$method.method_name}}</li>
    {{/foreach}}
    </ul>
    <table style="margin:15px 0px;">
    <tr><th colspan="2">Service Konfiguration</th></tr>
    <tr><td><label>WSDL Style:</label></td><td><select name="wsdlstyle[{{$id}}]">
    <option selected="selected" value="{{"WSDLGenerator::DOCUMENT_WRAPPED"|constant}}">Document / Literal (wrapped)</option>
    <option value="{{"WSDLGenerator::RPC_LITERAL"|constant}}">RPC / Literal</option>
    <option value="{{"WSDLGenerator::RPC_ENCODED"|constant}}">RPC / Encoded</option>
  </select></td></tr>
      <tr><td><label>Service Name:</label></td><td><input type="text" name="servicename[{{$id}}]" value="{{$class.class_name}}" /></td></tr>
      <tr><td><label>Service URI:</label></td><td><input type="text" name="serviceuri[{{$id}}]" value="{{$serviceuri}}{{$class.class_name}}" style="width:500px" /></td></tr>
      <tr><td><label>Namespace:</label></td><td><input type="text" name="namespace[{{$id}}]" value="{{$serviceuri}}{{$class.class_name}}" style="width:500px" /></td></tr>
      <tr><td><label>Authentifikation mit <acronym title="Web Service Security: User Token Profile">UTP</acronym>:</label></td><td><input type="checkbox" name="useutp[{{$id}}]" value="true" /></td></tr>
    </table>
    {{if !$smarty.foreach.classes.last}}
    <hr />
    {{/if}}
    </li>
  {{/foreach}}
  </ul>
  <p><label>Zielpfad:</label> <input type="text" name="targetpath" value="{{$targetpath}}" style="width: 600px;" /></p>
  <p><label><input type="checkbox" name="createTargetDirectory" value="1" />Zielverzeichnis erstellen, falls es noch nicht existiert.</label></p>
  <p><label><input type="checkbox" name="appendToExistingDd" value="1" checked="checked" />Append the service configurations if a deployment descriptor already exists in the target directory.</label></p>
  {{if isset($pathinvalid)}}<p>Der angegebene Pfad ist nicht g&uuml;ltig.</p>
  {{/if}}
  
  {{elseif $type == 'xmlrpc'}}
  
  
                <h2>XML-RPC-Services: Konfiguration</h2>
                <p>F&uuml;r folgende Klassen und Methoden soll ein XML-RPC-Server erstellt werden.</p>
                <ul>
                    {{foreach item=class key=id from=$classes name=classes}}
                        <li>{{$class.class_name}}
                            <ul>
                                {{foreach from=$class.methods item=method key=mid}}
                                    <li>{{$method.method_name}}</li>
                                {{/foreach}}
                            </ul>
                            <table style="margin:15px 0px;">
                                <tr><th colspan="2">Service Konfiguration</th></tr>
                                <tr><td><label>Service Name:</label></td><td><input type="text" name="servicename[{{$id}}]" value="{{$class.class_name}}" /></td></tr>
                                <tr><td><label>Service URI:</label></td><td><input type="text" name="serviceuri[{{$id}}]" value="http://localhost/xmlrpc.php/{{$class.class_name}}" /></td></tr>
                            </table>
                            {{if !$smarty.foreach.classes.last}}
                                <hr />
                            {{/if}}
                        </li>
                    {{/foreach}}
                </ul>
  <p><label>Zielpfad:</label> <input type="text" name="targetpath" value="{{$targetpath}}" style="width: 600px;" /></p>
  <p><label><input type="checkbox" name="createTargetDirectory" value="1" />Zielverzeichnis erstellen, falls es noch nicht existiert.</label></p>
  <p><label><input type="checkbox" name="appendToExistingDd" value="1" checked="checked" />Append the service configurations if a deployment descriptor already exists in the target directory.</label></p>
  {{if isset($pathinvalid)}}<p>Der angegebene Pfad ist nicht g&uuml;ltig.</p>
  {{/if}}
                
    {{elseif $type == 'rest'}}
  
  
                <h2>REST-Services: Konfiguration</h2>
                <p>F&uuml;r folgende Klassen und Methoden soll ein REST-Server erstellt werden.</p>
                <ul>
                    {{foreach item=class key=id from=$classes name=classes}}
                        <li>{{$class.class_name}}
                            <ul>
                                {{foreach from=$class.methods item=method key=mid}}
                                    <li>{{$method.method_name}}</li>
                                {{/foreach}}
                            </ul>
                            <table style="margin:15px 0px;">
                                <tr><th colspan="2">Service Konfiguration</th></tr>
                                <tr><td><label>Service Name:</label></td><td><input type="text" name="servicename[{{$id}}]" value="{{$class.class_name}}" /></td></tr>
                                <tr><td><label>Service URI:</label></td><td><input type="text" name="serviceuri[{{$id}}]" value="http://localhost/rest.php/{{$class.class_name}}" /></td></tr>
                            </table>
                            {{if !$smarty.foreach.classes.last}}
                                <hr />
                            {{/if}}
                        </li>
                    {{/foreach}}
                </ul>
  <p><label>Zielpfad:</label> <input type="text" name="targetpath" value="{{$targetpath}}" style="width: 600px;" /></p>
  <p><label><input type="checkbox" name="createTargetDirectory" value="1" />Zielverzeichnis erstellen, falls es noch nicht existiert.</label></p>
  <p><label><input type="checkbox" name="appendToExistingDd" value="1" checked="checked" />Append the service configurations if a deployment descriptor already exists in the target directory.</label></p>
  {{if isset($pathinvalid)}}<p>Der angegebene Pfad ist nicht g&uuml;ltig.</p>
  {{/if}}
                
    {{/if}}
  
  {{elseif $step == 2}}  
    {{if !isset($generationfailed)}}
    <h1>Services erfolgreich erstellt</h1>
    <p>Der Server wurde erfolgreich erstellt und konfiguriert.</p>
    {{foreach from=$generatedServices item=generatedService}}
        <a href="{{$wsdlurl}}soap.php/{{$generatedService.servicename}}?wsdl" target="_blank">{{$wsdlurl}}soap.php/{{$generatedService.servicename}}?wsdl</a><br />
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
{{if $step != 2}}
<input type="submit" name="cancel" tabindex="5" value="Abbrechen">
{{if $step neq 0}}
  <input type="submit" name="back" tabindex="4" value="Zur&uuml;ck">
{{/if}}
{{if $step eq 1}}
  <input type="submit" name="next" tabindex="3" value="Fertigstellen">
{{else}}
  <input type="submit" name="next" tabindex="2" value="Weiter">
{{/if}}
{{/if}}
</p>
</form>
</div>
{{include file="admin-tool/admin-tool-footer.tpl"}}
