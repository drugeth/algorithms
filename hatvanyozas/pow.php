<?php
ini_set('display_errors', 1);
ini_set('default_charset', 'utf-8');
define('MYURL', $_SERVER['PHP_SELF']);

function mypow($exp) {
	$base = 2;

	if ($exp === 0)
		return 1;
	elseif ($exp >= 1)
		return $base * mypow($exp-1);
	elseif ($exp < 0)
		return 1 / ($base * mypow(abs($exp)-1));
}

if (isset($_GET['exponent']))
	echo '2<sup>' . $_GET['exponent'] . '</sup> = ' . mypow(intval($_GET['exponent'])) . '<br>';

	echo '<form method="GET" action="'.MYURL.'">
	<input type="text" name="exponent" placeholder="hatványkitevő">
	<button>Küldés!</button>
</form>';
?>