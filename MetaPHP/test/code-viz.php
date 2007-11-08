<?php
error_reporting(E_ALL);

/** init ezC **/
require_once 'ezc/Base/base.php';
function __autoload($className) { ezcBase::autoload($className); }

$c = new ReflectionClass('ezcGraph');
$content = file_get_contents($c->getFileName());
$tokens = token_get_all($content);
$content = split("\n", $content);

echo "Lines of Code: ".count($content)."\n";

$maxLength = 0;
foreach ($content as $line) {
	$maxLength = max($maxLength, strlen($line));
}

echo "Lenght of longest Line: $maxLength\n";

$imgWidth = $maxLength;
$imgHeight = count($content);

$img = imagecreatetruecolor($imgWidth, $imgHeight);
$backgroundColor = imagecolorallocate($img, 255, 255, 255);
imagefill($img, 0, 0, $backgroundColor);

$pixColor = imagecolorallocate($img, 0, 0, 0);
$commentColor = imagecolorallocate($img, 200, 200, 200);

$x = 0;
$y = 0;

foreach ($tokens as $token) {
	if (is_string($token)) {
		// simple 1-character token
		$tokenText = $token;
		$tokenId = -1;
	} else {
		// token array
		list($tokenId, $tokenText) = $token;
	}
	
	$tokenLength = strlen($tokenText);

	for ($i = 0; $i < $tokenLength; $i++) {
		if ($tokenText[$i] == "\n") {
			$y++;
			$x = 0;
			continue;
		}
		$char = trim($tokenText[$i]);
		if (!empty($char)) {
			switch ($tokenId) {
				case T_DOC_COMMENT:
				case T_COMMENT:
					$color = $commentColor;
					break;
				default:
					$color = $pixColor;
					break;
			}
			imagesetpixel($img, $x, $y, $color);
		}

		$x++;
	}
}

/*foreach ($tokens as $token) {
 if (is_string($token)) {
 // simple 1-character token
 echo $token;
 } else {
 // token array
 list($id, $text) = $token;

 switch ($id) {
 case T_COMMENT:
 case T_ML_COMMENT: // we've defined this
 case T_DOC_COMMENT: // and this
 // no action on comments
 break;

 default:
 // anything else -> output "as is"
 echo $text;
 break;
 }
 }
 }*/

imagepng($img, "test.png");
imagedestroy($img);
?>
