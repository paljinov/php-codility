<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.
The product of triplet (P, Q, R) equates to A[P] * A[Q] * A[R] (0 ≤ P < Q < R < N).

For example, array A such that:

  A[0] = -3
  A[1] = 1
  A[2] = 2
  A[3] = -2
  A[4] = 5
  A[5] = 6

contains the following example triplets:

        (0, 1, 2), product is −3 * 1 * 2 = −6
        (1, 2, 4), product is 1 * 2 * 5 = 10
        (2, 4, 5), product is 2 * 5 * 6 = 60

Your goal is to find the maximal product of any triplet.

Write a function:

    function solution($A);

that, given a non-empty zero-indexed array A, returns the value of the maximal product of any triplet.

For example, given array A such that:

  A[0] = -3
  A[1] = 1
  A[2] = 2
  A[3] = -2
  A[4] = 5
  A[5] = 6

the function should return 60, as the product of triplet (2, 4, 5) is maximal.

Assume that:
        N is an integer within the range [3..100,000];
        each element of array A is an integer within the range [−1,000..1,000].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(1),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * MaxProductOfThree task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingNJU2UM-5YZ/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param int[] $A Non-empty zero-indexed array A consisting of N integers
 *
 * @return int The maximal product of any triplet.
 */
function solution($A)
{
    // Maximal product is initialized to product of first three integers
    $maxProduct = array_product(array_slice($A, 0, 3));
    // Array $A is sorted in descending order, from maximum to minimum integer
    rsort($A);

    // Positive integers
    $positive = array_filter($A, function ($integer) {
        return $integer > 0;
    });
    // Zero integers
    $zero = array_filter($A, function ($integer) {
        return $integer == 0;
    });
    // Negative integers
    $negative = array_filter($A, function ($integer) {
        return $integer < 0;
    });

    // If there are at least 3 positive integers
    if (count($positive) >= 3) {
        // If three largest integers make new maximal product
        if(array_product(array_slice($positive, 0, 3)) > $maxProduct) {
            $maxProduct = array_product(array_slice($A, 0, 3));
        }
    }
    // If there are at least 2 negative integers and at least 1 positive integer
    if (count($negative) >= 2 && count($positive) >= 1) {
        // If two smallest negative integers (absolute largest) and largest positive integer make new maximal product
        if ((array_product(array_slice($negative, -2, 2)) * $positive[0]) > $maxProduct) {
            $maxProduct = array_product(array_slice($negative, -2, 2)) * $positive[0];
        }
    }
    // If maximal product is still negative and there are zero integers
    if ($maxProduct < 0 && count($zero)) {
        $maxProduct = 0;
    }
    // If there are at least 3 negative integers
    if (count($negative) >= 3) {
        // If three largest negative integers (absolute smallest) make new maximal product
        if (array_product(array_slice($negative, 0, 3)) > $maxProduct) {
            $maxProduct = array_product(array_slice($negative, 0, 3));
        }
    }

    return $maxProduct;
}
