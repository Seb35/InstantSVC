<?php
error_reporting(E_ALL | E_STRICT);
include('func.djbhash.php');

$arr = array(
'http://de3.php.net/manual/en/function.ord.php',
'http://www.partow.net/programming/hashfunctions/#RSHashFunction',
'http://www.google.de/ig?hl=de',
'http://del.icio.us/gron',
'http://del.icio.us/help/',
'http://www.google.com/search?hs=s3B&hl=de&client=opera&rls=de&q=motorrad&btnG=Suche&lr=',
//'http://instantsvc.toolslave.net/wiki/RecentChanges',
'http://instantsvc.toolslave.net/',
'http://www.google.com/search?client=opera&rls=de&q=php+froscon&sourceid=opera&ie=utf-8&oe=utf-8',
'http://instantsvc.toolslave.net/wiki/WikiFormatting',
'http://wcf.netfx3.com/content/resources.aspx',
'http://instantsvc.toolslave.net/wiki/TutorialNetGo',
'http://duden.de/',
'http://store.apple.com/Apple/WebObjects/deInd.woa/6054044/wo/pS50FPXDvpJD3u8fvLlYAQtEcZB/2.PSLID?mco=123F1D05&nclm=MacBook', 'http://geizhals.at/deutschland/?cat=hd2&sort=r',
'http://instantsvc.toolslave.net/wiki/RecentChanges',
'http://kino-potsdam.de/Monster-House-4354.html',
'http://lists.ethernal.org/oldarchives/cantlug-0306/msg00818.html',
'http://www.google.com/search?hs=dYY&hl=de&client=opera&rls=de&q=sqlite+tutorial+pdo&btnG=Suche&lr=',
'http://www.google.com/search?q=pdo+sqlite+create+table&btnG=Suche&hs=Iat&hl=de&client=opera&rls=de',
'http://www.google.com/search?hl=de&client=opera&rls=de&q=Hash+Functions&btnG=Suche&lr=',
'http://www.sqlite.org/lang_insert.html'
);
$colision = array();
$col = 0;
foreach ($arr as $url) {
  echo $url;
  echo '<br>  <b>';
  $hash = DJBHash($url);

  echo $hash;
  echo '  '.base_convert($hash, 10, 36);

  $hashMod = $hash % 50;
  echo ' '.$hashMod;
  echo '  '.base_convert($hashMod, 10, 36);

  if (in_array($hashMod, $colision)) {
      ++$col;
      echo ' <u>COLIDE</u> ';
  }
  else {
      $colision[] = $hashMod;
  }

  $hashDiv = round($hash / 1000000);
  echo ' '.$hashDiv;
  echo '  '.base_convert($hashDiv, 10, 36);
  echo '</b><br><br>';
}

var_dump($col);
?>