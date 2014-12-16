<?php

/*
An integer N is given, representing the area of some rectangle.

The area of a rectangle whose sides are of length A and B is A * B, 
and the perimeter is 2 * (A + B).

The goal is to find the minimal perimeter of any rectangle whose area equals N. 
The sides of this rectangle should be only integers.

For example, given integer N = 30, rectangles of area 30 are:

        (1, 30), with a perimeter of 62,
        (2, 15), with a perimeter of 34,
        (3, 10), with a perimeter of 26,
        (5, 6), with a perimeter of 22.

Write a function:

    function solution($N); 

that, given an integer N, 
returns the minimal perimeter of any rectangle whose area is exactly equal to N.

For example, given an integer N = 30, the function should return 22, as explained above.

Assume that:
        N is an integer within the range [1..1,000,000,000].

Complexity:
        expected worst-case time complexity is O(sqrt(N));
        expected worst-case space complexity is O(1).
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoRE8TP2-TD7/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($N)
{
	// all combinations of rectangle sides variations
	$rectangleSideCombinations = array();

	// for example, if N = 30, 
	// A can be [1, 2, 3, 5], 
	// resulting in B which can be [30, 15, 10, 6]

	// we use formula to find half of $N divisors, we don't need to find another half, 
	// because rectangle sides would just be mirrored, 
	// respectively we would have 2 exactly the same perimeters
	$i = 1;
	$j = 0;
	while($i * $i <= $N)
	{
		if($N % $i == 0)
		{	
			$rectangleSideCombinations[$j]['A'] = $i;
			$rectangleSideCombinations[$j]['B'] = $N / $i;
			$j++;
		}
		$i++;
	}

	// minimal rectangle perimeter
	$minPerimeter = null;
	foreach($rectangleSideCombinations as $rectangleSides)
	{
		$perimeter = 2 * ($rectangleSides['A'] + $rectangleSides['B']);
		if($minPerimeter === null || $perimeter < $minPerimeter)
			$minPerimeter = $perimeter;
	}

	return $minPerimeter;
}