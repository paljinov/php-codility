<?php

/*
Given an array A of N integers, we draw N discs in a 2D plane such that 
the I-th disc is centered on (0,I) and has a radius of A[I]. 
We say that the J-th disc and K-th disc intersect if J ≠ K and J-th and K-th discs 
have at least one common point.

Write a function:

    function solution($A); 

that, given an array A describing N discs as explained above, 
returns the number of pairs of intersecting discs. For example, given N=6 and:

    A[0] = 1  A[1] = 5  A[2] = 2 
    A[3] = 1  A[4] = 4  A[5] = 0  

intersecting discs appear in eleven pairs of elements:

        0 and 1,
        0 and 2,
        0 and 4,
        1 and 2,
        1 and 3,
        1 and 4,
        1 and 5,
        2 and 3,
        2 and 4,
        3 and 4,
        4 and 5.

so the function should return 11.

The function should return −1 if the number of intersecting pairs exceeds 10,000,000.

Assume that:
        N is an integer within the range [0..100,000];
        each element of array A is an integer within the range [0..2147483647].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoKUH84U-XJE/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A) 
{
	// all discs are on x=0 axis of coordinate system, only y position is growing

	// number of intersecting discs
	$intersectingDiscs = 0;
	// number of discs started at some position
	$dsp = array_fill(0, count($A), 0);
	// number of discs ended at some position
	$dep = array_fill(0, count($A), 0);

	for($i = 0; $i < count($A); $i++)
	{
		// indexes are staying in [0, N-1] domain

		// disc started position index
		$dspIndex = max(0, $i - $A[$i]);
		// disc end position index
		$depIndex = min(count($A) - 1, $i + $A[$i]);

		// number of discs started at some position
		$dsp[$dspIndex]++;
		// number of discs ended at some position
		$dep[$depIndex]++;
	}

	// current discs at each position (which are started, but not yet ended)
	$currentDiscs = 0;
	// iterating through positions, [0, N-1] domain 
	for($i = 0; $i < count($A); $i++)
	{
		// if there are discs which start at this position
		if($dsp[$i] > 0)
		{
			// current discs multiplied by count of discs which started at position $i
			$intersectingDiscs += $currentDiscs * $dsp[$i];
			// intersections of already started discs
			// Gauss sum formula n(n + 1)/2, where n = $dsp[$i] - 1, which leads to: 
			// ($dsp[$i] - 1) * [($dsp[$i] - 1) + 1] / 2 => $dsp[$i] * ($dsp[$i] - 1) / 2
			$intersectingDiscs += $dsp[$i] * ($dsp[$i] - 1) / 2;

			// if the number of intersecting pairs exceeds 10,000,000 
			if($intersectingDiscs > 10000000)
				return -1;
			
			// discs started at this position
			$currentDiscs += $dsp[$i];
		}
		// discs ended at this position
		$currentDiscs -= $dep[$i];
	}

	return $intersectingDiscs;
}