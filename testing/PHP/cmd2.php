<?php
                set_include_path(".;c:\\programme\\php5\\pear");
                @include_once 'ezc/Base/base.php';
                @include_once 'Base/base.php';
                function __autoload( $className ) { ezcBase::autoload( $className ); }
                require_once "c:\\programme\\php5\\PEAR\\ezc\\CodeAnalyzer\\code_analyzer.php";

                //ob_start();
                $out = serialize(iscCodeAnalyzer::summarizeFile('D:/p/sst/WebP/metric-study/xoops-2.0.15/htdocs/install/class/cachemanager.php'));
                //ob_end_clean();
                echo '#-#-#-#-#';
                echo $out;
                echo '#-#-#-#-#';
            ?>