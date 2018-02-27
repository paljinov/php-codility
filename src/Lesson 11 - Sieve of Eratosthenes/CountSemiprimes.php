<?php

/*
A prime is a positive integer X that has exactly two distinct divisors: 1 and X.
The first few prime integers are 2, 3, 5, 7, 11 and 13.

A semiprime is a natural number that is the product of two (not necessarily distinct) prime numbers.
The first few semiprimes are 4, 6, 9, 10, 14, 15, 21, 22, 25, 26.

You are given two non-empty zero-indexed arrays P and Q, each consisting of M integers.
These arrays represent queries about the number of semiprimes within specified ranges.

Query K requires you to find the number of semiprimes within the range (P[K], Q[K]),
where 1 ≤ P[K] ≤ Q[K] ≤ N.

For example, consider an integer N = 26 and arrays P, Q such that:

    P[0] = 1    Q[0] = 26
    P[1] = 4    Q[1] = 10
    P[2] = 16   Q[2] = 20

The number of semiprimes within each of these ranges is as follows:

        (1, 26) is 10,
        (4, 10) is 4,
        (16, 20) is 0.

Write a function:

    function solution($N, $P, $Q);

that, given an integer N and two non-empty zero-indexed arrays P and Q consisting of M integers,
returns an array consisting of M elements specifying the consecutive answers to all the queries.

For example, given an integer N = 26 and arrays P, Q such that:

    P[0] = 1    Q[0] = 26
    P[1] = 4    Q[1] = 10
    P[2] = 16   Q[2] = 20

the function should return the values [10, 4, 0], as explained above.

Assume that:
        N is an integer within the range [1..50,000];
        M is an integer within the range [1..30,000];
        each element of arrays P, Q is an integer within the range [1..N];
        P[i] ≤ Q[i].

Complexity:
        expected worst-case time complexity is O(N*log(log(N))+M);
        expected worst-case space complexity is O(N+M),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * Count semiprimes task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingM586YP-6MT/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score  100%
 *
 * @param int $N Semiprimes upper boundary
 * @param array $P Non-empty zero-indexed array P consisting of M integers
 * @param array $Q Non-empty zero-indexed array Q consisting of M integers
 *
 * @return array array consisting of M elements specifying the number of semiprimes within each of these ranges
 */
function solution($N, $P, $Q)
{
    // Primes from 2 to N
    $primes = getPrimes($N);
    // Semiprimes from 2 to $N
    $semiprimes = getSemiprimes($N, $primes);

    // This $semiprimes array reorganization is very important for later speed
    // when we will use isset/array_key_exists instead of array_search function for
    // searching semiprime inside some range, because it is much faster;
    // isset/array_key_exists Big-O is really close to O(1), and array_search Big-O is O(n)
    // first we sort array by key, and value of every key marks array position, starting from 1

    $semiprimes = array_flip($semiprimes);

    // $P and $Q have $M number of elements
    $M = count($P);
    // Number of semiprimes in given range
    $rangeSemiprimesCount = [];
    // Iterating through $P[$i] and $Q[$i] ranges
    for ($i = 0; $i < $M; $i++) {
        $leftKey = null;
        $rightKey = null;

        $range = $Q[$i] - $P[$i];

        // Looking for the first left semiprime key which is higher or equal than $P[$i]
        if (isset($semiprimes[$P[$i]])) {
            $leftKey = $P[$i];
        } else {
            for ($j = 1; $j <= $range; $j++) {
                if (isset($semiprimes[$P[$i] + $j])) {
                    $leftKey = $P[$i] + $j;
                    break;
                }
            }
        }

        // Looking for the first right semiprime key which is equal or lower than $Q[$i]
        if (isset($semiprimes[$Q[$i]])) {
            $rightKey = $Q[$i];
        } else {
            for ($j = 1; $j <= $range; $j++) {
                if (isset($semiprimes[$Q[$i] - $j])) {
                    $rightKey = $Q[$i] - $j;
                    break;
                }
            }
        }

        if ($leftKey === null || $rightKey === null) {
            // If no semiprimes exist within range

            $rangeSemiprimesCount[$i] = 0;
        } elseif ($rightKey === $leftKey) {
            // Example for $P[$i] = 4, $Q[$i] = 4, one boundary semiprime exist

            $rangeSemiprimesCount[$i] = 1;
        } else {
            // Boundary semiprimes are counted too

            $rangeSemiprimesCount[$i] = $semiprimes[$rightKey] - $semiprimes[$leftKey] + 1;
        }
    }

    return $rangeSemiprimesCount;
}

/**
 * Gets primes from 2 to upper boundary.
 *
 * @param int $N Upper boundary
 *
 * @return array Primes
 */
function getPrimes(int $N): array
{
    // First $primes array is filled with consecutive integers from 2 to N
    $primes = [];
    for ($i = 2; $i <= $N; $i++) {
        $primes[$i] = $i;
    }

    // Sieve of Eratosthenes algorithm is used to filter prime integers
    $i = 2;
    while ($i * $i <= $N) {
        // Starting from first integer multiple, for example,
        // if integer is 2, we start from 4
        // if integer is 3, we start from 6, etc.,
        // and remove every integer multiple, after last iteration, only primes remain
        for ($j = 2 * $i; $j <= $N; $j += $i) {
            unset($primes[$j]);
        }
        $i++;
    }
    // Keys are stripped from array, to get zero-indexed array
    $primes = array_values($primes);

    return $primes;
}

/**
 * Gets semiprimes from 2 to upper boundary.
 *
 * @param int $N Upper boundary
 *
 * @return array Semiprimes
 */
function getSemiprimes(int $N, array $primes): array
{
    // Semiprimes from 2 to $N
    $semiprimes = [];

    // Semiprime is multiplication of 2 primes, it can be 2 same or 2 distinct primes
    // for example, if prime is 2, semiprimes are,
    // 2 * 2 = 4
    // 2 * 3 = 6, etc.
    for ($i = 0; $i < count($primes); $i++) {
        for ($j = $i; $j < count($primes); $j++) {
            $primesProduct = $primes[$i] * $primes[$j];
            if ($primesProduct <= $N) {
                $semiprimes[] = $primesProduct;
            } else {
                break;
            }
        }
    }
    sort($semiprimes);

    return $semiprimes;
}
