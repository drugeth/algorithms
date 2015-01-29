<?php
ini_set('display_errors', 1);
ini_set('default_charset', 'utf-8');

$loremipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed imperdiet orci ut erat elementum mollis.
Morbi quis dolor ipsum, sit amet sagittis urna. Sed ullamcorper lacinia elit nec mollis. Vestibulum nec
magna velit, ac porttitor nisl. Nulla in venenatis risus. Phasellus a nisl nulla, id condimentum nibh.
Donec eget eros id eros cursus viverra. Maecenas et adipiscing velit. Proin porta placerat vulputate.
Duis varius erat eget lorem pellentesque rhoncus. Mauris vehicula interdum mauris, in sodales metus
aliquam ac. Etiam ac porttitor quam. Vivamus venenatis quam molestie mi ultrices a laoreet enim
faucibus.';

$wordCounter = array();

function mostFrequentWord($text) {
	global $wordCounter;
	$text = str_replace(',', '', str_replace('.', '', trim(preg_replace('/\s+/', ' ', $text))));
	$words = explode(' ', $text);

	foreach($words as $key => $value) {
		if (isset($wordCounter[$value]))
			$wordCounter[$value]++;
		else
			$wordCounter[$value] = 1;
	}

	$wordCounter = array_diff($wordCounter, [1]);

	arsort($wordCounter, SORT_NUMERIC);

	reset($wordCounter);
	return key($wordCounter);
}

function mostFrequentExpression($topWord) {
	global $wordCounter;
	global $loremipsum;
	$expressions = array();

	foreach($wordCounter as $key => $value) {
		preg_match_all("/($topWord){1} {1}$key{1}/", $loremipsum, $matches);
		if(!empty($matches[0])) {
			$maxIndex = count($expressions);
			$expressions[$maxIndex]['expression'] = $matches[0][0];
			$expressions[$maxIndex]['count'] = count($matches[0]);
		}

		preg_match_all("/$key{1} {1}($topWord){1}/", $loremipsum, $matches);
		if(!empty($matches[0])){
			$maxIndex = count($expressions);
			$expressions[count($maxIndex)]['expression'] = $matches[0][0];
			$expressions[count($maxIndex)]['count'] = count($matches[0]);
		}
	}

	$maxIndex = 0;
	foreach($expressions as $key => $value) {
		if($value['count'] > $expressions[$maxIndex]['count'])
			$maxIndex = $key;
	}

	return $expressions[$maxIndex]['expression'];
}

$frequentWord = mostFrequentWord($loremipsum);
$frequentExpression = mostFrequentExpression($frequentWord);

echo '<p>' . nl2br($loremipsum) . '</p>';
echo '<p>Leggyakoribb szó: ' . $frequentWord . '</p>';
echo '<p>Leggyakoribb sztringrészlet: ' . $frequentExpression . '</p>';
?>