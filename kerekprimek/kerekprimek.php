<?php
ini_set('memory_limit', '250M');
ini_set('display_errors', 1);
ini_set('default_charset', 'utf-8');
define('ELEMENTS', 1000000);

// Eratoszthenész szitájának algoritmusát használom a prímszámok megállapításához
function find_primes($finish) { 
  $number = 2;
  $range = range(2, $finish);
  // a prímszámok kulcsai és értékei meg fognak egyezni, a későbbiekben hasznát vesszük.
  $primes = array_combine($range, $range);

  while ($number*$number < $finish) {
    for ($i = $number; $i <= $finish; $i += $number) {
      if ($i == $number) {
        continue;
      }
      unset($primes[$i]);
    }
    $number = next($primes);
  }
  return $primes;
}

function find_circular_primes($primes) {
	$circuralPrimes = array();

	foreach($primes as $key => $number) {
		$numberList = array();
		//az aktuális prímet sztringgé kasztoljuk és megállapítjuk a számjegyek számát
		$stringNumber = (string)$number;
		$stringLength = strlen($stringNumber);
		array_push($numberList, $number);

		/*
		 * az aktuális prím sztringgé kasztolt változó hosszúságáig elszámolunk, és minden ciklusban a második karakterétől (számjegytől) az utolsó karakterig (számjegyig)
		 * kivágjuk a sztingrészletet és a $modNumber változóba tesszük, majd az első számjegyet a $modNumber végére tesszük, így forgatjuk a számjegyeket, az összes "változatot"
		 * pedig egy tömbbe tesszük egész számként kasztolva.
		 */
		for($i=0;$i<$stringLength-1;$i++) {
			$modNumber = substr($stringNumber, 1, $stringLength);
			$modNumber .= $stringNumber[0];
			array_push($numberList, (int)$modNumber);
			$stringNumber = $modNumber;
		}

		/* 
		 * a tömb elemeiről megállapítjuk, hogy mind prímszámok-e? Ehhez felhasználjuk, hogy a tömb kulcsai és értékei megegyeznek, így isset-el végezhetjük a megállapítást, 
		 * amely gyorsabb mint pl. az in_array, vagy array_instersect függvények.
		 **/
		$iscircular = true;
		foreach($numberList as $value) {
			if(!isset($primes[$value])) {
				$iscircular = false;				
				break;				
			}
		}

		// az aktuális prímszámot kivágjuk a prímszámokat tartalmazó tömbből
		unset($primes[$key]);

		// ha az aktuális prímszám és forgatott változatai is prímszámok, akkor elmentjük őket a $circualPrimes tömbben. (a 11 prímszám miatt kell két plusz sor hack.)
		if($iscircular == true) {
			foreach($numberList as $value) {				
				if (isset($previous) && ($value == $previous))
					break;
				array_push($circuralPrimes, $value);
				$previous = $value;
			}
		}
	}
	return $circuralPrimes;
}

$start = microtime(true);
$primeNumbers = find_primes(ELEMENTS);
$time_elapsed = microtime(true) - $start;

echo '<p>Vizsgált elemszám: ' . number_format(ELEMENTS) . '</p>';

echo '<p>Összes prímszám megállapításának ideje: ' . $time_elapsed . ' másodperc<br>
Összes prímszám: ' . count($primeNumbers) . ' db</p>';
//var_dump($primeNumbers);

$start = microtime(true);
$circularPrimeNumbers = find_circular_primes($primeNumbers);
$time_elapsed_us = microtime(true) - $start;

echo '<p>Kerek prímszámok megállapításának ideje: ' . $time_elapsed_us . ' másodperc<br>
Kerek prímszámok: ' . count($circularPrimeNumbers) . ' db</p>';
//var_dump($circularPrimeNumbers);

?>