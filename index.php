<?php

function calculatePolishNotation($expression)
{
    $result = 0;
    
    $vals_original = explode(' ', $expression);

    $vals_new = array();
    
    $opers = array('+', '-', '*', '/');

    $opers_count = 0;
    
    for ($i = 0; $i < count($vals_original); $i++) {
        if (in_array($vals_original[$i], $opers)) {
            $opers_count++;
        }
    }
    
    for ($o = 0; $o < $opers_count; $o++) {        
        for ($i = 0; $i < count($vals_original); $i++) {
            if (in_array($vals_original[$i], $opers)) {
                $n_1 = 1;
                $n_2 = 1;

                while ($n_2 < $i + 2) {
                    if (in_array($vals_original[$i-$n_2], $opers)) {
                        $n_2++;
                        $num_2 = '';
                    } else {
                        $num_2 = $vals_original[$i-$n_2];

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
                                    array_push($vals_new, $vals_original[$b]);
                                }
                            }

                            // push the result from current calculation to the array
                            array_push($vals_new, $result);

                            // push unused elements after the calculation to new array
                            if ($i-$n_2-$n_1 < count($vals_original)) {
                                for ($a = $i+1; $a < count($vals_original); $a++) {
                                    array_push($vals_new, $vals_original[$a]);
                                }
                            }
                            break;
                        }
                    }
                }
                break;
            }
        }
        
        $vals_original = array();
        $vals_original = $vals_new;
        $vals_new = array();
        
    }

    return $vals_original[0];
}

echo calculatePolishNotation('5 1 2 + 4 * + 3 -');