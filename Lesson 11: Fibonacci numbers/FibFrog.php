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
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoMRP2YA-YXM/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// jump positions which contain leaf, and are Fibonnaci number
	// contains position, and number of jumps to reach it
	$fibPositions = array();
	// minimum number of jumps for frog to get to other the side of the river
	$minJumps = null;

	// $A represent consecutive positions from 0 to N − 1, 
	// we will add last N position, which represents the other side of the river
	array_push($A, 1);
	// the other side of the river position
	end($A);
	$endPosition = key($A);
	// valid frog jump Fibonacci distances, from 1 to river width
	$validFibonacciDistances = getValidFibonacciDistances(count($A));

	for($i = 0; $i < count($A); $i++)
	{
		// if there is leaf on this position, we must check is it Fibonnaci number,
		// because the frog can only jump to F(K) position
		if($A[$i] === 1)
		{
			// checking if frog can jump from start position to current position
			if(isFrogJumpValid($i + 1, $validFibonacciDistances))
			{
				$fibPositions[$i] = 1;
				// if current position represents the other side of the river
				if($i === $endPosition)
				{
					$minJumps = 1;
					break;
				}
			}

			// if frog jumped at least once
			if(!empty($fibPositions))
			{
				// finding all next possible jump positions from all so far 
				// disovered Fibonacci leaves positions
				foreach($fibPositions as $fibPosition => $jumps) 
				{
					// if frog can get from leaf position to the other side of the river
					if(isFrogJumpValid($endPosition - $fibPosition, $validFibonacciDistances))
					{
						// one more jump from position to the other side
						if($minJumps === null || ($jumps + 1) < $minJumps)
							$minJumps = $jumps + 1;
					}
					// if jump distance is valid, it is Fibonacci number, 
					// and position is not already reached with less or equal number of jumps
					elseif(isFrogJumpValid($i - $fibPosition, $validFibonacciDistances) 
						&& !array_key_exists($i, $fibPositions))
						$fibPositions[$i] = $jumps + 1;
				}
			}
		}
	}

	// if frog cannot reach to the other side of the river	
	if($minJumps === null)
		return -1;
	else
		return $minJumps;
}

/**
 * Checks if frog jump distance is valid.
 * 
 * @param int $distance Jump distance
 * @return bool is jump valid
 */  
function isFrogJumpValid($distance, $validFibonacciDistances)
{
	// jump distance can't be 0 or negative
	if($distance <= 0)
		return false;

	// if jump belongs to permitted Fibonacci jumps
	if(in_array($distance, $validFibonacciDistances))
		return true;
	else
		return false;
}

/**
 * Gets frog jump Fibonacci distances. Jump distance can't be 0, 
 * so this function omits that Fibonnaci number.
 * Fibonacci numbers are calculated dynamically for speed.
 * 
 * @param int $riverWidth Represent river width
 * @return array Fibonacci jumps distances
 */
function getValidFibonacciDistances($riverWidth)
{
	$fibNumbers = array();

	if($riverWidth === 1)
		$fibNumbers[1] = 1;
	else
	{
		$fibNumbers[0] = 0;
		$fibNumbers[1] = 1;
		// represents last Fibonacci number in $fibNumbers array
		$lastFibonacci = 0;
		$i = 2;
		// while last Fibonacci number is smaller than the distance
		while($lastFibonacci <= $riverWidth)
		{ 
			$lastFibonacci = $fibNumbers[$i-1] + $fibNumbers[$i-2];
			if($lastFibonacci <= $riverWidth)
				$fibNumbers[] = $lastFibonacci;

			$i++;
		}

		// 0 is not valid jump distance
		unset($fibNumbers[0]);
		// F(1) = F(2), so we can remove F(1) because it is duplicate
		unset($fibNumbers[1]);
	}

	return $fibNumbers;
}