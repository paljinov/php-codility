<?php

/*
A zero-indexed array A consisting of N integers is given. A triplet (P, Q, R) is triangular 
if it is possible to build a triangle with sides of lengths A[P], A[Q] and A[R]. In other words, 
triplet (P, Q, R) is triangular if 0 ≤ P < Q < R < N and:

        A[P] + A[Q] > A[R],
        A[Q] + A[R] > A[P],
        A[R] + A[P] > A[Q].

For example, consider array A such that:

  A[0] = 10    A[1] = 2    A[2] = 5
  A[3] = 1     A[4] = 8    A[5] = 12

There are four triangular triplets that can be constructed from elements of this array, 
namely (0, 2, 4), (0, 2, 5), (0, 4, 5), and (2, 4, 5).

Write a function:

    int solution(int A[], int N); 

that, given a zero-indexed array A consisting of N integers, 
returns the number of triangular triplets in this array.

For example, given array A such that:

  A[0] = 10    A[1] = 2    A[2] = 5
  A[3] = 1     A[4] = 8    A[5] = 12

the function should return 4, as explained above.

Assume that:
        N is an integer within the range [0..1,000];
        each element of array A is an integer within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N^2);
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoCV9GRN-SNA/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// sorting array $A from lowest to highest integer
	sort($A);
	// number of triangles initialization
	$triangles = 0;
	// array $A number of elements
	$N = count($A);

	for($i = 0; $i < $N - 2; $i++)
	{
		$k = 0;
		for($j = $i + 1; $j < $N - 1; $j++)
		{
			// while we haven't reached end, and triplet is triangular 
			// (array $A is sorted, and $A[$k] is highest value, so other two triangular conditions are also matched)
			while($k < $N && ($A[$i] + $A[$j]) > $A[$k])
				// when increasing the value of $j, we can increase (as far as possible) the value of $k	
				$k += 1;

			$triangles += $k - $j - 1;
		}
	}

	return $triangles;
}