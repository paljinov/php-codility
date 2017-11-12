<?php

/*
You are going to build a stone wall. The wall should be straight and N meters long, and its thickness should be
constant; however, it should have different heights in different places. The height of the wall is specified
by a zero-indexed array H of N positive integers. H[I] is the height of the wall from I to I+1 meters to the right
of its left end. In particular, H[0] is the height of the wall's left end and H[N−1] is the height of
the wall's right end.

The wall should be built of cuboid stone blocks (that is, all sides of such blocks are rectangular).
Your task is to compute the minimum number of blocks needed to build the wall.

Write a function:

    function solution($H);

that, given a zero-indexed array H of N positive integers specifying the height of the wall,
returns the minimum number of blocks needed to build it.

For example, given array H containing N = 9 integers:
    H[0] = 8    H[1] = 8    H[2] = 5
    H[3] = 7    H[4] = 9    H[5] = 8
    H[6] = 7    H[7] = 4    H[8] = 8

the function should return 7. The figure shows one possible arrangement of seven blocks.

https://codility-frontend-prod.s3.amazonaws.com/media/task_static/stone_wall/
static/images/auto/4f1cef49cc46d451e88109d449ab7975.png

Assume that:
        N is an integer within the range [1..100,000];
        each element of array H is an integer within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * StoneWall task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingEC4TTX-STF/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param int[] Zero-indexed array H of N positive integers, specifying the height of the wall at some position
 *
 * @return int The minimum number of stone blocks needed to build it
 */
function solution($H)
{
    // This task is know as "Manhattan skyline" problem.

    // The minimum number of stone blocks needed to build the wall
    $stoneBlocksCount = 0;
    // Stack of horizontal edges, such that their heights form an increasing sequence
    $stack = [];

    // Iterating through wall heights
    foreach ($H as $height) {
        // While there are stone blocks in stack, and horizontal edge is higher than current height
        while (count($stack) && $stack[count($stack) - 1] > $height) {
            // Horizontal edges which are higher than the current height are removed
            array_pop($stack);
        }

        // If stack is empty, or last stone block height is different than current height
        if (count($stack) == 0 || $stack[count($stack) - 1] != $height) {
            // Current horizontal edge is pushed to the stack
            array_push($stack, $height);
            // Stone blocks counter is increased
            $stoneBlocksCount++;
        }
    }

    return $stoneBlocksCount;
}
