<?php
error_reporting(E_ALL);

/** init ezC **/
require_once 'ezc/Base/base.php'; 
function __autoload($className) { ezcBase::autoload($className); }

$c = new ReflectionClass('ezcBase');
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
$commentColor = imagecolorallocate($img, 100, 100, 100);
$t = 0; //current token
$tIndex = 0; //index in token


/*$token = $tokens[0];
if (is_string($token)) {
    // simple 1-character token
    $tokenText = $token;
} else {
	// token array
    list($tokenId, $tokenText) = $token;
}

if ($tIndex >= strlen($tokenText)) {
		$t++;
		$token = $tokens[$t];
		if (is_string($token)) {
	        // simple 1-character token
    	    $tokenText = $token;
    	    $tokenId = -1;
    	} else {
        	// token array
        	list($tokenId, $tokenText) = $token;
		}
	}
	
switch ($tokenId) {
				case T_DOC_COMMENT:
				case T_COMMENT:
					$color = $commentColor;
					break;
				default:
					$color = $pixColor;
					break;
			}
*/
foreach ($content as $y => $line) {
	$lineLength = strlen($line);
	
	for ($x = 0; $x < $lineLength; $x++) {
		$char = trim($line[$x]);
		if (!empty($char)) {
			imagesetpixel($img, $x, $y, $pixColor);
		}
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
