<?php

/*
You are given an array A consisting of N integers.

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

/**
 * CountNonDivisible task.
 *
 * CODILITY ANALYSIS: https://app.codility.com/demo/results/training34D9UJ-W53/
 * LEVEL: MEDIUM
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Non-empty zero-indexed array A of N integers
 *
 * @return array A sequence of integers representing the amount of non-divisors
 */
function solution($A)
{
    // A sequence of integers representing the amount of non-divisors
    $nonDivisorsAmountSequence = [];

    $N = count($A);

    // Integer occurrences in array A
    $occurrences = array_fill(1, 2 * $N, 0);
    foreach ($A as $integer) {
        $occurrences[$integer] += 1;
    }

    // Number of non divisors for some integer
    $nonDivisorsForInteger = [];
    for ($i = 0; $i < $N; $i++) {
        $integer = $A[$i];

        if (isset($nonDivisorsForInteger[$integer])) {
            // If we already calculated number of non divisors for this integer
            $nonDivisorsAmountSequence[$i] = $nonDivisorsForInteger[$integer];
        } else {
            // If we haven't calculated number of non divisors for this integer

            $divisorsCount = 0;

            for ($j = 1; $j * $j <= $integer; $j++) {
                // If $j is divisor of $integer] add number of occurences $j to $divisorsCount
                if ($integer % $j == 0) {
                    $divisorsCount += $occurrences[$j];

                    // If divisor and quotient are not equal add occurences of quotient also
                    $quotient = $integer / $j;
                    if ($quotient != $j) {
                        $divisorsCount += $occurrences[$quotient];
                    }
                }
            }

            // Subtract divisors number from array length to get non divisible for element $i
            $nonDivisorsAmountSequence[$i] = $N - $divisorsCount;
            $nonDivisorsForInteger[$integer] = $nonDivisorsAmountSequence[$i];
        }
    }

    return $nonDivisorsAmountSequence;
}
