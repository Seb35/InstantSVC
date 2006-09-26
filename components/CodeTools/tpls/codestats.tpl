<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Statistics</title>
<style>
 html, body {
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9pt;
 }
 
 table, tr {
 	border:1px solid #ccc;
	border-collapse:collapse;
 }
 
 th {
 	background-color:#C0D7E4;
 }
 
 td {
 	padding:2px 4px;
 }
 
 .folder {
 	background-color:#F0F0FF;
 }
 
 .r {
 	text-align:right;
 }
 
 .warn {
 	background-color:#FCE39A;
 }
 .err {
 	background-color:#FFBFBF;
 }
 img {border:0; vertical-align:middle;}
 .block {padding-left:30px;}
</style>
</head>

<body>
<table>
	<tr>
		<th>Datei</th>
		<th>MIME</th>
		<th>LoC</th>
		<th>Gr&ouml;ße</th>
	</tr>
	{{foreach item=item from=$stats key=key}}
	{{if $item->mimeType == 'folder'}}
	<tr class="folder">
	{{else}}
	<tr>
	{{/if}}
		<td>{{$key}}
		<td>{{$item->mimeType}}</td>
		<td class="r">{{$item->linesOfCode}}</td>
		<td class="r">{{$item->fileSize}}</td>
	</tr>
	{{/foreach}}
</table>

<table>
<tr>
	<th>ClassName</th>
	<th>Class Docu</th>
	<th>PropName</th>
	<th>Type</th>
	<th>MethodName</th>
	<th>Comment</th>
	<th>Return</th>
	<th>ParamName</th>
	<th>Type</th>
</tr>
{{foreach item=item key=classname from=$docu.classes}}
<tr {{if $item.missingParamTypes > 0 or $item.missingMethodComments > 0}}{{if $item.webservice}}class="err"{{else}}class="warn"{{/if}}{{/if}}>
	<td>{{if $item.webservice}}<img src="network.png" alt="Web Service" /> {{/if}}{{$classname}}</td>
	<td class="{{if $item.classComment}}warn{{/if}}">{{if $item.classComment}}ok{{else}}missing{{/if}}</td>
	<td colspan="7"></td>
</tr>
	{{foreach item=type key=propname from=$item.properties}}
	<tr>
		<td></td><td></td>
		<td>{{$propname}}</td><td {{if $type=='unknown'}}class="warn"{{/if}}>{{$type}}</td>
		<td colspan="5"></td>
	</tr>
	{{/foreach}}
	{{foreach item=method key=mname from=$item.methods}}
	<tr {{if $method.webmethod and (!$method.comment or $method.paramflaws > 0)}}class="err"{{/if}}>
		<td></td><td></td><td></td><td></td>
		<td>{{$mname}}</td>
		<td {{if !$method.comment}}class="warn"{{/if}}>{{if $method.comment}}ok{{else}}missing{{/if}}</td>
		<td {{if $method.return=='unknown'}}class="warn"{{/if}}>{{$method.return}}</td>
		<td colspan="2"></td>
	</tr>
	
		{{foreach item=type key=pname from=$method.params}}
		<tr>
			<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			<td>{{$pname}}</td>
			<td class="{{if $type=='unknown'}}{{if $method.webmethod}}err{{else}}warn{{/if}}{{/if}}">{{$type}}</td>
		</tr>
		{{/foreach}}
	{{/foreach}}
{{/foreach}}
</table>

<h1>Web Service Documentation Flaws</h1>

<!--<table>
<tr>
	<th>ClassName</th>
	<th>Class Docu</th>
	<th>PropName</th>
	<th>Type</th>
	<th>MethodName</th>
	<th>Comment</th>
	<th>Return</th>
	<th>ParamName</th>
	<th>Type</th>
</tr>-->
{{foreach item=item key=classname from=$docu.classes}}
{{if $item.webservice}}
<h2>{{$classname}}</h2>
<div class="block">
{{if $item.missingParamTypes > 0 or $item.missingMethodComments > 0}}
<h3>Methods</h3>
	<div class="block">
	{{foreach item=method key=mname from=$item.methods}}
		{{if $method.webmethod and $method.paramflaws > 0}}
			<h4>{{$mname}}</h4>
			<ul>
			{{if !$method.comment}}<li>no comment found</li>{{/if}}
			<li {{if $method.return=='unknown'}}class="warn"{{/if}}>return type: {{$method.return}}</li>
			{{if count($method.params) > 0}}

			{{foreach item=type key=pname from=$method.params}}
				{{if $type=='unknown'}}
				<li class="err">${{$pname}}: missing type information</li>
				{{/if}}
			{{/foreach}}
			{{/if}}
			</ul>
		{{/if}}
	{{/foreach}}
	</div>
</div>
{{else}}
	<p>No critical documentation flaws found.</p>
{{/if}}
{{/if}}
{{/foreach}}



	{{*
	hier wenn entschieden ist, wei das mit den daten klassen sein soll, auch fehler anzeigen
	foreach item=type key=propname from=$item.properties}}
	<tr>
		<td></td><td></td>
		<td>{{$propname}}</td><td {{if $type=='unknown'}}class="warn"{{/if}}>{{$type}}</td>
		<td colspan="5"></td>
	</tr>
	{{/foreach *}}

{{foreach item=msg key=file from=$docu.messages}}
<h3>{{$file}}</h3>
<pre>{{$msg}}</pre>
{{/foreach}}
</body>
</html>
