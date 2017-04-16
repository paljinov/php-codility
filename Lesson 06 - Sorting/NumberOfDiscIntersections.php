<?php

/*
We draw N discs on a plane. The discs are numbered from 0 to N − 1. A zero-indexed array A of N non-negative integers,
specifying the radiuses of the discs, is given. The J-th disc is drawn with its center at (J, 0) and radius A[J].

We say that the J-th disc and K-th disc intersect if J ≠ K and the J-th and K-th discs have at least one common point
(assuming that the discs contain their borders).

The figure below shows discs drawn for N = 6 and A as follows:

    A[0] = 1
    A[1] = 5
    A[2] = 2
    A[3] = 1
    A[4] = 4
    A[5] = 0

https://codility-frontend-prod.s3.amazonaws.com/media/task_static/
number_of_disc_intersections/static/images/auto/0eed8918b13a735f4e396c9a87182a38.png

There are eleven (unordered) pairs of discs that intersect, namely:

    discs 1 and 4 intersect, and both intersect with all the other discs;
    disc 2 also intersects with discs 0 and 3.

Write a function:

    function solution($A);

that, given an array A describing N discs as explained above, returns the number of (unordered) pairs of
intersecting discs. The function should return −1 if the number of intersecting pairs exceeds 10,000,000.

Given array A shown above, the function should return 11, as explained above.

Assume that:
        N is an integer within the range [0..100,000];
        each element of array A is an integer within the range [0..2,147,483,647].

Complexity:
        expected worst-case time complexity is O(N*log(N));
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * NumberOfDiscIntersections task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingAGQ6SY-PCU/
 * LEVEL: MEDIUM
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param int[] Zero-indexed array A of N non-negative integers, specifying the radiuses of the discs
 *
 * @return int The number of (unordered) pairs of intersecting discs,
 * or −1 if the number of intersecting pairs exceeds 10,000,000
 */
function solution($A)
{
    // All discs centers are on x-coordinate (abscissa) of coordinate system

    // The number of intersecting discs
    $intersectingDiscsCount = 0;
    // The number of discs which started at some position
    $discStartPositionCount = array_fill(0, count($A), 0);
    // The number of discs which ended at some position
    $discEndPositionCount = array_fill(0, count($A), 0);

    // Iterating through discs
    foreach ($A as $center => $radius) {
        // Disc start position, if it is on negative side of x-coordinate, we set it to 0
        $discStartPosition = max(0, $center - $radius);
        // Disc end position, if it is larger than max center, we set it to largest positive center
        $discEndPosition = min(count($A) - 1, $center + $radius);

        // The number of discs which started at some position
        $discStartPositionCount[$discStartPosition]++;
        // The number of discs which ended at some position
        $discEndPositionCount[$discEndPosition]++;
    }

    // Discs count at some position which are already started, but not yet ended (current discs)
    $startedButNotEndedDiscsCount = 0;
    // Iterating through discs
    foreach ($A as $center => $radius) {
        // If there are discs which start on this disc center
        if ($discStartPositionCount[$center] > 0) {
            // Current discs multiplied by count of discs which started at current center position
            $intersectingDiscsCount += $startedButNotEndedDiscsCount * $discStartPositionCount[$center];
            // Intersections of already started discs
            // Gauss sum formula n(n + 1)/2, where n = $discStartPositionCount[$center] - 1, which leads to:
            // ($discStartPositionCount[$center] - 1) * [($discStartPositionCount[$center] - 1) + 1] / 2
            $intersectingDiscsCount += $discStartPositionCount[$center] * ($discStartPositionCount[$center] - 1) / 2;

            // If the number of intersecting pairs exceeds 10,000,000
            if ($intersectingDiscsCount > 10000000) {
                $intersectingDiscsCount = -1;
                break;
            }

            $startedButNotEndedDiscsCount += $discStartPositionCount[$center];
        }

        $startedButNotEndedDiscsCount -= $discEndPositionCount[$center];
    }

    return $intersectingDiscsCount;
}
