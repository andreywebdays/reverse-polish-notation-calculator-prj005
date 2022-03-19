<?php

function calculatePolishNotation($expression)
{
    $result = 0;
    
    $vals_original = explode(' ', $expression);

    $vals_temp = array();
    
    $opers = array('+', '-', '*', '/');

    $opers_count = 0;
    
    // count how many calculations needed (# of operators)
    for ($i = 0; $i < count($vals_original); $i++) {
        if (in_array($vals_original[$i], $opers)) {
            $opers_count++;
        }
    }
    
    // check if there are any operators in the expression
    if ($opers_count > 0) {
        
        // calculations
        for ($o = 0; $o < $opers_count; $o++) {        
            for ($i = 0; $i < count($vals_original); $i++) {
                if (in_array($vals_original[$i], $opers)) {

                    // check if there are at least 2 numbers before the operator
                    if ($i > 1) {
                        
                        // counters for numbers search
                        $n_1 = 1;
                        $n_2 = 1;

                        // find first (nearest) number to operator from the left
                        while ($n_2 < $i + 2) {
                            if (in_array($vals_original[$i-$n_2], $opers)) {
                                $n_2++;
                                $num_2 = '';
                            } else {
                                $num_2 = $vals_original[$i-$n_2];

                                // find second number from operator from the left
                                if (in_array($vals_original[$i-$n_2-$n_1], $opers)) {
                                    $n_1++;
                                    $num_1 = '';
                                } else {
                                    $num_1 = $vals_original[$i-$n_2-$n_1];

                                    // choose operator for calculation
                                    switch ($vals_original[$i]) {
                                        case '+':
                                            $result = $num_1 + $num_2;
                                            break;
                                        case '-':
                                            $result = $num_1 - $num_2;
                                            break;
                                        case '*':
                                            $result = $num_1 * $num_2;
                                            break;
                                        case '/':
                                            $result = $num_1 / $num_2;
                                            break;
                                    }
                                    
                                    // push unused elements before the calculation to new array 
                                    if ($i-$n_2-$n_1 > 0) {
                                        for ($b = 0; $b < $i-$n_2-$n_1; $b++) {
                                            array_push($vals_temp, $vals_original[$b]);
                                        }
                                    }

                                    // push the result from current calculation to the array
                                    array_push($vals_temp, $result);

                                    // push unused elements after the calculation to new array
                                    if ($i-$n_2-$n_1 < count($vals_original)) {
                                        for ($a = $i+1; $a < count($vals_original); $a++) {
                                            array_push($vals_temp, $vals_original[$a]);
                                        }
                                    }
                                    break;
                                }
                            }
                        }          
                    } else {
                        return "This expression doesn't have enough numbers before the operator!";
                    }
                    break;
                }
            }
            
            // prepare original array for the next calculation and empty the temporary array
            $vals_original = array();
            $vals_original = $vals_temp;
            $vals_temp = array();
        }
        
        // return final result if the expression is valid
        return $vals_original[0];
    } else {
        return "There are no operators in this expression!";
    }
}

echo calculatePolishNotation('5 1 2 + 4 * + 3 -') . " should equal to 14" . '<br>';
echo calculatePolishNotation('2 1 9 3 / - + ') . " should equal to 0" . '<br>';
echo calculatePolishNotation('5 5 3') . '<br>';
echo calculatePolishNotation('2 / 12') . '<br>';
echo calculatePolishNotation('+') . '<br>';