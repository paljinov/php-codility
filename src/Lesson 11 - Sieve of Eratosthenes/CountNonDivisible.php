<?php

/*
You are given a non-empty zero-indexed array A consisting of N integers.

For each number A[i] such that 0 ≤ i < N, we want to count the number of elements
of the array that are not the divisors of A[i]. We say that these elements are non-divisors.

For example, consider integer N = 5 and array A such that:

    A[0] = 3
    A[1] = 1
    A[2] = 2
    A[3] = 3
    A[4] = 6

For the following elements:

    A[0] = 3, the non-divisors are: 2, 6,
    A[1] = 1, the non-divisors are: 3, 2, 3, 6,
    A[2] = 2, the non-divisors are: 3, 3, 6,
    A[3] = 3, the non-divisors are: 2, 6,
    A[6] = 6, there aren't any non-divisors.

Write a function:

    function solution($A);

that, given a non-empty zero-indexed array A consisting of N integers, returns a
sequence of integers representing the amount of non-divisors.

The sequence should be returned as:

    a structure Results (in C), or
    a vector of integers (in C++), or
    a record Results (in Pascal), or
    an array of integers (in any other programming language).

For example, given:
    A[0] = 3
    A[1] = 1
    A[2] = 2
    A[3] = 3
    A[4] = 6

the function should return [2, 4, 3, 2, 0], as explained above.

Assume that:
    N is an integer within the range [1..50,000];
    each element of array A is an integer within the range [1..2 * N].

Complexity:
    expected worst-case time complexity is O(N*log(N));
    expected worst-case space complexity is O(N),
    beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingXDX8PF-8NP/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	$N = count($A);
	// amount of non-divisors
	$nonDivisibles = array();

	// calculate how many times number occurs in original array
	$occurrence = array_fill(0, $N, 0);
	foreach($A as $val)
		$occurrence[$val] = isset($occurrence[$val]) ? $occurrence[$val] + 1 : 1;

	for($i = 0; $i < $N; $i++)
	{
		// define divisors number
		$divisorsCount = 0;
		for($j = 1; $j * $j <= $A[$i]; $j++)
		{
			// if $j is divisor of $A[$i] add number of occurences $j to $divisorsCount
			if($A[$i] % $j == 0) 
			{
				$divisorsCount += $occurrence[$j];

				// also add remainder of the division as a $A[$i] divisor
				if($A[$i] / $j != $j)
					$divisorsCount += $occurrence[$A[$i] / $j];
			}
		}

		// subtract divisors number from array length to get nonDivisible for element $i
		$nonDivisibles[$i] = $N - $divisorsCount;
	}

	return $nonDivisibles;
}