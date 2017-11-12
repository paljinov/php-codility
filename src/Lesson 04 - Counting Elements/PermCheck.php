<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.

A permutation is a sequence containing each element from 1 to N once, and only once.

For example, array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3
    A[3] = 2

is a permutation, but array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3

is not a permutation, because value 2 is missing.

The goal is to check whether array A is a permutation.

Write a function:

    function solution($A);

that, given a zero-indexed array A, returns 1 if array A is a permutation and 0 if it is not.

For example, given array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3
    A[3] = 2

the function should return 1.

Given array A such that:

    A[0] = 4
    A[1] = 1
    A[2] = 3

the function should return 0.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * PermCheck task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingDYED3G-7WG/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Non-empty zero-indexed array A
 *
 * @return int 1 if array A is a permutation and 0 if it is not
 */
function solution($A)
{
    $isPermuatation = 0;

    // Integer has 32-bit or 64 bit, depending on PHP build and platform, and 32 bit is limitation
    // for N * ($N + 1) when N = 100 000
    // 32-bit int max number: 2147483647
    // when N = 100 000, sum = 10000100000
    // so we must use float
    // http://php.net/manual/en/language.types.float.php
    // "The size of a float is platform-dependent, although a maximum of ~1.8e308 with a precision
    // of roughly 14 decimal digits is a common value (the 64 bit IEEE format)."

    $permutationSum = calculatePermutationSum($A);
    $actualSum = calculateActualSum($A);
    $diff = (int) ($permutationSum - $actualSum);

    // If actual sum is equal to permutation sum, we could have permuatation
    if ($diff == 0) {
        // For example array [2, 2, 2, 4] gives the sum of 10, and array [1 2 3 4] also gives the same sum,
        // but first array is not permuation, and second one is, so we check that all numbers are unique
        $unique = array_unique($A);
        // If all integers are unique
        if (count($A) == count($unique)) {
            $isPermuatation = 1;
        }
    }

    return $isPermuatation;
}

/**
 * Calculates array $A permutation sum.
 *
 * Gauss sum formula for positive consecutive integers, also known as PERMUATION number array is used:
 * sum = (N * (N + 1)) / 2, where N is count of positive consecutive integers
 * for example, sum of 1 + 2 + 3 + 4 + 5 = (5 * (5 + 1)) / 2 = (5 * 6) / 2 = 30 / 2 = 15.
 * According to legend, Gauss figured this out at the age of 8 during class in elementary school.
 *
 * @param array $A
 *
 * @return float
 */
function calculatePermutationSum(array $A): float
{
    $N = count($A);
    $permutationSum = (float) ($N * ($N + 1)) / 2;

    return $permutationSum;
}

/**
 * Calculates actual array A sum.
 *
 * @param array $A
 *
 * @return float
 */
function calculateActualSum(array $A): float
{
    $actualSum = (float) 0;
    foreach ($A as $integer) {
        $actualSum += $integer;
    }

    return $actualSum;
}
