<?php

/*
Write a function:

    function solution($A, $B, $K); 

that, given three integers A, B and K, 
returns the number of integers within the range [A..B] that are divisible by K, i.e.:

    { i : A ≤ i ≤ B, i mod K = 0 }

For example, for A = 6, B = 11 and K = 2, your function should return 3, 
because there are three numbers divisible by 2 within the range [6..11], namely 6, 8 and 10.

Assume that:
        A and B are integers within the range [0..2,000,000,000];
        K is an integer within the range [1..2,000,000,000];
        A ≤ B.

Complexity:
        expected worst-case time complexity is O(1);
        expected worst-case space complexity is O(1).
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoVHF97C-DJF/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A, $B, $K)
{
	// divisible integers count
	$divisibleIntegers = 0;
	// number of divisible integers by K from 0 to A
	$divisibleToLimitA = floor($A / $K);
	// number of divisible integers by K from 0 to B
	$divisibleToLimitB = floor($B / $K);

 	// if A is divisible by K
	if($A % $K === 0)
		$divisibleIntegers = $divisibleToLimitB - $divisibleToLimitA + 1;
	// if A is not divisible by K
	else
		$divisibleIntegers = $divisibleToLimitB - $divisibleToLimitA;

	return (int)$divisibleIntegers;
}