<?php

/*
Let A be a non-empty zero-indexed array consisting of N integers.

The abs sum of two for a pair of indices (P, Q) is the absolute value |A[P] + A[Q]|, 
for 0 ≤ P ≤ Q < N.

For example, the following array A:

  A[0] =  1
  A[1] =  4
  A[2] = -3

has pairs of indices (0, 0), (0, 1), (0, 2), (1, 1), (1, 2), (2, 2).
The abs sum of two for the pair (0, 0) is A[0] + A[0] = |1 + 1| = 2.
The abs sum of two for the pair (0, 1) is A[0] + A[1] = |1 + 4| = 5.
The abs sum of two for the pair (0, 2) is A[0] + A[2] = |1 + (−3)| = 2.
The abs sum of two for the pair (1, 1) is A[1] + A[1] = |4 + 4| = 8.
The abs sum of two for the pair (1, 2) is A[1] + A[2] = |4 + (−3)| = 1.
The abs sum of two for the pair (2, 2) is A[2] + A[2] = |(−3) + (−3)| = 6.

Write a function:

    function solution($A); 

that, given a non-empty zero-indexed array A consisting of N integers, 
returns the minimal abs sum of two for any pair of indices in this array.

For example, given the following array A:

  A[0] =  1
  A[1] =  4
  A[2] = -3

the function should return 1, as explained above.

Given array A:

  A[0] = -8
  A[1] =  4
  A[2] =  5
  A[3] =-10
  A[4] =  3

the function should return |(−8) + 5| = 3.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [−1,000,000,000..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoGT3STA-W6M/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// sorting array $A from lowest to highest integer
	sort($A);
	$minAbsSum = null;

	// starting position initialization
	$i = 0;
	// ending position initialization
	$j = count($A) - 1;

	// we are searching for smallest absolute pair sum
	while($i <= $j) 
	{
		$sum = $A[$i] + $A[$j];
		$absSum = abs($sum);
		if($minAbsSum === null || $absSum < $minAbsSum)
			$minAbsSum = $absSum;

		// 0 is smallest absolute minimum pair sum we can get, therefore we strive to 0
		// if sum is equal to zero, that is the smallest value possible, so we break loop
		if($sum === 0)
			break;
		// if sum is lower than zero, we increase $i to get higher sum, closer to zero
		elseif($sum < 0)
			$i++;
		// if sum is higher than zero, we decrease $j to get lower sum, closer to zero
		else 
			$j--;
	}

	return $minAbsSum;
}