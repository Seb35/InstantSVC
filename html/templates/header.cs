<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?cs if:project.name_encoded ?>
		<title><?cs if:title ?><?cs var:title ?> - <?cs /if ?><?cs var:project.name_encoded ?><?cs else ?>Trac: <?cs var:title ?><?cs /if ?></title>
 <?cs if:html.norobots ?><meta name="ROBOTS" content="NOINDEX, NOFOLLOW" /><?cs /if ?>
 <?cs if:false ?>
 <?cs
 each:rel = chrome.links ?><?cs
  each:link = rel ?><link rel="<?cs
   var:name(rel) ?>" href="<?cs var:link.href ?>"<?cs
   if:link.title ?> title="<?cs var:link.title ?>"<?cs /if ?><?cs
   if:link.type ?> type="<?cs var:link.type ?>"<?cs /if ?> /><?cs
  /each ?>
 <?cs /each ?>
 <?cs /if ?>
 
 <link rel="start" href="/" />
 <link rel="search" href="/search" />
 <link rel="help" href="/wiki/About" />
 <!-- <link rel="stylesheet" href="/chrome/site/css/trac.css" type="text/css" />-->
 <link rel="stylesheet" href="/chrome/site/css/wiki.css" type="text/css" />
 <link rel="icon" href="/chrome/site/favicon.ico" type="image/x-icon" />
 <link rel="shortcut icon" href="/chrome/site/favicon.ico" type="image/x-icon" />

 <link rel="alternate" href="/wiki/WikiStart?format=txt" title="Plain Text" type="text/plain" />
 
 <link href="/chrome/site/css/style.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="<?cs var:htdocs_location ?>js/trac.js"></script>
 <script type="text/javascript" src="/chrome/site/js/misc.js"></script>
</head>
<body>
<?cs include "site_header.cs" ?>

<div id="header">
	<a href="<?cs var:chrome.logo.link ?>"><img src="<?cs var:chrome.logo.src ?>" id="logo" alt="<?cs var:chrome.logo.alt ?>" /></a>
	<div id="nav">
	<ul class="nav2">
		<li><a href="/browser">Browse Source</a></li>
		<li><a href="/report">Bug Tracker</a></li>
		<li><a href="/newticket">New Ticket</a></li>
		<li><?cs if:trac.acl.SEARCH_VIEW ?><form id="search" action="<?cs var:trac.href.search ?>" method="get"><input type="text" id="proj-search" name="q" size="10" accesskey="f" value="Search" onfocus="searchOnFocus();" onblur="searchOnBlur();" /><input type="hidden" name="wiki" value="on" /><input type="hidden" name="changeset" value="on" /><input type="hidden" name="ticket" value="on" /></form><?cs /if ?></li>
	</ul>
	<ul style="margin-top:5px;" class="nav1">
		<li><a href="<?cs var:chrome.logo.link ?>">Home</a></li>
		<li><a href="/wiki/About">About</a></li>
		<li><a href="/wiki/Documentation">Docs</a></li>
		<li><a href="/roadmap">Roadmap</a></li>
		<li><a href="/wiki/Downloads">Downloads</a></li> 
	</ul>
	</div>
</div>

<div class="d1"><div class="d2"><div class="d3">
<div class="d4"><div class="d5"><div class="d6">	
<div class="d7"><div class="d8">
