<?php

/*
A zero-indexed array A consisting of N different integers is given. 
The array contains integers in the range [1..(N + 1)], which means that exactly one element is missing.

Your goal is to find that missing element.

Write a function:

    function solution($A); 

that, given a zero-indexed array A, returns the value of the missing element.

For example, given array A such that:

  A[0] = 2
  A[1] = 3
  A[2] = 1
  A[3] = 5

the function should return 4, as it is the missing element.

Assume that:
        N is an integer within the range [0..100,000];
        the elements of A are all distinct;
        each element of array A is an integer within the range [1..(N + 1)].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(1), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYIS: 
 * https://codility.com/demo/results/demoSBMTHA-TZN/
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A) 
{

	// this task can be easily solved by using Gauss sum formula for positive consecutive integers
	// sum = (N * (N + 1)) / 2
	// N => count of positive consecutive integers
	// for example, sum of 1 + 2 + 3 + 4 + 5 = (5 * (5 + 1)) / 2 = (5 * 6) / 2 = 30 / 2 = 15
	// according to legend, Gauss figured this out at the age of 8 during class in elementary school

	// we know all integers are positive and different, so when we add missing element we 
	// have Gauss formula
	
	// number of positive integers including missing one
	$N = count($A) + 1;

	// integer has 32-bit or 64 bit, depending on PHP build and platform, and 32 bit is limitation 
	// for N * ($N + 1) when N = 100 000
	// 32-bit int max number: 2147483647
	// when N = 100 000, sum = 10000100000
	// so we must use float
	// http://php.net/manual/en/language.types.float.php
	// "The size of a float is platform-dependent, although a maximum of ~1.8e308 with a precision 
	// of roughly 14 decimal digits is a common value (the 64 bit IEEE format)."
	$sumIncludingMissingNumber = ((float)$N * ($N + 1)) / 2;
	$sumWithoutMissingNumber = (float)0;
	foreach($A as $number) 
		$sumWithoutMissingNumber += $number;

	$missingNumber = (int)($sumIncludingMissingNumber - $sumWithoutMissingNumber);

	return $missingNumber;
}
