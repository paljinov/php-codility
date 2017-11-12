<?php

/*
A non-empty zero-indexed array A consisting of N integers is given.

A peak is an array element which is larger than its neighbours. More precisely, it is an index P such that
0 < P < N - 1 and A[P - 1] < A[P] > A[P + 1].

For example, the following array A:

    A[0] = 1
    A[1] = 5
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

has exactly four peaks: elements 1, 3, 5 and 10.

You are going on a trip to a range of mountains whose relative heights are represented by array A,
as shown in a figure below. You have to choose how many flags you should take with you. The goal
is to set the maximum number of flags on the peaks, according to certain rules.

PEAKS:
https://codility-frontend-prod.s3.amazonaws.com/media/task_img/flags/media/auto/mpd4a55575fdd9738489d6c0b8b544f648.png

Flags can only be set on peaks. What's more, if you take K flags, then the distance between any two
flags should be greater than or equal to K. The distance between indices P and Q is the absolute value |P - Q|.

For example, given the mountain range represented by array A, above, with N = 12, if you take:

        two flags, you can set them on peaks 1 and 5;
        three flags, you can set them on peaks 1, 5 and 10;
        four flags, you can set only three flags, on peaks 1, 5 and 10.

You can therefore set a maximum of three flags in this case.

Write a function:

    int solution(int A[], int N);

that, given a non-empty zero-indexed array A of N integers,
returns the maximum number of flags that can be set on the peaks of the array.

For example, the following array A:

    A[0] = 1
    A[1] = 5
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

the function should return 3, as explained above.

Assume that:
        N is an integer within the range [1..200,000];
        each element of array A is an integer within the range [0..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * Flags task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingF8UWBA-NJQ/
 * LEVEL: MEDIUM
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Non-empty zero-indexed array A of N integers
 *
 * @return int The maximum number of flags that can be set on the peaks of the array
 */
function solution($A)
{
    $N = count($A);
    $next = nextPeakPosition($A);

    // The maximum number of flags that can be set on the peaks of the array
    $maxFlags = 0;

    $i = 1;
    // For every index $i we cannot take more than $i flags and set more than (N / $i) + 1 flags
    while (($i - 1) * $i <= $N) {
        // Flags number
        $flagsNum = 0;

        $position = 1;
        while ($position < $N && $flagsNum < $i) {
            $position = $next[$position];
            // If there is no next peak
            if ($position == -1) {
                break;
            }

            $flagsNum += 1;
            $position += $i;
        }

        if ($flagsNum > $maxFlags) {
            $maxFlags = $flagsNum;
        }

        $i += 1;
    }

    return $maxFlags;
}

/**
 * Next peak positions, except first 0, and last N - 1 position. Position with peak has its own position as
 * next peak position. First and last position doesn't have both neighbours so they cannot be peaks.
 * If there is no next peak next peak position is set to -1.
 *
 * @param array $A
 *
 * @return array
 * [
 *     1 => int next peak position or -1,
 *     2 => int next peak position or -1,
 *     ...
 *     N - 1 int next peak position or -1,
 * ]
 */
function nextPeakPosition(array $A)
{
    $peaks = getPeaks($A);
    $N = count($A);

    // If there is no next peak next peak position is set to -1
    $next = array_fill(1, $N - 1, -1);
    // Setting next peak position, position with peak has its own position as next peak position
    for ($i = $N - 2; $i > 0; $i--) {
        if (isset($peaks[$i])) {
            $next[$i] = $i;
        } else {
            $next[$i] = $next[$i + 1];
        }
    }
    ksort($next);

    return $next;
}

/**
 * Get peaks.
 *
 * @param array $A
 *
 * @return array Peaks
 * [
 *     int position => int peak,
 *     ...
 * ]
 */
function getPeaks(array $A): array
{
    $peaks = [];

    for ($i = 1; $i < count($A) - 1; $i++) {
        // If mountain top is larger than its neighbours
        if ($A[$i] > $A[$i - 1] && $A[$i] > $A[$i + 1]) {
            $peaks[$i] = $A[$i];
        }
    }

    return $peaks;
}
