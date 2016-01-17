<?php

/*
A string S consisting of N characters is considered to be properly nested 
if any of the following conditions is true:

        S is empty;
        S has the form "(U)" or "[U]" or "{U}" where U is a properly nested string;
        S has the form "VW" where V and W are properly nested strings.

For example, the string "{[()()]}" is properly nested but "([)()]" is not.

Write a function:

    function solution($S); 

that, given a string S consisting of N characters, returns 1 if S is properly nested and 0 otherwise.

For example, given S = "{[()()]}", the function should return 1 and given S = "([)()]",
the function should return 0, as explained above.

Assume that:
        N is an integer within the range [0..200,000];
        string S consists only of the following characters: "(", "{", "[", "]", "}" and/or ")".

Complexity:
        expected worst-case time complexity is O(N);
        expected worst-case space complexity is O(N) 
        (not counting the storage required for input arguments).
*/

/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demo874NSZ-HA4/
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

	// opening and closing brackets, keys are given by bracket type
	$opening = array(3 => '{', 2 => '[', 1 => '(');
	$closing = array(1 => ')', 2 => ']', 3 => '}');

	foreach($brackets as $bracket) 
	{
		// opening brackets are always pushed to the stack
		if(in_array($bracket, $opening))
			array_push($stack, $bracket);
		// closing brackets are popped out of the stack only if brackets structure is correct
		elseif(in_array($bracket, $closing))
		{
			// if there are no opening brackets, and first bracket is closing
			if(empty($stack))
				return 0;

			$stackTop = end($stack);
			// stack top bracket type must be opening
			$stackTopBracketType = array_search($stackTop, $opening);
			// current bracket type is closing
			$currentBracketType = array_search($bracket, $closing);

			// if opening and closing bracket are of the same type
			if($stackTopBracketType === $currentBracketType)
				array_pop($stack);
			// if opening and closing bracket are not of the same type
			else
				return 0;
		}
	}

	// if bracket structure is correct, stack is empty
	if(count($stack) === 0)
		return 1;
	else
		return 0;
}