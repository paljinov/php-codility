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

/**
 * Triangle task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingMZ5RSX-UUM/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 *
 * @param int[] $A Zero-indexed array A consisting of N integers
 *
 * @return int 1 if there exists a triangular triplet for this array, 0 otherwise
 */
function solution($A)
{
    // Array $A is sorted in descending order from maximal to minimal integer, because if closest integers
    // don't fullfill triangular conditions, farther integers will not fulfill it also.
    rsort($A);

    $isTripletTriangular = 0;
    // Iterating through array $A, to check if at least one closest triplet is triangular
    for ($i = 0; $i < count($A); $i++) {
        if (isset($A[$i + 1])) {
            $P = $A[$i];
            $Q = $A[$i + 1];
            $R = $A[$i + 2];

            if (isTripletTriangular($P, $Q, $R)) {
                $isTripletTriangular = 1;
                break;
            }
        }
    }

    return $isTripletTriangular;
}

/**
 * Checks is triple triangular.
 *
 * @param int $A
 * @param int $B
 * @param int $C
 *
 * @return bool
 */
function isTripletTriangular($P, $Q, $R): bool
{
    if ($P + $Q > $R && $P + $R > $Q && $Q + $R > $P) {
        return true;
    }

    return false;
}
