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
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoP8QAKJ-RM4/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	75%
 * Task score:	87%
 */
function solution($A, $B, $C)
{
	// number of planks, where $A is plank start, and $B plank end
	$N = count($A);

	// minimal number of nails that, used sequentially, allow all the planks to be nailed
	$minNails = 1;
	// maximum number of nails that, used sequentially, allow all the planks to be nailed
	$maxNails = count($C);

	// minimal required number of nails that allow all the planks to be nailed
	// initialized to -1 if it is not possible to nail all the planks
	$requiredNails = -1;
	while($minNails <= $maxNails)
	{
		// middle number of nails
		$midNails = (int)ceil(($maxNails + $minNails) / 2);
		// nails which can be used to nail planks
		$availableNails = array_slice($C, 0, $midNails);

		// nailed planks with defined number of nails
		$nailedPlanks = nailedPlanks($A, $B, $availableNails);
		// if all planks are nailed, we try to find if they can be nailed with less nails
		if($nailedPlanks === $N)
		{
			$maxNails = $midNails - 1;
			$requiredNails = $midNails;
		}
		// if all plans are not nailed
		else
			$minNails = $midNails + 1;
	}

	return $requiredNails;
}

/**
 * Calculates maximum number of nailed planks with definite number of available nails.
 * 
 * @param array $A Planks start
 * @param array $B Planks end
 * @param array $availableNails Nails which can be used to nail planks
 * 
 * @return int $nailedPlanks Number of nailed planks
 */
function nailedPlanks($A, $B, $availableNails)
{
	// nailed plank position
	$nailedPlanks = array();

	// minimal available nail value
	$minNail = min($availableNails);
	// maximum available nail value
	$maxNail = max($availableNails);

	// exchanges all keys with their associated values in an array, 
	// so we can use array_key_exists which has complexity close to O(1)
	$availableNails = array_flip($availableNails);

	// number of planks
	$N = count($A);
	for($i = 0; $i < $N; $i++)
	{
		// if plank is postioned partially between minimum and maximum nail value,
		// it can be nailed for sure (at least max and min nail can be hammered)
		if(($A[$i] <= $minNail && $B[$i] >= $minNail) || ($A[$i] <= $maxNail && $B[$i] >= $maxNail))
			$nailedPlanks[$i] = 1;
		// if plank is postioned completely between min and max nail value, 
		// potentially it can be nailed
		elseif($A[$i] > $minNail && $B[$i] < $maxNail)
		{
			// position on plank
			$x = $A[$i];
			// while plank end is not reached
			while($x <= $B[$i])
			{
				// checking if there is a nail which can be hammered
				if(array_key_exists($x, $availableNails))
				{
					$nailedPlanks[$i] = 1;
					break;
				}

				$x++;
			}
		}
	}

	return count($nailedPlanks);
}