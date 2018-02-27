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

Image location:
https://codility-frontend-prod.s3.amazonaws.com/media/task_img/
number_of_disc_intersections/media/auto/mpaecfada7c1e52a7b01b04916c859b15d.png

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

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/training7MU3DF-BNW/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
    // number of intersecting discs
    $intersections = 0;

    // for every point on X axis we count how many disc starts we have
    $discStartPoints = [];
    // for every point on X axis we count how many disc ends we have
    $discEndPoints = [];

    // we count repetitions of disc starts and disc ends on some point
    foreach ($A as $xCenter => $discRadius) {
        // if the disc started before the point 0 we act as it started at point 0
        $start = $xCenter - $discRadius < 0 ? 0 : $xCenter - $discRadius;
        // if the disc ended after the last disc center point we act as it ended on last disc center point
        $end = $xCenter + $discRadius > count($A) - 1 ? count($A) - 1 : $xCenter + $discRadius;

        $discStartPoints[$start] = isset($discStartPoints[$start]) ? $discStartPoints[$start] + 1 : 1;
        $discEndPoints[$end] = isset($discEndPoints[$end]) ? $discEndPoints[$end] + 1 : 1;
    }

    // difference between number of discs which are started before some point and that end at some point or later
    $discsBetweenPoints = 0;
    foreach ($A as $xCenter => $discRadius) {
        // discs started at this point
        $startedDiscs = isset($discStartPoints[$xCenter]) ? $discStartPoints[$xCenter] : 0;
        // discs ended at this point
        $endedDiscs = isset($discEndPoints[$xCenter]) ? $discEndPoints[$xCenter] : 0;

        // the number of discs started before this point which are not ended yet,
        // multiplied by the number of discs started at this point
        $intersections += $discsBetweenPoints * $startedDiscs;
        // the number of discs started at this point multiplied by number of discs started at this point
        // minus one and divided by 2 to avoid counting double intersections (discs started at the same point)
        $intersections += ($startedDiscs * ($startedDiscs - 1)) / 2;

        // discs between points is calculated by adding difference between
        // discs started at this point and discs ended in this point
        $discsBetweenPoints += $startedDiscs - $endedDiscs;

        // if the number of intersecting discs exceeds 10,000,000 the function should return −1
        if ($intersections > 10000000) {
            return -1;
        }
    }

    return $intersections;
}
