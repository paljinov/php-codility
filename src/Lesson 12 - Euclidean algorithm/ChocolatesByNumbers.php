<?php

/*
Two positive integers N and M are given.
Integer N represents the number of chocolates arranged in a circle, numbered from 0 to N − 1.

You start to eat the chocolates. After eating a chocolate you leave only a wrapper.

You begin with eating chocolate number 0.
Then you omit the next M − 1 chocolates or wrappers on the circle, and eat the following one.

More precisely, if you ate chocolate number X,
then you will next eat the chocolate with number (X + M) modulo N (remainder of division).

You stop eating when you encounter an empty wrapper.

For example, given integers N = 10 and M = 4. You will eat the following chocolates: 0, 4, 8, 2, 6.

The goal is to count the number of chocolates that you will eat, following the above rules.

Write a function:

    function solution($N, $M);

that, given two positive integers N and M, returns the number of chocolates that you will eat.

For example, given integers N = 10 and M = 4. the function should return 5, as explained above.

Assume that:
        N and M are integers within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(log(N+M));
        expected worst-case space complexity is O(1).
*/

/**
 * ChocolatesByNumbers task.
 *
 * CODILITY ANALYSIS: https://app.codility.com/demo/results/trainingEVHKSF-DSA/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param int $N Positive integer N represents the number of chocolates arranged in a circle
 * @param int $M Positive integer which represents how many chocolates we omit
 *
 * @return int The number of chocolates that you will eat
 */
function solution($N, $M)
{
    // First we will explain why we are looking for the greatest common divisor of $N and $M
    // we have 10 chocolates, on positions from 0 - 9, and $M which represent positions jump
    // if we start from 0, next positions we will are
    // 0 + 4 = 4 (skipping 1, 2, 3),
    // 4 + 4 = 8 (skipping 5, 6, 7),
    // 8 + 4 = 2 (skipping 9, 0, 1),
    // 2 + 4 = 6 (skipping 3, 4, 5)
    // 6 + 4 = 0 (skipping 7, 8, 9) // empty wrappper,
    // so we ate chocolates on positions 0, 4, 8, 2, 6
    
    // We can see, the full circle will close, in other words we will come to the starting position
    // after exactly: lowest common multiple of '$N = circle size' and '$M = jump' / '$M =jump' times
    // it follows: $eatenChocolates = lcm / M
    
    // Now little math:
    // lcm = N * M / gcd, where gcd is greatest common divisor
    // it follows:
    //  $eatenChocolates = (N * M / gcd) / M
    //  $eatenChocolates = N / gcd

    // For example (N = 10, M = 4):
    //  gcd = 2
    //  lcm = 10 * 4 / 2 = 20
    //  $eatenChocolates = lcm / M = 20 / 4 = 5, or
    //  $eatenChocolates = N / gcd = 10 / 2 = 5

    return $N / gcd($N, $M);
}

/**
 * Computes the greatest common divisor (gcd) of two positive integers.
 *
 * @param int $a First positive integer
 * @param int $b Second positive integer
 * 
 * @return int $a and $b greatest common divisor
 */
function gcd(int $a, int $b): int
{
    if ($a < $b) {
        return gcd($b, $a);
    }
    if ($a % $b === 0) {
        return $b;
    } else {
        return gcd($b, $a % $b);
    }
}
