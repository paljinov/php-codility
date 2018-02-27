<?php

/*
A zero-indexed array A consisting of N different integers is given.
The array contains integers in the range [1..(N + 1)], which means that exactly one element is missing.

Your goal is to find that missing element.

Write a function:

    function solution($A);

that, given a zero-indexed array A, returns the value of the missing element.

For example, given array A such that:

  A[0] = 2
  A[1] = 3
  A[2] = 1
  A[3] = 5

the function should return 4, as it is the missing element.

Assume that:
        N is an integer within the range [0..100,000];
        the elements of A are all distinct;
        each element of array A is an integer within the range [1..(N + 1)].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(1),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * PermMissingElem task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingV7P9M9-VKJ/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 *
 * @param array $A Zero-indexed array A
 *
 * @return int Value of the missing element
 */
function solution($A)
{
    // Missing element can be found by finding difference between
    // sum of elements with missing element and sum of elements without missing element

    // Integer has 32-bit or 64 bit, depending on PHP build and platform, and 32 bit is limitation
    // for N * ($N + 1) when N = 100 000
    // 32-bit int max number: 2147483647
    // when N = 100 000, sum = 10000100000
    // so we must use float
    // http://php.net/manual/en/language.types.float.php
    // "The size of a float is platform-dependent, although a maximum of ~1.8e308 with a precision
    // of roughly 14 decimal digits is a common value (the 64 bit IEEE format)."

    $sumIncludingMissingInteger = calculateSumIncludingMissingInteger($A);
    $sumWithoutMissingInteger = calculateSumWithoutMissingInteger($A);

    $missingInteger = (int) ($sumIncludingMissingInteger - $sumWithoutMissingInteger);

    return $missingInteger;
}

/**
 * Calculates sum of array A elements with addition of the missing one also.
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
function calculateSumIncludingMissingInteger(array $A): float
{
    $N = count($A) + 1;
    $sumIncludingMissingInteger = (float) ($N * ($N + 1)) / 2;

    return $sumIncludingMissingInteger;
}

/**
 * Calculates sum of array A elements.
 *
 * @param array $A
 *
 * @return float
 */
function calculateSumWithoutMissingInteger(array $A): float
{
    $sumWithoutMissingInteger = (float) 0;
    foreach ($A as $integer) {
        $sumWithoutMissingInteger += $integer;
    }

    return $sumWithoutMissingInteger;
}
