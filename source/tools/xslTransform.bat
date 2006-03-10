@echo off
REM Define php cli path
IF DEFINED PHP_PEAR_PHP_BIN (
	SET PHPEXE=%PHP_PEAR_PHP_BIN% -c %PHP_PEAR_BIN_DIR%
) ELSE (
	SET PHPEXE=c:\Programme\php5\php.exe -c c:\Programme\php5
)

REM run script
%PHPEXE% xslTransform.php %*