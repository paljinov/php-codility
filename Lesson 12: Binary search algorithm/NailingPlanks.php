<?php

/*
You are given two non-empty zero-indexed arrays A and B consisting of N integers. 
These arrays represent N planks. More precisely, A[K] is the start and B[K] the end of the K−th plank.

Next, you are given a non-empty zero-indexed array C consisting of M integers. This array 
represents M nails. More precisely, C[I] is the position where you can hammer in the I−th nail.

We say that a plank (A[K], B[K]) is nailed if there exists a nail C[I] such that A[K] ≤ C[I] ≤ B[K].

The goal is to find the minimum number of nails that must be used until all the planks are nailed. 
In other words, you should find a value J such that all planks will be nailed after using only 
the first J nails. More precisely, for every plank (A[K], B[K]) such that 0 ≤ K < N, 
there should exist a nail C[I] such that I < J and A[K] ≤ C[I] ≤ B[K].

For example, given arrays A, B such that:

    A[0] = 1    B[0] = 4
    A[1] = 4    B[1] = 5
    A[2] = 5    B[2] = 9
    A[3] = 8    B[3] = 10

four planks are represented: [1, 4], [4, 5], [5, 9] and [8, 10].

Given array C such that:

    C[0] = 4
    C[1] = 6
    C[2] = 7
    C[3] = 10
    C[4] = 2

if we use the following nails:

        0, then planks [1, 4] and [4, 5] will both be nailed.
        0, 1, then planks [1, 4], [4, 5] and [5, 9] will be nailed.
        0, 1, 2, then planks [1, 4], [4, 5] and [5, 9] will be nailed.
        0, 1, 2, 3, then all the planks will be nailed.

Thus, four is the minimum number of nails that, used sequentially, allow all the planks to be nailed.

Write a function:

    function solution($A, $B, $C); 

that, given two non-empty zero-indexed arrays A and B consisting of N integers 
and a non-empty zero-indexed array C consisting of M integers, 
returns the minimum number of nails that, used sequentially, allow all the planks to be nailed.

If it is not possible to nail all the planks, the function should return −1.

For example, given arrays A, B, C such that:

    A[0] = 1    B[0] = 4
    A[1] = 4    B[1] = 5
    A[2] = 5    B[2] = 9
    A[3] = 8    B[3] = 10
    
    C[0] = 4
    C[1] = 6
    C[2] = 7
    C[3] = 10
    C[4] = 2

the function should return 4, as explained above.

Assume that:
        N and M are integers within the range [1..30,000];
        each element of arrays A, B, C is an integer within the range [1..2*M];
        A[K] ≤ B[K].

Complexity:
        expected worst-case time complexity is O((N+M)*log(M));
        expected worst-case space complexity is O(M), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoEFJH4Y-JBC/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A, $B, $C)
{
	// number of planks, where $A is plank start, and $B plank end
	$N = count($A);

	$planks = array();
	for($i = 0; $i < $N; $i++)
	{
		$planks[$i]['start'] = $A[$i];
		$planks[$i]['end'] = $B[$i];
	}

	// starting number of nails
	$beg = 1;
	// ending number of nails
	$end = count($C);

	// minimal required number of nails that allow all the planks to be nailed
	// initialized to -1 if it is not possible to nail all the planks
	$result = -1;
	while($beg <= $end)
	{
		// middle number of nails
		$mid = (int)(($beg + $end) / 2);
		// nails with which we try to nail all the planks, 
		// keys are preserved because they represent nails
		$availableNails = array_slice($C, 0, $mid);

		// are all planks nailed ?
		$areAllPlanksNailed = areAllPlanksNailed($planks, $availableNails);
		// if all planks are nailed, we try to find if they can be nailed with less nails
		if($areAllPlanksNailed)
		{
			$end = $mid - 1;
			$result = $mid;
		}
		// if all planks are not nailed, we try to find if they can be nailed with more nails
		else
			$beg = $mid + 1;
	}

	return $result;
}

/**
 * Checks if all planks are nailed with given sequence of nails.
 * 
 * @param array $planks Planks start and end positions
 * @param array $availableNails Nails which can be used to nail planks
 * 
 * @return true|false true if all planks are nailed, else false
 */
function areAllPlanksNailed($planks, $availableNails)
{
	// sorting nails, from smallest to highest
	sort($availableNails);

	$nailedPlanks = 0;
	// iterating through every plank
	foreach($planks as $index => $plank)
	{
		// starting nail position
		$beg = 0;
		// ending nail position
		$end = count($availableNails) - 1;
		while($beg <= $end)
		{
			// middle mail position
			$mid = (int)(($beg + $end) / 2);

			if($availableNails[$mid] < $plank['start'])
				$beg = $mid + 1;
			elseif($availableNails[$mid] > $plank['end'])
				$end = $mid - 1;
			// if nail is between plank start and end, plank can be nailed
			else
			{
				$nailedPlanks++;
				break;
			}
		}
	}

	return $nailedPlanks === count($planks) ? true : false;
}