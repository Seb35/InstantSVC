<?php
function formatParagraph($matches) {
	$t = str_replace("\n", ' ', $matches[2]);
	$t = wordwrap($t, 76);
	$t = str_replace("\n", "\n\t", $t);
	$t = trim($t);
	$t = "{$matches[1]}\n\t$t\n\n";
	return $t;
}

function wordWrapText($matches) {
	$t = str_replace("\n", ' ', $matches[2]);
	$t = wordwrap($t, 80);
	$t = trim($t);
	$t = "{$matches[1]}$t";
	return $t;
}

function formatVerbatim($m) {
	$t = $m[1];
	$t = str_replace("\n", "\n\t", $t);
	$t = trim($t);
	$t = "\t$t\n";
	return $t;
}

function conv($t) {
	$t = preg_replace('/%Introduction\\n%============\\n%\\n%Description\\n%-----------\\n\\n/', '', $t);
	$t = preg_replace('/%/', '', $t);
	$t = preg_replace('/\\n\\\\label{[^}]+}\\n/', "\n", $t);
	$t = preg_replace('/\\\\label{[^}]+}/', '', $t);
	$t = preg_replace('/\\\\(?:subsubsection|textbf){([^}]+)}/', '$1', $t);
	$t = preg_replace('/\\\\verb\\|([^\\|]+)\\|/', '$1', $t);
	$t = str_replace('\noindent', '', $t);
	$t = str_replace('\item', '-', $t);
	$t = str_replace('\ref{', 'TODO:ref:', $t);
	$t = preg_replace_callback('/'
		. '\\\\paragraph'
		. '{([^}]+)}'
		. '([^\\\\]*?)'
		. '\\n\\n/',
		formatParagraph,
		$t);
	$t = preg_replace_callback('/'
		. '([-=\\n]\\n)'
		. '((?:'
		. '(?<!---)'
		. '(?<!===)'
		. '[^\\t{\\\\])*?)'
		. '(?=\\n\\n)/',
		wordWrapText,
		$t);
	$t = preg_replace_callback('/'
		. '\\\\begin{verbatim}\\n'
		. '(.*?)'
		. '\\\\end{verbatim}'
		. '\\n/s',
		formatVerbatim,
		$t);
	$t = preg_replace('/\\\\begin{[^}]+}.*?\\n/', '', $t);
	$t = preg_replace('/\\\\end{[^}]+}\\n/', '', $t);
	$t = preg_replace('/\\$(.*?)\\$/', '$1', $t);
	return $t;
}


$tex = file_get_contents('instantsvc.tex');

// convert line endings
$tex = preg_replace('/\\r\\n/', "\n", $tex);
$tex = preg_replace('/ \\n/', "\n", $tex);

// convert cites
preg_match_all('/\\\\bibitem\{([^\}]+)\}(?:.|\\n)*?\\\\url\{([^\}]+)\}/m', $tex, $bibitems);
foreach($bibitems[1] as $key => $label) {
	$tex = str_replace("\\cite{{$label}}", "({$bibitems[2][$key]})", $tex);
}


$sections = preg_split('/\\\\section{([^}]+)}/', $tex, -1, PREG_SPLIT_DELIM_CAPTURE);
for ($i = 2; $i <= count($sections) / 2 - 1; ++$i) {
	$section = $sections[$i * 2 - 1];
	$text    = $sections[$i * 2];
	$dir = "components/$section/design";

	echo "$section\n";

	@mkdir($dir, 0700, true);
	$subsections = preg_split('/\\\\subsection{([^}]+)}/', $text);
	
	$intro = 'Introduction'
		. conv($subsections[1]);
        $requ = conv($subsections[0])
		. $intro
		. conv($subsections[2]);
	$design = conv($subsections[3]);
	file_put_contents("$dir/requirements.txt", $requ);
	file_put_contents("$dir/design.txt", $design);
}
?>
