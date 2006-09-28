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

 .class {border:2px solid #ccc; margin:20px;}
 .class tr {border:0;}
 .class tbody {border:2px solid #ccc;}
 .class tbody tr {border-bottom:1px solid #eee;}


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
		<td class="r"><?php echo $file->countClasses; ?></td>
		<td class="r"><?php echo $file->countInterfaces; ?></td>
		<td class="r"><?php echo $file->countFunctions; ?></td>
	</tr>
	<?php endforeach; ?>
	<tr style="border-top:2px solid #000;">
	<td>Overall #: <?php ?></td>
	<td></td>
	<td class="r"><?php echo $overall['linesOfCode']; ?></td>
	<td class="r"><?php echo $overall['fileSize']; ?></td>
	<td class="r"><?php echo $overall['countClasses']; ?></td>
	<td class="r"><?php echo $overall['countInterfaces']; ?></td>
	<td class="r"><?php echo $overall['countFunctions']; ?></td>
	</tr>
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
		<td class="c"><?php echo $sum['project']['classes']['min']; ?></td>
		<td class="c"><?php echo (round($sum['project']['classes']['avg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['classes']['max']; ?></td>
	</tr>
	<tr>
		<td>Methods per Class</td>
		<td class="c"><?php echo $sum['project']['methods']['min']; ?></td>
		<td class="c"><?php echo (round($sum['project']['methods']['avg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['methods']['max']; ?></td>
	</tr>
	<tr>
		<td>Depth of Inheritance Tree</td>
		<td class="c"> - </td>
		<td class="c"><?php echo (round($sum['project']['classes']['DITavg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['classes']['DITmax']; ?></td>
	</tr>
	<tr>
		<td>Functions per File</td>
		<td class="c"><?php echo $sum['project']['functions']['min']; ?></td>
		<td class="c"><?php echo (round($sum['project']['functions']['avg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['functions']['max']; ?></td>
	</tr>
	<tr>
		<td>Params per Function/Method</td>
		<td class="c"><?php echo $sum['project']['functions']['paramMin']; ?></td>
		<td class="c"><?php echo (round($sum['project']['functions']['paramAvg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['functions']['paramMax']; ?></td>
	</tr>
	<tr>
		<td><span title="Lines of Code incl. inline comments">LoC</span> per Function/Method</td>
		<td class="c"><?php echo $sum['project']['functions']['locMin']; ?></td>
		<td class="c"><?php echo (round($sum['project']['functions']['locAvg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['functions']['locMax']; ?></td>
	</tr>
	<tr>
		<td><span title="Lines of DocBlock comments">LoDB</span> per Function/Method</td>
		<td class="c"><?php echo $sum['project']['functions']['lodbMin']; ?></td>
		<td class="c"><?php echo (round($sum['project']['functions']['lodbAvg'], 2)); ?></td>
		<td class="c"><?php echo $sum['project']['functions']['lodbMax']; ?></td>
	</tr>
	<tr>
		<td>Global DocBlock/Code Ratio</td>
		<td class="c" colspan="3"><?php echo (round($sum['project']['dbcRatio'], 2)); ?></td>
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
	<tr>
		<td>Abstract Classes</td>
		<td class="c" colspan="3"><?php echo $sum['project']['classes']['abstract']; ?></td>
	</tr>
	<tr>
		<td>Root Classes</td>
		<td class="c" colspan="3"><?php echo $sum['project']['classes']['root']; ?></td>
	</tr>
	<tr>
		<td>Leaf Classes</td>
		<td class="c" colspan="3"><?php echo $sum['project']['classes']['leaf']; ?></td>
	</tr>
</table>

<h2>MOOD Metrics - Project Metrics</h2>
<table>
<tr>
	<th>&nbsp;</th>
	<th>Value</th>
	<th>Suggestion</th>
</tr>
<tr>
	<td>MHF - Method Hiding Factor</td>
	<td class="c"><?php echo (round($sum['project']['MHF'] * 100, 2)).'%'; ?></td>
	<td> 8% - 25% </td>
</tr>
<tr>
	<td>AHF - Attribute Hiding Factor</td>
	<td class="c"><?php echo (round($sum['project']['AHF'] * 100, 2)).'%'; ?></td>
	<td> ~ 100% </td>
</tr>
<tr>
	<td>MIF - Method Inheritance Factor</td>
	<td class="c"><?php echo (round($sum['project']['MIF'] * 100, 2)).'%'; ?></td>
	<td>20% - 80%</td>
</tr>
<!--<tr>
	<td>AIF - Attribute Inheritance Factor</td>
	<td class="c"><?php echo $sum['project']['AIF']; ?></td>
</tr>-->
<tr>
	<td>PF - Polymorphism Factor</td>
	<td class="c"><?php echo (round($sum['project']['PF'] * 100, 2)).'%'; ?></td>
	<td title="a high PF indicates a rather complex system which is hard to manage.">&gt;= 10% but be aware of complexity</td>
</tr>
</table>

<h1>Class Metrics</h1>
<table>
<tr>
	<th>Class Name</th>
	<th title="Lines of Code">LoC</th>
	<th title="Lines of DocBlock Comments">LoDB</th>
	<th>#Properties</th>
	<th><span title="WMC - Weighted Methods Per Class">#Methods</span></th>
	<th><span title="WMCnp - Non-private methods defined by class">#none-private</span></th>
	<th><span title="WMCi - Methods defined and inherited by class">#inherited</span></th>
	<th><span title="WMCo - Methods overriden by class">#overriden</span></th>
	<th><span title="DIT - Depth of Inheritance Tree">#Superclasses</span></th>
	<th><span title="NOC - Number of Children">#Children</span></th>
	<th><span title="IMPL - Number of interfaces implemented by class">#Interfaces</span></th>
	<th></th>
</tr>
<?php foreach ($sum['classes'] as $classname => $item): ?>
<tr>
	<td><?php echo $classname; ?></td>
	<td class="c"><?php echo $item['LoC']; ?></td>
	<td class="c"><?php echo $item['LoDB']; ?></td>
	<td class="c"><?php echo $item['propertyCount']; ?></td>
	<td class="c"><?php echo $item['methodCount']; ?></td>
	<td class="c"><?php echo $item['nonePrivateMethods']; ?></td>
	<td class="c"><?php echo $item['inheritedMethods']; ?></td>
	<td class="c"><?php echo $item['overriddenMethods']; ?></td>
	<td class="c"><?php echo $item['DIT']; ?></td>
	<td class="c"><?php echo $item['childrenCount']; ?></td>
	<td class="c"><?php echo $item['interfaceCount']; ?></td>

	<td><?php if ($item['isWebService']): ?> is Web Service <?php endif; ?></td>
</tr>
<?php endforeach; ?>
</table>


<h1>Class Details</h1>

<?php foreach ($sum['classes'] as $classname => $item): ?>
<table class="class">
	<tr>
		<th colspan="7">
			<?php if($item['isAbstract']) { echo '<em>'; } 
					echo $classname; 
				  if($item['isAbstract']) { echo '</em>';}
			?>
			<?php 
				if(!empty($item['parentClass'])) {echo "<br/>\n extends ".$item['parentClass'];}
				if(count($item['interfaces']) > 0) {echo "<br/>\n implements ".implode(', ', $item['interfaces']);}
			?>
		</th>
		<th title="Lines of Code">LoC</th>
		<th title="Lines of DocBlock Comments">LoDB</th>
		<th title="Flaws in Param Documentation">Flaws</th>
	</tr>
	<tbody>
	<?php $umlVisibility = array('public' => '+', 'protected' => '#', 'private' => '-'); ?>
	<?php foreach ($item['properties'] as $propname => $prop): ?>
	<tr>
		<td><?php echo $umlVisibility[$prop['visibility']]; ?></td>
		<td style="<?php if($prop['isStatic']) { echo 'text-decoration:underline;';} ?>"><?php echo $propname; ?></td>
		<td>:</td>
		<td><?php echo $prop['type']; ?></td>
		<td colspan="4"></td>
		<td class="r"><?php echo $prop['LoDB']; ?></td>
		<td class="r"><?php echo ($prop['docuMissing'])?'Docu':''; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	<tbody>
	<?php foreach($item['methods'] as $mname => $method): ?>
	<tr <?php if($method['isInherited']) { echo 'style="display:none;"';} ?>>
		<td><?php echo $umlVisibility[$method['visibility']]; ?></td>
		<td style="<?php
			if($method['isStatic']) { echo 'text-decoration:underline;'; }
			if($method['isAbstract']) { echo 'font-style:italic;'; }
			if($method['isFinal']) { echo 'font-weight:bold;'; }
			?>"><?php echo $mname; ?></td>
		<td>(</td>
		<td>
		<?php
			$params = array();
			foreach($method['params'] as $pname => $param) {
				$params[] = $pname.':'.$param['type'];
			}
			echo implode(',<br/>', $params);
		?>
		</td>
		<td>)</td>
		<td>:</td>
		<td><?php echo $method['return']; ?></td>
		<td class="r"><?php echo $method['LoC']; ?></td>
		<td class="r"><?php echo $method['LoDB']; ?></td>
		<!-- <?php if ($method['webmethod']): ?> is Web Method<?php endif; ?> -->
		<td class="r"><?php echo $method['paramflaws']; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endforeach; ?>

<!-- Definitons and Source at


metrics http://www.aivosto.com/project/help/pm-oo-mood.html
http://www.aivosto.com/project/help/pm-proj-misc.html
hierachie metrics http://www.aivosto.com/project/help/pm-oo-misc.html
-->
</body>
</html>
