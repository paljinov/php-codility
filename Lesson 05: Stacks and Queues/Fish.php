<?php

/*
You are given two non-empty zero-indexed arrays A and B consisting of N integers. 
Arrays A and B represent N voracious fish in a river, ordered downstream along the flow of the river.

The fish are numbered from 0 to N − 1. If P and Q are two fish and P < Q, 
then fish P is initially upstream of fish Q. Initially, each fish has a unique position.

Fish number P is represented by A[P] and B[P]. Array A contains the sizes of the fish. 
All its elements are unique. Array B contains the directions of the fish. 
It contains only 0s and/or 1s, where:

        0 represents a fish flowing upstream,
        1 represents a fish flowing downstream.

If two fish move in opposite directions and there are no other (living) fish between them, 
they will eventually meet each other. Then only one fish can stay alive − 
the larger fish eats the smaller one. More precisely, we say that two fish P and Q meet each other 
when P < Q, B[P] = 1 and B[Q] = 0, and there are no living fish between them. After they meet:

        If A[P] > A[Q] then P eats Q, and P will still be flowing downstream,
        If A[Q] > A[P] then Q eats P, and Q will still be flowing upstream.

We assume that all the fish are flowing at the same speed. That is, fish moving in the same direction 
never meet. The goal is to calculate the number of fish that will stay alive.

For example, consider arrays A and B such that:

  A[0] = 4    B[0] = 0
  A[1] = 3    B[1] = 1
  A[2] = 2    B[2] = 0
  A[3] = 1    B[3] = 0
  A[4] = 5    B[4] = 0

Initially all the fish are alive and all except fish number 1 are moving upstream. 
Fish number 1 meets fish number 2 and eats it, then it meets fish number 3 and eats it too. 
Finally, it meets fish number 4 and is eaten by it. The remaining two fish, number 0 and 4, 
never meet and therefore stay alive.

Write a function:

    function solution($A, $B); 

that, given two non-empty zero-indexed arrays A and B consisting of N integers, 
returns the number of fish that will stay alive.

For example, given the arrays shown above, the function should return 2, as explained above.

Assume that:
        N is an integer within the range [1..100,000];
        each element of array A is an integer within the range [0..1,000,000,000];
        each element of array B is an integer that can have one of the following values: 0, 1;
        the elements of A are all distinct.

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N), 
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoQDP8KG-ZBX/
 * LEVEL: MEDIUM
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A, $B)
{
	// fish are ordered downstream along the flow of the river, 
	// at first, [0] is the most upstream fish, [N-1] is the most downstream fish
	// thereby, there are 3 possible end situations:
	//  1) all surviving fish will flow upstream
	//  2) all surviving fish will flow downstream
	//  3) some surviving fish will flow upstream, but also some fish, which had 
	//     bigger downstream river positions than surviving upstream fish will flow downstream
	//     
	// UPSTREAM															DOWNSTREAM
	// <--[0](4)		[1](3)-->		<--[2](2)		<--[3](1)		<--[3](5)

	$aliveFishCounter = 0;
	// fish that flows downstream
	$downstreamFish = array();
	for($i = 0; $i < count($A); $i++)
	{
		// if fish flows downstream
		if($B[$i] === 1)
			$downstreamFish[$i] = $A[$i];
		// if fish flows upstream
		else
		{
			// tracks whether current $A[$i] fish is eaten
			$currentFishEaten = false;
			// if there is downstream fish, and current fish is not eaten
			while(count($downstreamFish) != 0 && $currentFishEaten === false)
			{
				// position/key of nearest downstream fish
				end($downstreamFish);
				$dfp = key($downstreamFish);

				// if upstream fish is bigger than the downstream fish
				if($A[$i] > $downstreamFish[$dfp])
					unset($downstreamFish[$dfp]);
				// if upstream fish is smaller than the downstream fish
				else
					$currentFishEaten = true;
			}

			// if there is no downstream fish in front of upstream fish, upstream fish stays alive
			if(count($downstreamFish) === 0)
				$aliveFishCounter++;
		}
	}

	// if some downstream fish survived
	$aliveFishCounter += count($downstreamFish);

	return $aliveFishCounter;
}