<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.

The leader of this array is the value that occurs in more than half of the elements of A.

An equi leader is an index S such that 0 ≤ S < N − 1 
and two sequences A[0], A[1], ..., A[S] and A[S + 1], A[S + 2], ..., A[N − 1] 
have leaders of the same value.

For example, given array A such that:

    A[0] = 4
    A[1] = 3
    A[2] = 4
    A[3] = 4
    A[4] = 4
    A[5] = 2

we can find two equi leaders:

        0, because sequences: (4) and (3, 4, 4, 4, 2) have the same leader, whose value is 4.
        2, because sequences: (4, 3, 4) and (4, 4, 2) have the same leader, whose value is 4.

The goal is to count the number of equi leaders. Write a function:

    function solution($A); 

that, given a non-empty zero-indexed array A consisting of N integers, 
returns the number of equi leaders.

For example, given:

    A[0] = 4
    A[1] = 3
    A[2] = 4
    A[3] = 4
    A[4] = 4
    A[5] = 2

the function should return 2, as explained above.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [−1,000,000,000..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo7QX88U-CZC/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// integer count of occurrences
	$integerOccurrences = array();
	// the largest count of occurrences
	$maxOccurrences = 0;
	// leader
	$leader = null;

	// first we seek leader
	foreach($A as $value) 
	{
		if(empty($integerOccurrences[$value]))
			$integerOccurrences[$value] = 1;
		else
			$integerOccurrences[$value]++;

		// if maximum occurrence got larger
		if($integerOccurrences[$value] > $maxOccurrences)
		{
			$maxOccurrences = $integerOccurrences[$value];
			$leader = $value;
		}
	}

	// number of integers in array $A
	$N = count($A);
	// if leader is not set, 
	// or max occured integer doesn't occurs in more than half of the elements of $A
	if($leader === null || ($maxOccurrences <= $N / 2))
		return 0;

	// now we know which integer is leader, so we'll count number of equi leaders
	$equiLeaders = 0;
	// number of leaders in array $A subsequence
	$subSequenceLeaders = 0;

	// counting for equi leaders
	foreach($A as $key => $value)
	{
		// counting subsequence leaders, as we iterate through array $A subsequence grows,
		// first iteration subSequence:		[4]
		// second iteration subSequence:	[4, 3]
		// third iteration subSequence:		[4, 3, 4]
		// etc.
		if($value === $leader)
			$subSequenceLeaders++;

		// if leader occurs in more than half of the elements in current subsequence,
		// and there is still remaining more leader occurences than other integers occurences
		// in remaining part of array $A, we have equi leader
		if($subSequenceLeaders > ($key + 1) / 2 
			&& ($maxOccurrences - $subSequenceLeaders) > ($N - $key - 1) / 2)
			$equiLeaders++;
	}

	return $equiLeaders;
}