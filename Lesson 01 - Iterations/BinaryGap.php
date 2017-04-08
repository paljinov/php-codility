<?php

/*
A binary gap within a positive integer N is any maximal sequence of consecutive zeros that
is surrounded by ones at both ends in the binary representation of N.

For example, number 9 has binary representation 1001 and contains a binary gap of length 2.
The number 529 has binary representation 1000010001 and contains two binary gaps: one of length 4 and one of length 3.
The number 20 has binary representation 10100 and contains one binary gap of length 1. The number 15 has binary
representation 1111 and has no binary gaps.

Write a function:

    function solution($N);

that, given a positive integer N, returns the length of its longest binary gap. The function should return 0
if N doesn't contain a binary gap.

For example, given N = 1041 the function should return 5, because N has binary representation 10000010001
and so its longest binary gap is of length 5.

Assume that:
        N is an integer within the range [1..2,147,483,647].

Complexity:
        expected worst-case time complexity is O(log(N));
        expected worst-case space complexity is O(1).
*/

/**
 * BinaryGap task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingEFRHZ8-7J5/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: not assessed
 * Task score:  100%
 *
 * @param int $N Positive integer N
 *
 * @return int Length of longest binary gap
 */
function solution($N)
{
    // Length of longest binary gap
    $binaryGapLength = 0;
    // Binary representation of the given number
    $binaryNumber = decbin($N);

    // Binary number is splitted by character '1'
    $exploded = explode('1', $binaryNumber);

    // Binary gap must be surrounded by ones at both ends, so there shouldn't be zeroes after last character '1'
    // occurrence, and before first character '1' occurrence
    unset($exploded[count($exploded) - 1]);
    unset($exploded[0]);

    // Searching for length of longest binary gap
    foreach ($exploded as $zeroes) {
        $length = strlen($zeroes);
        if ($length > $binaryGapLength) {
            $binaryGapLength = $length;
        }
    }

    return $binaryGapLength;
}
