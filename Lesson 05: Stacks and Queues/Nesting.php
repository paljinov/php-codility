<?php

/*
A string S consisting of N characters is called properly nested if:

        S is empty;
        S has the form "(U)" where U is a properly nested string;
        S has the form "VW" where V and W are properly nested strings.

For example, string "(()(())())" is properly nested but string "())" isn't.

Write a function:

    function solution($S); 

that, given a string S consisting of N characters, 
returns 1 if string S is properly nested and 0 otherwise.

For example, given S = "(()(())())", the function should return 1 and given S = "())", 
the function should return 0, as explained above.

Assume that:
        N is an integer within the range [0..1,000,000];
        string S consists only of the characters "(" and/or ")".

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(1) 
        (not counting the storage required for input arguments).
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo9SA7HA-8EE/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($S)
{
	// last open bracket must be closed first (LIFO), first open bracket must be closed last;
	// does this remind you on stack data structure ?

	// this array will be manipulated as stack data structure
	$stack = array();
	// convert brackets string to a brackets array
	$brackets = str_split($S);

	foreach($brackets as $bracket) 
	{
		// opening brackets are always pushed to the stack
		if($bracket === '(')
			array_push($stack, $bracket);
		// closing brackets are popped out of the stack
		elseif($bracket === ')')
		{
			// if there are no opening brackets, and first bracket is closing
			if(empty($stack))
				return 0;

			array_pop($stack);
		}
	}

	// if bracket structure is correct, stack is empty
	if(count($stack) === 0)
		return 1;
	else
		return 0;
}