<?php

/*
Write a function:

    function solution($A); 

that, given a non-empty zero-indexed array A of N integers, 
returns the minimal positive integer that does not occur in A.

For example, given:

  A[0] = 1    
  A[1] = 3    
  A[2] = 6
  A[3] = 4    
  A[4] = 1    
  A[5] = 2

the function should return 5.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: 
 * https://codility.com/demo/results/demo59YX59-S3E/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
	// positive unique integers 
	$positiveUnique = array();
	for($i = 0; $i < count($A); $i++)
		// if integer is positive, and not already in array
		if($A[$i] > 0 && empty($positiveUnique[$A[$i]]))
			// $positiveUnique array key matches value
			$positiveUnique[$A[$i]] = $A[$i];

	// if there is no positive integers, then the minimum positive integer not found is 1
	if(count($positiveUnique) === 0)
		return 1;
	// if there are positive integers
	else
	{
		// maximum positive unique integer
		$max = max($positiveUnique);
		// we are searching the first integer which is not in the $positiveUnique array
		// upper iteration limit is maximum positive unique integer 
		// because we are searching first missing one till the maximum
		for($i = 1; $i < $max; $i++)
			if(empty($positiveUnique[$i]))
				return $i;	
	}

	// if we have situation like this $A = [1, 2, 3, 4], first missing one is bigger then maximum
	return $max + 1;
}