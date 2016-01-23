<?php

/*
A zero-indexed array A consisting of N integers is given. Rotation of the array means
that each element is shifted right by one index, and the last element of the array is also moved to the first place.

For example, the rotation of array A = [3, 8, 9, 7, 6] is [6, 3, 8, 9, 7]. The goal is to rotate array A K times;
that is, each element of A will be shifted to the right by K indexes.

Write a function:

    function solution($A, $K);

that, given a zero-indexed array A consisting of N integers and an integer K, returns the array A rotated K times.

For example, given array A = [3, 8, 9, 7, 6] and K = 3, the function should return [9, 7, 6, 3, 8].

Assume that:
        N and K are integers within the range [0..100];
        each element of array A is an integer within the range [−1,000..1,000].

In your solution, focus on correctness. The performance of your solution will not be the focus of the assessment.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingFXT9YY-ATV/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance: not assessed
 * Task score:	100%
 */
function solution($A, $K)
{
	// shifted array
	$shifted = array();

	// number of elements
	$N = count($A);
	// if $K is bigger than $N, on $N-th shift we would be on starting position,
	// so it makes sense only to do smaller number of shifts than $N size
	$shiftedPositions = $K % $N;

	// initially first element position is 0, but at the end it will be K
	for($i = 0; $i < $N; $i++)
	{
		$position = $i + $shiftedPositions;
		if($position > $N - 1)
			$position = $position - $N;

		$shifted[$position] = $A[$i];
	}

	ksort($shifted);
	return $shifted;
}