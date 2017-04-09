<?php

/*
Write a function:

    function solution($A);

that, given a non-empty zero-indexed array A of N integers,
returns the minimal positive integer that does not occur in A.

For example, given:

  A[0] = 1
  A[1] = 3
  A[2] = 6
  A[3] = 4
  A[4] = 1
  A[5] = 2

the function should return 5.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * MissingInteger task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingREWHQK-9X7/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Non-empty zero-indexed array A
 *
 * @return int Minimal positive integer that does not occur in A
 */
function solution($A)
{
    // Positive unique integers
    $positiveUnique = [];
    foreach ($A as $integer) {
        // If integer is positive, and not already in array
        if ($integer > 0 && empty($positiveUnique[$integer])) {
            $positiveUnique[$integer] = $integer;
        }
    }

    if (count($positiveUnique) === 0) {
        // If there are no positive integers, then the minimum positive integer not found is 1
        $minPositiveNotOccurInA = 1;
    } else {
        // If there are positive integers

        // Maximum positive unique integer
        $maxPositiveInteger = max($positiveUnique);

        // If sequence like this $A = [1, 2, 3, 4] is given, first missing positive integer is bigger
        // than maximum positive unique integer, that is the reason why first missing positive integer
        // is initialized to $maxPositiveInteger + 1
        $minPositiveNotOccurInA = $maxPositiveInteger + 1;

        // First integer which is not in the $positiveUnique array is searched for;
        // upper limit is the maximum positive unique integer
        for ($i = 1; $i < $maxPositiveInteger; $i++) {
            if (!isset($positiveUnique[$i])) {
                $minPositiveNotOccurInA = $i;
                break;
            }
        }
    }

    return $minPositiveNotOccurInA;
}
