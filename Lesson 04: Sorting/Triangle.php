<?php

/*
A zero-indexed array A consisting of N integers is given. 
A triplet (P, Q, R) is triangular if 0 ≤ P < Q < R < N and:

        A[P] + A[Q] > A[R],
        A[Q] + A[R] > A[P],
        A[R] + A[P] > A[Q].

For example, consider array A such that:

  A[0] = 10    A[1] = 2    A[2] = 5
  A[3] = 1     A[4] = 8    A[5] = 20

Triplet (0, 2, 4) is triangular.

Write a function:

    function solution($A); 

that, given a zero-indexed array A consisting of N integers, 
returns 1 if there exists a triangular triplet for this array and returns 0 otherwise. 
For example, given array A such that:

  A[0] = 10    A[1] = 2    A[2] = 5
  A[3] = 1     A[4] = 8    A[5] = 20

the function should return 1, as explained above. Given array A such that:

  A[0] = 10    A[1] = 50    A[2] = 5
  A[3] = 1

the function should return 0.

Assume that:
        N is an integer within the range [0..100,000];
        each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoJQK54Y-2BH/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A) 
{
	// we sort array $A in ascending order from minimum to maximum integer; if closest integers 
	// don't fullfill triangular conditions, farther integers will not fulfill it also
	// index association is not maintained because rule 0 ≤ P < Q < R < N is not important;
	// namely the following rules cover every possible combination:
	// A[P] + A[Q] > A[R]
	// A[Q] + A[R] > A[P]
	// A[R] + A[P] > A[Q]
	sort($A);
	$N = count($A);

	$arrayEnd = false;
	// while we haven't reached array end
	while(!$arrayEnd)
	{
		$P = key($A);
		// advance the internal array pointer of an array
		next($A);
		$Q = key($A);
		next($A);
		$R = key($A);

		// if $Q and $R exist, we haven't reached array $A end
		if($Q !== NULL && $R !== NULL)
		{
			// rewind the internal array pointer 1 place back
			prev($A);

			// if triangular conditions are matched
			if($A[$P] + $A[$Q] > $A[$R] && $A[$Q] + $A[$R] > $A[$P] && $A[$R] + $A[$P] > $A[$Q])
				return 1;
		}
		else
			$arrayEnd = true;
	}

	return 0;
}