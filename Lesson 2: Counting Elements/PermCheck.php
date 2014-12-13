<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.

A permutation is a sequence containing each element from 1 to N once, and only once.

For example, array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3
    A[3] = 2

is a permutation, but array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3

is not a permutation, because value 2 is missing.

The goal is to check whether array A is a permutation.

Write a function:

    function solution($A); 

that, given a zero-indexed array A, returns 1 if array A is a permutation and 0 if it is not.

For example, given array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3
    A[3] = 2

the function should return 1.

Given array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3

the function should return 0.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: 
 * https://codility.com/demo/results/demoVWUWBQ-UUP/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// this task can be partialy solved by using Gauss sum formula for positive consecutive integers,
	// also known as PERMUATION number array
	// sum = (N * (N + 1)) / 2, where N is count of positive consecutive integers
	// for example, sum of 1 + 2 + 3 + 4 + 5 = (5 * (5 + 1)) / 2 = (5 * 6) / 2 = 30 / 2 = 15
	// according to legend, Gauss figured this out at the age of 8 during class in elementary school
	// 
	// integer has 32-bit or 64 bit, depending on PHP build and platform, and 32 bit is limitation 
	// for N * ($N + 1) when N = 100 000
	// 32-bit int max number: 2147483647
	// when N = 100 000, sum = 10000100000
	// so we must use float
	// http://php.net/manual/en/language.types.float.php
	// "The size of a float is platform-dependent, although a maximum of ~1.8e308 with a precision 
	// of roughly 14 decimal digits is a common value (the 64 bit IEEE format)."

	$N = count($A);
	$permutationSum = ((float)$N * ($N + 1)) / 2;
	$actualSum = array_sum($A);
	// if permuation sum does not match actual sum, we don't have permuation
	$diff = (int)($permutationSum - $actualSum);
	if($diff != 0)
		return 0;

	// now, [2, 2, 2, 4] gives the sum of 10, like [1 2 3 4], 
	// but first array is not permuationt, and second one is, so we check that all numbers are unique
	$uniqueA = array();
	foreach($A as $key => $number) 
	{
		if(empty($uniqueA[$number]))
			$uniqueA[$number] = 1;
		// if number is repeated
		else
			return 0;
	}

	return 1;
}