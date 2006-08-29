<?php

/**
 * Calculate the hash value for a given string and reduce the range of return values
 * to an interval of [0, $bucketSize)
 *
 * @param string $str
 * @param integer $bucketSize
 * @return integer
 */
function calculateHash($str, $bucketSize) {
    $hash = DJBHash($str);
    $hash = $hash % $bucketSize;
    return $hash;
}

/**
 * Hash function generates a 32 bit integer from a string
 *
 * The algorithm is a PHP implementation of a hash algorithm conceived by
 * Daniel J. Bernstein
 *
 * @param string $str
 * @return integer
 */
function DJBHash($str) {
    $hash = 5381;

    $length = strlen($str);
    for ($i = 0; $i < $length; ++$i) {
        $hash = (($hash << 5) + $hash) + ord($str{$i});
    }
    return ($hash & 0x7FFFFFFF);
}

?>