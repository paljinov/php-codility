<?php

/*
An integer M and a non-empty zero-indexed array A consisting of N non-negative integers are given. 
All integers in array A are less than or equal to M.

A pair of integers (P, Q), such that 0 ≤ P ≤ Q < N, is called a slice of array A. The slice 
consists of the elements A[P], A[P + 1], ..., A[Q]. A distinct slice is a slice consisting of
only unique numbers. That is, no individual number occurs more than once in the slice.

For example, consider integer M = 6 and array A such that:

    A[0] = 3
    A[1] = 4
    A[2] = 5
    A[3] = 5
    A[4] = 2

There are exactly nine distinct slices: 
(0, 0), (0, 1), (0, 2), (1, 1), (1, 2), (2, 2), (3, 3), (3, 4) and (4, 4).

The goal is to calculate the number of distinct slices.

Write a function:

    function solution($M, $A);

that, given an integer M and a non-empty zero-indexed array A consisting of N integers, 
returns the number of distinct slices.

If the number of distinct slices is greater than 1,000,000,000, 
the function should return 1,000,000,000.

For example, given integer M = 6 and array A such that:

    A[0] = 3
    A[1] = 4
    A[2] = 5
    A[3] = 5
    A[4] = 2

the function should return 9, as explained above.

Assume that:
        N is an integer within the range [1..100,000];
        M is an integer within the range [0..100,000];
        each element of array A is an integer within the range [0..M].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(M), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoUJARC9-97U/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($M, $A) 
{
	// $M is excess data, we are not going to use it

	$N = count($A);
	$maxDistinctSlicesLimit = 1000000000;
	$distinctIntegersSlice = array();
	$distinctSlices = 0;

	// caterpillar back position
	$back = 0;
	for($i = 0; $i < count($A); $i++) 
	{
		// if integer is unique
		if(!isset($distinctIntegersSlice[$A[$i]]))
			$distinctIntegersSlice[$A[$i]] = $i;
		// if integer is duplicate
		else 
		{
			// array slice duplicate first position
			$duplicateFirstIndex = $distinctIntegersSlice[$A[$i]];
			// caterpillar front position
			$front = $duplicateFirstIndex + 1;

			// number of distinct slices reminds to Gauss formula, n * (n + 1) / 2,
			// but it is little changed to solve duplication problem
			$distinctSlices += ($front - $back) * ($i - $back + $i - $front + 1) / 2;

			// cleaning distinct slice integers which will be left behind caterpillar movement
			for($j = $back; $j < $front; $j++)
				unset($distinctIntegersSlice[$A[$j]]);

			// we add new integer, as we cleaned $distinctIntegersSlice array, 
			// it is not duplicated integer any more
			$distinctIntegersSlice[$A[$i]] = $i;
			// caterpillar movement
			$back = $front;
		}
	}
	// adding last distinct slices, which come after integer that was last duplicated integer
	$distinctSlices += ($N - $back) * ($N - $back + 1) / 2;

	// if the number of distinct slices is greater than 1,000,000,000, 
	// the function should return 1,000,000,000
	if($distinctSlices > $maxDistinctSlicesLimit) 
		$distinctSlices = $maxDistinctSlicesLimit;

	return $distinctSlices;
}