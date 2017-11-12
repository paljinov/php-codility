<?php

/*
A zero-indexed array A consisting of N integers is given. Rotation of the array means
that each element is shifted right by one index, and the last element of the array is also moved to the first place.

For example, the rotation of array A = [3, 8, 9, 7, 6] is [6, 3, 8, 9, 7]. The goal is to rotate array A K times;
that is, each element of A will be shifted to the right by K indexes.

Write a function:

    function solution($A, $K);

that, given a zero-indexed array A consisting of N integers and an integer K, returns the array A rotated K times.

For example, given array A = [3, 8, 9, 7, 6] and K = 3, the function should return [9, 7, 6, 3, 8].

Assume that:
        N and K are integers within the range [0..100];
        each element of array A is an integer within the range [−1,000..1,000].

In your solution, focus on correctness. The performance of your solution will not be the focus of the assessment.
*/

/**
 * CyclicRotation task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/training5G38K3-475/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: not assessed
 * Task score:  100%
 *
 * @param array $A Zero-indexed array A consisting of N integers
 * @param int $K Number of shifts to the right
 *
 * @return array Array A rotated K times to the right
 */
function solution($A, $K)
{
    // Number of integers
    $N = count($A);
    if ($N > 0 && $K > 0) {
        // If array is not empty and number of times for rotation to the right number is given

        // Shifted array
        $shifted = [];

        // If $K is bigger than $N, at $N-th shift we would be on starting position,
        // so it makes sense only to do smaller number of shifts than $N size
        $shiftCount = $K % $N;

        // Array rotation to the right, initially first element position is 0, but at the end it will be K
        for ($i = 0; $i < $N; $i++) {
            // Integer position after rotating to the right is calculated
            $position = $i + $shiftCount;
            if ($position > $N - 1) {
                $position = $position - $N;
            }

            $shifted[$position] = $A[$i];
        }

        ksort($shifted);
    } else {
        // If array is empty or number of times for rotation to the right number is zero
        $shifted = $A;
    }

    return $shifted;
}
