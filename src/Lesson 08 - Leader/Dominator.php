<?php

/*
A zero-indexed array A consisting of N integers is given.
The dominator of array A is the value that occurs in more than half of the elements of A.

For example, consider array A such that

    A[0] = 3    A[1] = 4    A[2] =  3
    A[3] = 2    A[4] = 3    A[5] = -1
    A[6] = 3    A[7] = 3

The dominator of A is 3 because it occurs in 5 out of 8 elements of A
(namely in those with indices 0, 2, 4, 6 and 7) and 5 is more than a half of 8.

Write a function

    function solution($A);

that, given a zero-indexed array A consisting of N integers,
returns index of any element of array A in which the dominator of A occurs.
The function should return −1 if array A does not have a dominator.

Assume that:
        N is an integer within the range [0..100,000];
        each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

For example, given array A such that

    A[0] = 3    A[1] = 4    A[2] =  3
    A[3] = 2    A[4] = 3    A[5] = -1
    A[6] = 3    A[7] = 3

the function may return 0, 2, 4, 6 or 7, as explained above.

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(1),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * Dominator task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/training5YQZWK-DX2/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Zero-indexed array A consisting of N integers
 *
 * @return int The index of any element of array A in which the dominator of A occurs,
 * or −1 if array A does not have a dominator
 */
function solution($A)
{
    // Number of occurrences of each integer
    $integerOccurrences = [];
    // Maximum number of occurrences
    $maxOccurrences = 0;
    // Index of integer with maximum occurrences
    $maxOccurrencesKey = null;

    foreach ($A as $key => $value) {
        if (empty($integerOccurrences[$value])) {
            $integerOccurrences[$value] = 1;
        } else {
            $integerOccurrences[$value]++;
        }

        // Searching for integer with maxiumum occurences, and index of that integer
        if ($integerOccurrences[$value] > $maxOccurrences) {
            $maxOccurrences = $integerOccurrences[$value];
            $maxOccurrencesKey = $key;
        }
    }

    // Number of integers in array $A
    $N = count($A);
    // If index of integer with maxiumum occurences is not set,
    // or integer with maxiumum occurences doesn't occur in more than half of the elements of $A
    if ($maxOccurrencesKey === null || ($maxOccurrences <= $N / 2)) {
        return -1;
    }

    return $maxOccurrencesKey;
}
