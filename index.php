<?php

setlocale(LC_CTYPE, 'en_US.UTF-8');
//date_default_timezone_set ('Etc/GMT-9');

$debug_message = '';
$error_message = '';
$output = '';

$pwd = $_ENV["PWD"];
//$pwd = dirname (__FILE__);
//$data_dir = dirname (__FILE__) . '/d';

function error ($message)
{
	global $error_message;

	$error_message .= $message.'<br />';
}

function debug ($message)
{
	global $debug_message;

	$debug_message .= $message.'<br />';
}

function error_handler($errno, $errstr, $errfile, $errline)
{
	$errortype = array (
		E_ERROR              => 'Error',
		E_WARNING            => 'Warning',
		E_PARSE              => 'Parsing Error',
		E_NOTICE             => 'Notice',
		E_CORE_ERROR         => 'Core Error',
		E_CORE_WARNING       => 'Core Warning',
		E_COMPILE_ERROR      => 'Compile Error',
		E_COMPILE_WARNING    => 'Compile Warning',
		E_USER_ERROR         => 'User Error',
		E_USER_WARNING       => 'User Warning',
		E_USER_NOTICE        => 'User Notice',
		E_STRICT             => 'Runtime Notice',
		E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
	);

	error ($errfile.':'.$errline.': '.'['.$errortype[$errno].'('.$errno.')] '.$errstr);

	return false;
}

// set to the user defined error handler
$old_error_handler = set_error_handler("error_handler");

function l($disp, $addr, $args=array())
{
	$ret = '<a href="'.$addr;

	if (count ($args))
	{
		$ret .= '?';
		foreach ($args as $name => $value)
			$ret .= $name.'='.$value.'&';
	}

	$ret .= '">'.$disp.'</a>';

	return $ret;
}

if (isset ($_REQUEST['do']))
        $do = $_REQUEST['do'];
else
        $do = "nothing";
$args = explode ("/", $do);

$output .= "do : \"$do\"";
$output .= "args : " . print_r ($args, TRUE);

//if ($get_src)
if (0)
{
	header('Content-Type: document/text');
	header('Content-Disposition: inline; filename=phpftp.php');
	header('Content-Length: ' . filesize(__FILE__));
	readfile (__FILE__);
	exit (0);
}

if (isset ($output) || isset ($debug_message) || isset ($error_message))
{
	echo '<html><head>';
	echo '<meta name="viewport" ';
	echo 'content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />';
	echo '<style type="text/css">';
	echo 'td.list_size { text-align: right; }';
	echo 'table { border-collapse: collapse; }';
	echo 'table tr td { border: 1px solid black; }';
	echo '</style>';
	echo '</head><body>';

	if ($error_message != '')
	{
		echo '<div id="error">', $error_message, '</div>';
	}

	if ($debug_message != '')
	{
		echo '<div id="debug">', $debug_message, '</div>';
	}

	if (isset ($output))
		echo $output;

	echo '</body></html>';
}

?>
