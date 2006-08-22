<script type="text/javascript">searchHighlight()</script><?cs
if:len(chrome.links.alternate) ?>
<div id="altlinks"><h3>Download in other formats:</h3><ul><?cs
 each:link = chrome.links.alternate ?><?cs
  set:isfirst = name(link) == 0 ?><?cs
  set:islast = name(link) == len(chrome.links.alternate) - 1?><li<?cs
    if:isfirst || islast ?> class="<?cs
     if:isfirst ?>first<?cs /if ?><?cs
     if:isfirst && islast ?> <?cs /if ?><?cs
     if:islast ?>last<?cs /if ?>"<?cs
    /if ?>><a href="<?cs var:link.href ?>"<?cs if:link.class ?> class="<?cs
    var:link.class ?>"<?cs /if ?>><?cs var:link.title ?></a></li><?cs
 /each ?></ul></div><?cs
/if ?>


</div></div></div>
</div></div></div>
</div></div>

<?cs # hier die nav generation so auseinander genommen, dass eigentlich login/logout context sensitiv erzeugt werden muesste # ?>
<?cs def:nav(items) ?><?cs
 if:len(items) ?><?cs
  set:idx = 0 ?><?cs
  set:max = len(items) - 1 ?><?cs
  each:item = items ?><?cs
   set:first = idx == 0 ?><?cs
   set:last = idx == max ?><?cs if:first ?><?cs var:item ?><?cs /if ?><?cs
   set:idx = idx + 1 ?><?cs
  /each ?><?cs
 /if ?><?cs
/def ?>

<div id="footer"><?cs call:nav(chrome.nav.metanav) ?> | valid <a href="#">CSS</a> &amp; <a href="#">XHTML</a> | <a href="#">powered by TOOLSLAVE.NET</a>
</div>
</body>
</html>