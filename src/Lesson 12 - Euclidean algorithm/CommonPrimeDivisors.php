<?php

/*
A prime is a positive integer X that has exactly two distinct divisors: 1 and X.
The first few prime integers are 2, 3, 5, 7, 11 and 13.

A prime D is called a prime divisor of a positive integer P
if there exists a positive integer K such that D * K = P.
For example, 2 and 5 are prime divisors of 20.

You are given two positive integers N and M. The goal is to check whether
the sets of prime divisors of integers N and M are exactly the same.

For example, given:

N = 15 and M = 75, the prime divisors are the same: {3, 5};
N = 10 and M = 30, the prime divisors aren't the same: {2, 5} is not equal to {2, 3, 5};
N = 9 and M = 5, the prime divisors aren't the same: {3} is not equal to {5}.

Write a function:

function solution($A, $B);

that, given two non-empty arrays A and B of Z integers, returns the number of positions K
for which the prime divisors of A[K] and B[K] are exactly the same.

For example, given:

    A[0] = 15   B[0] = 75
    A[1] = 10   B[1] = 30
    A[2] = 3    B[2] = 5

the function should return 1, because only one pair (15, 75) has the same set of prime divisors.

Assume that:
    Z is an integer within the range [1..6,000];
    each element of arrays A, B is an integer within the range [1..2,147,483,647].

Complexity:
    expected worst-case time complexity is O(Z*log(max(A)+max(B))2);
    expected worst-case space complexity is O(1)
    (not counting the storage required for input arguments).
*/

/**
 * CommonPrimeDivisors task.
 *
 * CODILITY ANALYSIS: https://app.codility.com/demo/results/trainingM2PUUU-CMV/
 * LEVEL: MEDIUM
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param array $A Non-empty array A of Z integers
 * @param array $B Non-empty array B of Z integers
 *
 * @return int the number of positions K for which the prime divisors of A[K] and B[K] are exactly the same
 */
function solution($A, $B)
{
    $equalPositions = 0;

    $Z = count($A);

    for ($i = 0; $i < $Z; $i++) {
        if (arePrimeDivisorsEqual($A[$i], $B[$i])) {
            $equalPositions += 1;
        }
    }

    return $equalPositions;
}

/**
 * Checks if prime divisors are equal.
 *
 * @param int $N
 * @param int $M
 *
 * @return bool
 */
function arePrimeDivisorsEqual(int $N, int $M): bool
{
    // Greatest common divisor contains all common prime divisors
    $gcd = gcd($N, $M);

    // If all prime divisors are not common
    if (removeCommonPrimeDivisors($N, $gcd) != 1) {
        return false;
    }

    // If all prime divisors are not common
    if (removeCommonPrimeDivisors($M, $gcd) != 1) {
        return false;
    }

    return true;
}

/**
 * Remove common prime divisors.
 *
 * @param int $a
 * @param int $b
 *
 * @return int
 */
function removeCommonPrimeDivisors(int $a, int $b): int
{
    while ($a != 1) {
        $gcd = gcd($a, $b);
        // If there are no more more common prime divisors
        if ($gcd == 1) {
            break;
        }

        $a /= $gcd;
    }

    return $a;
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
