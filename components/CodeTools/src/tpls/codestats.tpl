<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Code Statistics</title>
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
	vertical-align:top;
 }

 .folder {
 	background-color:#F0F0FF;
 }

 .r {
 	text-align:right;
 }
 .l {
 	text-align:left;
 }
 .c {
 	text-align:center;
 }
 .warn {
 	background-color:#FCE39A;
 }
 .err {
 	background-color:#FFBFBF;
 }
 img {border:0; vertical-align:middle;}
 .block {padding-left:30px;}
 .small, .small th, small td {font-size:8px;}
 .small th {background-color:#F0F0FF; }

 .class tr {border:0;}
 .class tbody {border:1px solid #ccc;}
</style>
</head>

<body>
<h1>Overview for <?php echo $sourcePath; ?></h1>
<table>
	<tr>
		<th>File</th>
		<th>MIME</th>
		<th>Lines of Code</th>
		<th>File Size</th>
		<th>#Classes</th>
		<th>#Interfaces</th>
		<th>#Functions</th>
	</tr>
	<?php foreach ($stats as $name => $file):

	if ($file->mimeType == 'folder'): ?>
	<tr class="folder">
	<?php else: ?>
	<tr>
	<?php endif; ?>
		<td><?php echo $name; ?></td>
		<td><?php echo $file->mimeType; ?></td>
		<td class="r"><?php echo $file->linesOfCode; ?></td>
		<td class="r"><?php echo $file->fileSize; ?></td>
		<td class="r"><?php //echo $file->countClasses; ?></td>
		<td class="r"><?php //echo $file->countInterfaces; ?></td>
		<td class="r"><?php //echo $file->countFunctions; ?></td>
	</tr>
	<?php endforeach; ?>
</table>

<h1>Project Metrics</h1>
<table>
	<tr>
		<th>&nbsp;</th>
		<th class="c">min</th>
		<th class="c">avg</th>
		<th class="c">max</th>
	</tr>
	<tr>
		<td>Classes per File</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td>Methods per Class</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td>Depth of Inheritance Tree</td>
		<td class="c"> - </td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td>Functions per File</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td>Params per Function/Method</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td><span title="Lines of Code incl. inline comments">LoC</span> per Function/Method</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td><span title="Lines of DocBlock comments">LoDB</span> per Function/Method</td>
		<td class="c"></td>
		<td class="c"></td>
		<td class="c"></td>
	</tr>
	<tr>
		<td>Global DocBlock/Code Ratio</td>
		<td class="c" colspan="3"></td>
	</tr>
	<tr>
		<td>estimated flaws in documentation (faults)</td>
		<td class="c" colspan="3"></td>
	</tr>
	<tr>
		<td>estimated flaws in documentation (warnings)</td>
		<td class="c" colspan="3"></td>
	</tr>
	<tr>
		<td>overall used DocTags</td>
		<td class="c" colspan="3"></td>
	</tr>
</table>

<h1>Class Metrics</h1>
<table>
<tr>
	<th>Class Name</th>
	<th>Lines of Docu</th>
	<th>#Properties</th>
	<th><span title="WMC - Weighted Methods Per Class">#Methods</span></th>
	<th><span title="WMCnp - Non-private methods defined by class">#none-private</span></th>
	<th><span title="WMCi - Methods defined and inherited by class">#inherited</span></th>
	<th><span title="DIT - Depth of Inheritance Tree">#Superclasses</span></th>
	<th><span title="NOC - Number of Children">#Children</span></th>
	<th><span title="IMPL - Number of interfaces implemented by class">#Interfaces</span></th>
	<th></th>
</tr>
<?php foreach ($sum['classes'] as $classname => $item): ?>
<tr <?php if ($item['missingParamTypes'] > 0 or $item['missingMethodComments'] > 0): 
              if ($item['webservice']): ?>
	class="err"
	<?php else: ?>class="warn"<?php 
	          endif; 
		  endif;
	?>
>
	<td><?php echo $classname; ?></td>
	<td class="<?php if ($item['classComment'] < 1): ?>warn<?php endif; ?>"><?php if ($item['classComment'] < 1): ?>missing<?php else: echo $item['classComment']; endif; ?></td>
	
	<td><?php echo $item['propertyCount']; ?></td>
	<th><?php echo $item['methodCount']; ?></th>
	<th><?php echo $item['nonePrivateMethodCount']; ?></th>
	<th><?php echo $item['inheritedMethodCount']; ?></th>
	<th><?php echo $item['superclassCount']; ?></th>
	<th><?php echo $item['childrenCount']; ?></th>
	<th><?php echo $item['interfaceCount']; ?></th>
	
	<td><?php if ($item['webservice']): ?> is Web Service <?php endif; ?></td>
</tr>
<?php endforeach; ?>
</table>


<h1>Class Details</h1>

<table class="class">
	<tr>
		<th colspan="7">MyClass</th>
		<td></td>
	</tr>
	<tbody style="border:1px solid #ccc;">
	<tr>
		<td>+</td>
		<td>property</td>
		<td>:</td>
		<td>myType</td>
		<td colspan="3"></td>
		<td>0</td>
	</tr>
	<tr>
		<td>+</td>
		<td>property</td>
		<td>:</td>
		<td>myType</td>
		<td colspan="3"></td>
		<td>0</td>
	</tr>
	</tbody>
	<tbody style="border:1px solid #ccc;">
	<tr>
		<td>+</td>
		<td>doSomething</td>
		<td>(</td>
		<td> param:Type, param:Type, param:Type</td>
		<td>)</td>
		<td>:</td>
		<td>myType</td>
		<td>0</td>
	</tr>
	<tr>
		<td>+</td>
		<td>doSomething</td>
		<td>(</td>
		<td> a:Type, b:Type</td>
		<td>)</td>
		<td>:</td>
		<td>myType</td>
		<td>0</td>
	</tr>
	<tr>
		<td>+</td>
		<td>doSomething</td>
		<td>(</td>
		<td></td>
		<td>)</td>
		<td>:</td>
		<td>myType</td>
		<td>0</td>
	</tr>
	</tbody>
</table>
<table>
<tr>
	<th>Class Name</th>
	<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
</tr>
<?php foreach ($sum['classes'] as $classname => $item): ?>
<tr>
	<td colspan="5"><?php echo $classname; ?></td>
</tr>
<tr class="small">
	<th></th>
	<th class="l">Property Name</th>
	<th class="l">Type</th>
	<th>LoDB</th>
	<th></th>
</tr>
	<?php foreach ($item['properties'] as $propname => $prop): ?>
	<tr>
		<td></td>
		<td><?php echo $propname; ?></td>
		<td><?php echo $prop['type']; ?></td>
		<td class="c"><?php echo $prop['LoDB']; ?></td>
		<td></td>
	</tr>
	<?php endforeach; ?>
<tr class="small">
	<th></th>
	<th class="l">Method Name</th>
	<th class="l">Return Type</th>
	<th>LoDB</th>
	<th>&nbsp;</th>
</tr>
	<?php foreach($item['methods'] as $mname => $method): ?>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $mname; ?></td>
		<td><?php echo $method['return']; ?></td>
		<td class="c"><?php echo $method['comment']; ?></td>
		<td><?php if ($method['webmethod']): ?>is Web Method<?php endif; ?></td>
	</tr>

	<tr class="small">
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th class="l">Parameter Name</th>
		<th class="l">Type</th>
		<td>Flaws: <?php echo $method['paramflaws']; ?></td>
		
	</tr>
		<?php foreach($method['params'] as $pname => $type): ?>
		<tr>
			<td></td><td></td>
			<td><?php echo $pname; ?></td>
			<td><?php echo $type; ?></td>
			<td></td>
		</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>
<?php endforeach; ?>
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

<h4>TODO:</h4>
<ul>
<li>add project metrics http://www.aivosto.com/project/help/pm-oo-mood.html
  <ul>
    <li>http://www.aivosto.com/project/help/pm-proj-misc.html</li>
  </ul>
</li>
<li>add class hierachie metrics http://www.aivosto.com/project/help/pm-oo-misc.html</li>
</ul>
</body>
</html>
