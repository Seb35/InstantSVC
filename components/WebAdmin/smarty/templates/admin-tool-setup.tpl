<title>AdminTool Setup</title>{{include file="admin-tool-header.tpl"}}
{{include file="admin-tool-navi.tpl"}}
<div id="main">
  <h2>Setup</h2>
  {{if $step == 'unfinished'}}
  <form action="?" method="post">
  	<table>
		<tr>
			<td>Server: </td>
			<td><input type="text" name="server" value="localhost" /></td>
		</tr>
		<tr>
			<td>User: </td>
			<td><input type="text" name="user" value="root" /></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td><input type="password" name="password" value="" /></td>
		</tr>
		<tr>
			<td>Database: </td>
			<td><input type="text" name="database" value="instantsvc" /></td>
		</tr>
		<tr>
			<td></td><td><input type="submit" /></td>
		</tr>
	</table>
  </form>
  {{else}}
  <p>Das Admin Tool wurde erfolgreich eingerichtet und die ben&ouml;tigten Tabellen wurden in der Datenbank angelegt. </p>
  {{/if}}
  
</div>
{{include file="admin-tool-footer.tpl"}}
