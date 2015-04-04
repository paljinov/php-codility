<?php

/*
For a given array A of N integers and a sequence S of N integers from the set {−1, 1},
we define val(A, S) as follows:

    val(A, S) = |sum{ A[i]*S[i] for i = 0..N−1 }|

(Assume that the sum of zero elements equals zero.)

For a given array A, we are looking for such a sequence S that minimizes val(A,S).

Write a function:

    function solution($A);

that, given an array A of N integers, computes the minimum value of val(A,S) from all possible values
of val(A,S) for all possible sequences S of N integers from the set {−1, 1}.

For example, given array:

  A[0] =  1
  A[1] =  5
  A[2] =  2
  A[3] = -2

your function should return 0, since for S = [−1, 1, −1, 1], val(A, S) = 0, which is the minimum possible value.

Assume that:
        N is an integer within the range [0..20,000];
        each element of array A is an integer within the range [−100..100].

Complexity:
        expected worst-case time complexity is O(N*max(abs(A))^2);
        expected worst-case space complexity is O(N+sum(abs(A))),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoTQGDS8-DF6/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// https://codility.com/media/train/solution-min-abs-sum.pdf

	$N = count($A);
	// making all array $A values positive (absolute)
	for($i = 0; $i < $N; $i++)
		$A[$i] = abs($A[$i]);

	// maximum absolute array $A value
	$M = max($A);
	// sum of all absolute array $A values
	$sum = array_sum($A);

	// number of times some absolute integer value appeared
	$occurrenceCount = array();
	for($i = 0; $i < $N; $i++)
		if(!isset($occurrenceCount[$A[$i]]))
			$occurrenceCount[$A[$i]] = 1;
		else
			$occurrenceCount[$A[$i]] += 1;

	// dp[$j] denotes how many values [$i] remain (maximally) after achieving sum [$j]
	$dp = array();
	$dp[0] = 0;
	// iterating from 1 to maximum absolute array $A value
	for($i = 1; $i <= $M; $i++)
	{
		// if this absolute integer exist
		if(isset($occurrenceCount[$i]))
		{
			for($j = 0; $j < $sum; $j++)
			{
				// if the previous value at $dp[$j] >= 0 then we can set
				// $dp[$j] = $occurrenceCount[$i] as no value $i is needed to obtain the sum
				if(isset($dp[$j]) && $dp[$j] >= 0)
					$dp[$j] = $occurrenceCount[$i];
				// otherwise we must obtain sum $j − $i first and then use a number $i to get sum $j
				elseif($j >= $i && isset($dp[$j - $i]) && $dp[$j - $i] > 0)
					$dp[$j] = $dp[$j - $i] - 1;
			}
		}
	}

	$result = $sum;
	// we choose the best sum value (closest to half of $sum)
	for($j = 0; $j < (int)($sum / 2) + 1; $j++)
		if(isset($dp[$j]) && $dp[$j] >= 0)
			$result = min($result, $sum - 2 * $j);

	return $result;
}