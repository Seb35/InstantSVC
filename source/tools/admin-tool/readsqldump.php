<?php
/**
 * @todo Mit Anpassungen aus phpMyAdmin übernommen
 * das löschen der komments ist von mir,
 * sollte aber unbedingt komplett neu geschrieben werden, da phpMyAdmin GPL nutzt und somit
 * nicht kompatibel ist zum rest des projekts
 * @license http://www.gnu.org/copyleft/gpl.html GNU GENERAL PUBLIC LICENSE (GPL)
 * @author phpMyAdmin
 * @author Stefan Marr <mail@stefan-marr.de>
 */

/* $Id: read_dump.lib.php,v 2.11 2006/01/17 17:02:30 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * Removes comment lines and splits up large sql files into individual queries
 *
 * Last revision: September 23, 2001 - gandon
 *
 * @param   array    the splitted sql commands
 * @param   string   the sql commands
 *
 * @return  string[] array of queries
 *
 * @access  public
 */
function PMA_splitSqlFile($sql)
{
    // do not trim, see bug #1030644
    //$sql          = trim($sql);
    $sql          = rtrim($sql, "\n\r");
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $nothing      = TRUE;
    $time0        = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];

        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i         = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    if (!$nothing) {
                       $ret[] = $sql;
                    }
                    return $ret;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                elseif ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)

        // lets skip comments (/*, -- and #)
        elseif (($char == '-' && $sql_len > $i + 2 && $sql[$i + 1] == '-' && $sql[$i + 2] <= ' ') || $char == '#' || ($char == '/' && $sql_len > $i + 1 && $sql[$i + 1] == '*')) {
            $end = strpos($sql, $char == '/' ? '*/' : "\n", $i);
            // didn't we hit end of string?
            if ($end === FALSE) {
                echo 'didn\'t we hit end of string?';
                break;
            }
            //var_dump($sql);
            //echo '--';
            //var_dump($i);
            //var_dump($end);
            $oldsql = $sql;
            $sql = '';
            if ($i > 0)
                $sql = substr($oldsql, 0, $i);
            $sql .= substr($oldsql, $end+1);
            //if ($char == '/') {
                //$i++;// = $i - $end + 1;
            //}
            //var_dump($sql);
            $i--;
            //var_dump(substr($sql, 0, 50));
            $sql_len = strlen($sql);
            //exit();
        }

        // We are not in a string, first check for delimiter...
        elseif ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            if (!$nothing) {
                $ret[]      = trim(substr($sql, 0, $i));
            }
            $nothing    = TRUE;
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return $ret;
            }
        } // end elseif (is delimiter)

        // ... then check for start of a string,...
        elseif (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $nothing      = FALSE;
            $string_start = $char;
        } // end elseif (is start of string)

        elseif ($nothing) {
            $nothing = FALSE;
        }

        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1     = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && preg_match('@[^[:space:]]+@', $sql)) {
        $ret[] = $sql;
    }

    return $ret;
} // end of the 'PMA_splitSqlFile()' function


?>
