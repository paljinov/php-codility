<?php

/*
You have to climb up a ladder. The ladder has exactly N rungs, numbered from 1 to N. 
With each step, you can ascend by one or two rungs. More precisely:

        with your first step you can stand on rung 1 or 2,
        if you are on rung K, you can move to rungs K + 1 or K + 2,
        finally you have to stand on rung N.

Your task is to count the number of different ways of climbing to the top of the ladder.

For example, given N = 4, you have five different ways of climbing, ascending by:

        1, 1, 1 and 1 rung,
        1, 1 and 2 rungs,
        1, 2 and 1 rung,
        2, 1 and 1 rungs, and
        2 and 2 rungs.

Given N = 5, you have eight different ways of climbing, ascending by:

        1, 1, 1, 1 and 1 rung,
        1, 1, 1 and 2 rungs,
        1, 1, 2 and 1 rung,
        1, 2, 1 and 1 rung,
        1, 2 and 2 rungs,
        2, 1, 1 and 1 rungs,
        2, 1 and 2 rungs, and
        2, 2 and 1 rung.

The number of different ways can be very large, so it is sufficient to return the result modulo 2^P, 
for a given integer P.

Write a function:

    function solution($A, $B); 

that, given two non-empty zero-indexed arrays A and B of L integers, returns an array consisting 
of L integers specifying the consecutive answers; position I should contain the number of different 
ways of climbing the ladder with A[I] rungs modulo 2^B[I].

For example, given L = 5 and:

    A[0] = 4   B[0] = 3
    A[1] = 4   B[1] = 2
    A[2] = 5   B[2] = 4
    A[3] = 5   B[3] = 3
    A[4] = 1   B[4] = 1

the function should return the sequence [5, 1, 8, 0, 1], as explained above.

Assume that:
        L is an integer within the range [1..30,000];
        each element of array A is an integer within the range [1..L];
        each element of array B is an integer within the range [1..30].

Complexity:
        expected worst-case time complexity is O(L);
        expected worst-case space complexity is O(L), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo75V3WS-B6P/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	25%
 * Task score:	62%
 */
function solution($A, $B)
{
	$L = count($A);
	// number of different ways of climbing to the top of the ladder in the form of modulo 2B
	$combinationsModulo = array();

	for($i = 0; $i < $L; $i++)
	{
		$modulo = pow(2, $B[$i]);
		$combinationsModulo[$i] = getClimbCombinationsModulo($A[$i], $modulo);
	}

	return $combinationsModulo;
}

/**
 * Number of different ways of climbing to the top of the ladder show in division by modulo form. 
 * Result is returned in (fibonaci % modulo 2^P form), because Fibonacci of L can be extremely large,
 * and thereby impossible to calculate result in natural way.
 * 
 * @param int $rungs Number of rungs
 * @param int $modulo Modulo which is used to show number of combinations
 * 
 * @return int
 */
function getClimbCombinationsModulo($rungs, $modulo)
{
	if($rungs === 0)
		$climbCombinationsModulo = 0;
	elseif($rungs === 1)
		$climbCombinationsModulo = 1;
	else
	{
		$fibModulo = array();
		$fibModulo[0] = 0;
		$fibModulo[1] = 1;
		$i = 2;
		// the most important thing is to understand that the number of different ways 
		// of climbing to the top of the ladder is Fibonacci(N+1)
		while($i <= $rungs + 1)
		{ 
			$fibModulo[$i] = ($fibModulo[$i-1] + $fibModulo[$i-2]) % $modulo;
			$i++;
		}
		$climbCombinationsModulo = $fibModulo[count($fibModulo) - 1];
	}

	return $climbCombinationsModulo;
}