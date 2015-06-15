<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.

A peak is an array element which is larger than its neighbours. More precisely, it is an index P such that 
0 < P < N - 1 and A[P - 1] < A[P] > A[P + 1].

For example, the following array A:

    A[0] = 1
    A[1] = 5
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

has exactly four peaks: elements 1, 3, 5 and 10.

You are going on a trip to a range of mountains whose relative heights are represented by array A, 
as shown in a figure below. You have to choose how many flags you should take with you. The goal 
is to set the maximum number of flags on the peaks, according to certain rules.

Flags can only be set on peaks. What's more, if you take K flags, then the distance between any two 
flags should be greater than or equal to K. The distance between indices P and Q is the absolute value |P - Q|.

For example, given the mountain range represented by array A, above, with N = 12, if you take:

        two flags, you can set them on peaks 1 and 5;
        three flags, you can set them on peaks 1, 5 and 10;
        four flags, you can set only three flags, on peaks 1, 5 and 10.

You can therefore set a maximum of three flags in this case.

Write a function:

    int solution(int A[], int N); 

that, given a non-empty zero-indexed array A of N integers, 
returns the maximum number of flags that can be set on the peaks of the array.

For example, the following array A:

    A[0] = 1
    A[1] = 5
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

the function should return 3, as explained above.

Assume that:
        N is an integer within the range [1..200,000];
        each element of array A is an integer within the range [0..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N), 
		beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoPM72EC-AHM/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	$N = count($A);
	$peaks = array(); // array_fill(0, $N, 0);

	// Populate array of peaks
	for($i = 1; $i < $N - 1; $i++)
		if($A[$i-1] < $A[$i] && $A[$i+1] < $A[$i])
			$peaks[] = $i;

	// Number of flags cannot be more than number of peaks
	// Number fo flags cannot be more than F, where F * (F - 1) <= count($A) - 1

	// Square inequality
	$a = 1;
	$b = -1;
	$c = -($N-1);
	$d = $b * $b - 4 * $a * $c;
	$x1 = (-$b + sqrt($d)) / (2 * $a);
	$x2 = (-$b - sqrt($d)) / (2 * $a);

	// Max possible number of flags
	$maxFlags = min(count($peaks), max($x1, $x2));
	// Range of flag numbers
	$flagsRange = range(intval($maxFlags), 1);

	// Loop through flag numbers
	foreach($flagsRange as $V)
	{
		// Number of unflagged peaks
		$flagsRemaining = $V;
		// Keep previous flagged peak
		$prevPeakIndex = null;
		// Current peak index
		$currPeakIndex = 0;

		// Loop through peaks
		while($currPeakIndex < count($peaks) && $flagsRemaining > 0)
		 {
			// If distance to previous flagged peak is >= than number f flags
			// OR there is no previous flagged peak, then we can flag this peak
			if($prevPeakIndex === null || $peaks[$currPeakIndex] - $peaks[$prevPeakIndex] >= $V)
			{
				$flagsRemaining--;
				$prevPeakIndex = $currPeakIndex;
			}

			$currPeakIndex++;
		}

		if($flagsRemaining == 0)
			return $V;
	}

	return 0;
}