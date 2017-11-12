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

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo6FPCUY-6BM/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($N, $P, $Q)
{
	// primes from 2 to N, first we fill $primes array with consecutive integers from 2 to N
	$primes = array();
	for($i = 2; $i <= $N; $i++)
		$primes[$i] = $i;

	// now we use sieve of Eratosthenes algorithm to filter prime integers
	$i = 2;
	while($i * $i <= $N)
	{
		// we start from first integer multiple, for example, 
		// if integer is 2, we start from 4
		// if integer is 3, we start from 6, etc.,
		// and remove every integer multiple, after last iteration, only primes remain
		for($j = $i + $i; $j <= $N; $j += $i) 
			unset($primes[$j]);
		$i++;
	}
	// we strip keys from array, to get zero-indexed array
	$primes = array_values($primes);

	// semiprime integers from 2 to $N
	$semiPrimes = array();
	// semiprime is 2 primes multiplication, it can be 2 same or distinct primes
	// for example, if prime is 2, semiprimes are, 
	// 2 * 2 = 4
	// 2 * 3 = 6, etc.
	for($i = 0; $i < count($primes); $i++)
	{
		for($j = $i; $j < count($primes); $j++)
		{
			$primesProduct = $primes[$i] * $primes[$j];
			if($primesProduct <= $N)
				$semiPrimes[$primesProduct] = $primesProduct;
			else
				break;
		}
	}

	// this $semiPrimes array reorganization is very important for later speed
	// when we will use array_key_exists function instead of array_search function for
	// searching semiprime inside some range, because it is much faster;
	// array_key_exists Big-O is really close to O(1), and array_search Big-O is O(n)
	// first we sort array by key, and value of every key marks array position, starting from 1
	ksort($semiPrimes);
	$i = 1;
	foreach($semiPrimes as $value)
	{
		$semiPrimes[$value] = $i;
		$i++;
	}

	// $P and $Q have $M number of elements
	$M = count($P);
	// number of semiprimes in given range
	$rangeSemiprimesCount = array();
	// iterating through $P[$i] and $Q[$i] ranges
	for($i = 0; $i < $M; $i++)
	{
		$leftKey = null;
		$rightKey = null;

		$range = $Q[$i] - $P[$i];

		// we are looking for first left semiprime key which is higher or equal than $P[$i]
		if(array_key_exists($P[$i], $semiPrimes))
			$leftKey = $P[$i];
		else
		{
			for($j = 1; $j <= $range; $j++)
				if(array_key_exists($P[$i] + $j, $semiPrimes))
				{
					$leftKey = $P[$i] + $j;
					break;
				}
		}

		// we are looking for first right semiprime key which is equal or lower than $Q[$i]
		if(array_key_exists($Q[$i], $semiPrimes))
			$rightKey = $Q[$i];
		else
		{
			for($j = 1; $j <= $range; $j++)
				if(array_key_exists($Q[$i] - $j, $semiPrimes))
				{
					$rightKey = $Q[$i] - $j;
					break;
				}
		}

		//  if no semiprimes exist within range
		if($leftKey === null || $rightKey === null)
			$rangeSemiprimesCount[$i] = 0;
		// example for $P[$i] = 4, $Q[$i] = 4, one boundary semiprime exist 
		elseif($rightKey === $leftKey)
			$rangeSemiprimesCount[$i] = 1;
		else
			// we count boundary semiprimes too
			$rangeSemiprimesCount[$i] = $semiPrimes[$rightKey] - $semiPrimes[$leftKey] + 1;
	}

	return $rangeSemiprimesCount;
}