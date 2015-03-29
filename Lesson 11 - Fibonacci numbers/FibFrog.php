<?php

/*
The Fibonacci sequence is defined using the following recursive formula:

    F(0) = 0
    F(1) = 1
    F(M) = F(M - 1) + F(M - 2) if M >= 2

A small frog wants to get to the other side of a river. 
The frog is initially located at one bank of the river (position −1) 
and wants to get to the other bank (position N). 
The frog can jump over any distance F(K), where F(K) is the K-th Fibonacci number. 
Luckily, there are many leaves on the river, and the frog can jump between the leaves, 
but only in the direction of the bank at position N.

The leaves on the river are represented in a zero-indexed array A consisting of N integers. 
Consecutive elements of array A represent consecutive positions from 0 to N − 1 on the river. 
Array A contains only 0s and/or 1s:

        0 represents a position without a leaf;
        1 represents a position containing a leaf.

The goal is to count the minimum number of jumps in which the frog 
can get to the other side of the river (from position −1 to position N). 
The frog can jump between positions −1 and N (the banks of the river) 
and every position containing a leaf.

For example, consider array A such that:

    A[0] = 0
    A[1] = 0
    A[2] = 0
    A[3] = 1
    A[4] = 1
    A[5] = 0
    A[6] = 1
    A[7] = 0
    A[8] = 0
    A[9] = 0
    A[10] = 0

The frog can make three jumps of length F(5) = 5, F(3) = 2 and F(5) = 5.

Write a function:

    function solution($A); 

that, given a zero-indexed array A consisting of N integers, 
returns the minimum number of jumps by which the frog can get to the other side of the river. 
If the frog cannot reach the other side of the river, the function should return −1.

For example, given:

    A[0] = 0
    A[1] = 0
    A[2] = 0
    A[3] = 1
    A[4] = 1
    A[5] = 0
    A[6] = 1
    A[7] = 0
    A[8] = 0
    A[9] = 0
    A[10] = 0

the function should return 3, as explained above.

Assume that:
        N is an integer within the range [0..100,000];
        each element of array A is an integer that can have one of the following values: 0, 1.

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoGG84CK-8B4/
 * LEVEL: HARD
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// $A represents consecutive positions from 0 to N − 1,
	// we will add last N position, which represents the other bank of the river
	array_push($A, 1);
	// number of positions
	$N = count($A);
	// valid frog jump Fibonacci distances, in range from 1 to full river width,
	// key represents Fibonacci number/distance, and value is K-th number, 
	// array is reversed for later condition speed
	$validFibonacciDistances = array_flip(getValidFibonacciDistances($N));

	// minimum number of jumps for frog to get to the other bank of the river
	$minJumps = null;
	// minimum number of jumps to reach some Fibonnaci distance
	$jumps = array();
	// at start, frog is at position -1 with 0 jumps
	$jumps[-1] = 0;

	// iterating while all jump combinations are not iterated, and while minimum number of jumps is not found
	while($jumps && is_null($minJumps))
	{
		$currentPosition = key($jumps);
		$jumpCount = current($jumps);

		// seeking for next possible positions using Breadth First Search algorithm
		foreach($validFibonacciDistances as $fibonnaciJump => $forFibonnaciNumber)
		{
			$nextPosition = $currentPosition + $fibonnaciJump;
			// if position is not bigger than other bank of the river position,
			// has a leaf, and represents Fibonnaci distance,
			if(($nextPosition <= $N - 1) && $A[$nextPosition] === 1 && !isset($jumps[$nextPosition]))
			{
				$jumps[$nextPosition] = $jumpCount + 1;
				// if position represents other bank of the river
				if($nextPosition === $N - 1)
					$minJumps = $jumps[$nextPosition];
			}
		}

		// current position is processed
		unset($jumps[$currentPosition]);
	}

	return !empty($minJumps) ? $minJumps : -1;
}

/**
 * Calculates valid Fibonacci frog jump distances. Fibonacci sequence is calculated dynamically.
 *  
 * @param int $riverWidth Represent river width
 * @return array $fibJumps Fibonacci jumps distances
 */
function getValidFibonacciDistances($riverWidth)
{
	$fibJumps = array();

	$fibJumps[0] = 0;
	$fibJumps[1] = 1;
	$i = 2;
	$fibonacci = 0;
	// while last Fibonacci number is smaller than the distance
	while($fibonacci <= $riverWidth)
	{ 
		$fibonacci = $fibJumps[$i-1] + $fibJumps[$i-2];
		if($fibonacci <= $riverWidth)
			$fibJumps[$i] = $fibonacci;

		$i++;
	}

	// F(0) = 0 => this is not a valid jump so we omit F(0)
	unset($fibJumps[0]);
	// F(1) = F(2) = 1 // this distance is duplicated, so we omit F(1)
	unset($fibJumps[1]);

	return $fibJumps;
}