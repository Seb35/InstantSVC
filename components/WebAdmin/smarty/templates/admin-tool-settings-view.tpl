{{include file="admin-tool-header.tpl"}}
{{include file="admin-tool-navi.tpl"}}
<div id="main">
<form method="POST" action="?view={{$view}}">

  <h2>Einstellungen</h2>
  <p>
    <ul>
     <li>
       Standardsuchpfad f&uuml;r Web Service Klassen: <br/>
       <input type="text" value="{{$searchpath}}" name="searchpath" style="width:500px; " />
     </li>
     <br/>
     <li>
       Standard-Server:<br/>
       {{html_radios name="selectedServer" options=$serverList selected=$markedServer separator="<br/>"}}
     </li>
     </br>
     <li>
       Sicherheit:<br/>
       {{html_radios name="selectedSecurity" options=$securityList selected=$markedSecurity separator="<br/>"}}
     </li>
    </ul>
  </p>
  
  <p>
  <input type="submit" name="action" value="Abbrechen" />
  <input type="submit" name="action" value="Ok" /></p>

</form>
</div>
{{include file="admin-tool-footer.tpl"}}
