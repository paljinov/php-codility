<?php

/*
You are given integers K, M and a non-empty zero-indexed array A consisting of N integers. 
Every element of the array is not greater than M.

You should divide this array into K blocks of consecutive elements. 
The size of the block is any integer between 0 and N. 
Every element of the array should belong to some block.

The sum of the block from X to Y equals A[X] + A[X + 1] + ... + A[Y]. 
The sum of empty block equals 0.

The large sum is the maximal sum of any block.

For example, you are given integers K = 3, M = 5 and array A such that:

A[0] = 2
A[1] = 1
A[2] = 5
A[3] = 1
A[4] = 2
A[5] = 2
A[6] = 2

The array can be divided, for example, into the following blocks:

[2, 1, 5, 1, 2, 2, 2], [], [] with a large sum of 15;
[2], [1, 5, 1, 2], [2, 2] with a large sum of 9;
[2, 1, 5], [], [1, 2, 2, 2] with a large sum of 8;
[2, 1], [5, 1], [2, 2, 2] with a large sum of 6.

The goal is to minimize the large sum. In the above example, 6 is the minimal large sum.

Write a function:

function solution($K, $M, $A); 

that, given integers K, M and a non-empty zero-indexed array A consisting of N integers, 
returns the minimal large sum.

For example, given K = 3, M = 5 and array A such that:

A[0] = 2
A[1] = 1
A[2] = 5
A[3] = 1
A[4] = 2
A[5] = 2
A[6] = 2

the function should return 6, as explained above. 

Assume that:
N and K are integers within the range [1..100,000];
M is an integer within the range [0..10,000];
each element of array A is an integer within the range [0..M].

Complexity:
expected worst-case time complexity is O(N*log(N+M));
expected worst-case space complexity is O(1), 
beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoW6N4J7-2FU/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($K, $M, $A)
{
	// we'll use binary search algorithm to find minimum large sum

	// minimum large sum initialization, maximum array $A integer must in some block,
	// so large sum can't be lower than that
	$minSum = max($A);
	// maximum large sum is initialized to sum of all integers
	$maxSum = array_sum($A);

	// minimum block large sum which can be achieved by dividing array $A to $K blocks
	$resultingLargeSum = 0;
	while($minSum <= $maxSum)
	{
		// middle large sum
		$midSum = (int)ceil(($minSum + $maxSum) / 2);
		// minimum number of blocks which are required to get sum in every block 
		// which is not greater than maximum defined sum
		$blocksNeeded = maxSumLimitBlocks($A, $midSum);

		// if number of blocks does not exceed $K, 
		// we have new minimum sum which we are trying to lower in every iteration
		if($blocksNeeded <= $K)
		{
			$maxSum = $midSum - 1;
			$resultingLargeSum = $midSum;
		}
		else
			$minSum = $midSum + 1;
	}

	return $resultingLargeSum;
}

/**
 * Calculates minimum number of blocks in which array $A can be divided,
 * to get sum in every block which is not greater than maximum allowed block sum.
 * 
 * @param array $A
 * @param int $maxBlockSum Maximum sum which must not be exceeded in any block
 * 
 * @return int $blocksNumber The number of blocks on which array $A is a divided
 */
function maxSumLimitBlocks($A, $maxBlockSum)
{
	// number of array $A blocks required to have sum in all of them
	// which is less or equal to $maxBlockSum
	$blocksNumber = 1;

	$blockSum = $A[0];
	for($i = 1; $i < count($A); $i++)
	{
		// if block sum exceeds the maximum allowed sum
		if($blockSum + $A[$i] > $maxBlockSum)
		{
			// starting new block sum
			$blockSum = $A[$i];
			$blocksNumber += 1;
		}
		// if block sum does not exceed the maximum allowed sum
		else
			$blockSum += $A[$i];
	}

	return $blocksNumber;
}