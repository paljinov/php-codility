<?php

/*
Write a function:

    function solution($A, $B, $K);

that, given three integers A, B and K,
returns the number of integers within the range [A..B] that are divisible by K, i.e.:

    { i : A ≤ i ≤ B, i mod K = 0 }

For example, for A = 6, B = 11 and K = 2, your function should return 3,
because there are three numbers divisible by 2 within the range [6..11], namely 6, 8 and 10.

Assume that:
        A and B are integers within the range [0..2,000,000,000];
        K is an integer within the range [1..2,000,000,000];
        A ≤ B.

Complexity:
        expected worst-case time complexity is O(1);
        expected worst-case space complexity is O(1).
*/

/**
 * CountDiv task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingW2VAHM-9PF/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param int $A Start of the potential dividend range
 * @param int $B End of the potential dividend range
 * @param int $K divisor
 *
 * @return int The number of integers within the range [A..B] that are divisible by K
 */
function solution($A, $B, $K)
{
    // The number of integers within the range [A..B] that are divisible by K
    $divisibleByKInRange = 0;

    // The number of dividends for divisor K from 0 to A
    $divisibleByKFromZeroToA = (int) floor($A / $K);
    // The number of dividends for divisor K from 0 to B
    $divisibleByKFromZeroToB = (int) floor($B / $K);

    if ($A % $K === 0) {
        // If A is divisible by K
        $divisibleByKInRange = $divisibleByKFromZeroToB - $divisibleByKFromZeroToA + 1;
    } else {
        // if A is not divisible by K
        $divisibleByKInRange = $divisibleByKFromZeroToB - $divisibleByKFromZeroToA;
    }

    return $divisibleByKInRange;
}
