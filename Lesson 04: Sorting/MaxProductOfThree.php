<?php

/*
A non-empty zero-indexed array A consisting of N integers is given. 
The product of triplet (P, Q, R) equates to A[P] * A[Q] * A[R] (0 ≤ P < Q < R < N).

For example, array A such that:

  A[0] = -3
  A[1] = 1
  A[2] = 2
  A[3] = -2
  A[4] = 5
  A[5] = 6

contains the following example triplets:

        (0, 1, 2), product is −3 * 1 * 2 = −6
        (1, 2, 4), product is 1 * 2 * 5 = 10
        (2, 4, 5), product is 2 * 5 * 6 = 60

Your goal is to find the maximal product of any triplet.

Write a function:

    function solution($A); 

that, given a non-empty zero-indexed array A, returns the value of the maximal product of any triplet.

For example, given array A such that:

  A[0] = -3
  A[1] = 1
  A[2] = 2
  A[3] = -2
  A[4] = 5
  A[5] = 6

the function should return 60, as the product of triplet (2, 4, 5) is maximal.

Assume that:
        N is an integer within the range [3..100,000];
        each element of array A is an integer within the range [−1,000..1,000].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(1), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo6UCFTP-HV7/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A) 
{
	// first, array $A is sorted ascending from minimum to maximum integer
	sort($A);

	// 2 smallest negative integers (two biggest absolute negative integers)
	$min2Negative = array();
	// 3 biggest negative integers (three smallest absolute negative integers)
	$max3Negative = array();
	// 3 biggest positive integers, 0 which is neutral number is also included
	$max3PositiveInclZero = array();

	// if there are at least 3 positive integers, we get 3 biggest
	for($i = count($A) - 1; $i >= count($A) - 3; $i--)
		if($A[$i] >= 0)
			$max3PositiveInclZero[] = $A[$i];

	// if there are no positive integers, we get 3 biggest negative integers
	if(count($max3PositiveInclZero) === 0)
	{
		for($i = count($A) - 1; $i >= count($A) - 3; $i--)
			if($A[$i] < 0)
				$max3PositiveInclZero[] = $A[$i];
	}
	// if there are positive integers, we get 2 smallest negative integers
	else
	{
		for($i = 0; $i <= 1; $i++) 
			if($A[$i] < 0)
				$min2Negative[] = $A[$i];
	}

	// maximal product of any triplet
	$maxProduct = null;
	// array which contains all relevant integers for maximal product of triplets combinations
	$r = array_merge($min2Negative, $max3Negative, $max3PositiveInclZero);
	for($i = 0; $i < count($r); $i++)
		for($j = $i + 1; $j < count($r); $j++)
			for($k = $j + 1; $k < count($r); $k++)
			{
				$currentProduct = $r[$i] * $r[$j] * $r[$k];
				if(empty($maxProduct) || $currentProduct > $maxProduct)
					$maxProduct = $currentProduct;
			}

	return $maxProduct;
}