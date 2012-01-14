<?php
/**
 * Validates a vehicle identification number against the ISO 3779 standard.
 * 
 * 1M8GDM9AXKP042788 is a valid VIN (used for testing).
 * 
 * @see https://github.com/ramaboo/is_vin
 * @see http://en.wikipedia.org/wiki/Vehicle_identification_number
 * 
 * @param string $vin The vehicle identification number.
 * 
 * @return bool Returns TRUE if the vehicle identification number is valid, FALSE otherwise.
 * 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2008-2012 David Singer
 * @author David Singer <david@ramaboo.com>
 * @version 1.1.5
 * 
 * @code
 * if (is_vin('1M8GDM9AXKP042788')) {
 * 	echo 'valid';
 * } else {
 * 	echo 'not valid';
 * }
 * @endcode
 * 
 * @todo Test and support ISO 3780.
 */
function is_vin($vin) {
	$vin = strtoupper(trim($vin));
	
	// check VIN length
	if (strlen($vin) != 17) {
		// error VIN is not 17 characters long
		return false;
	}
	
	// setup array of letter values
	$value['A'] = 1;
	$value['B'] = 2;
	$value['C'] = 3;
	$value['D'] = 4;
	$value['E'] = 5;
	$value['F'] = 6;
	$value['G'] = 7;
	$value['H'] = 8;
	$value['J'] = 1;
	$value['K'] = 2;
	$value['L'] = 3;
	$value['M'] = 4;
	$value['N'] = 5;
	$value['P'] = 7;
	$value['R'] = 9;
	$value['S'] = 2;
	$value['T'] = 3;
	$value['U'] = 4;
	$value['V'] = 5;
	$value['W'] = 6;
	$value['X'] = 7;
	$value['Y'] = 8;
	$value['Z'] = 9;
	
	// setup digit weights
	$weight[0] = 8; // 1st position
	$weight[1] = 7;
	$weight[2] = 6;
	$weight[3] = 5;
	$weight[4] = 4;
	$weight[5] = 3;
	$weight[6] = 2;
	$weight[7] = 10;
	$weight[8] = 0; // 9th position, this is the check digit
	$weight[9] = 9;
	$weight[10] = 8;
	$weight[11] = 7;
	$weight[12] = 6;
	$weight[13] = 5;
	$weight[14] = 4;
	$weight[15] = 3;
	$weight[16] = 2; // 17th position
	
	$char = str_split($vin); // split string into character array
	$total = 0;
	
	// loop though each character of the vin
	for ($i = 0; $i < 17; $i++) {
		if (is_numeric($char[$i])) {
			// use number
			// update total
			$total = $total + ($char[$i] * $weight[$i]);
		} elseif (array_key_exists($char[$i], $value)) {
			// use value of letter
			// update total
			$total = $total + ($value[$char[$i]] * $weight[$i]);
		} else {
			// error illegal character used
			return false;
		}
	}
	
	$mod = $total % 11; // find remainder after dividing by 11
	
	// if mod is 10 set the check_digit to X
	if ($mod == 10) {
		$checkDigit = 'X';
	} else {
		$checkDigit = $mod;
	}
	
	// check if the 9th character in the string (the check digit) equals the calculated value
	if ($char[8] == $checkDigit) { 
		// VIN is valid
		return true;
	} else {
		// VIN is not valid
		return false;
	}
}
