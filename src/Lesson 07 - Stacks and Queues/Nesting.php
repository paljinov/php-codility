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

/**
 * Nesting task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingSJXXAC-5A6/
 * LEVEL: EASY
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param string $S String S consisting of N characters
 *
 * @return int 1 if S is properly nested and 0 otherwise
 */
function solution($S)
{
    // Last open bracket must be closed first (LIFO), first open bracket must be closed last,
    // these are the characteristics of the stack data structure

    // Initializing properly nested to 1 (true)
    $isProperlyNested = 1;
    $bracketsStack = [];

    // Converts brackets string to a brackets array
    $brackets = str_split($S);

    // Iterating through brackets
    foreach ($brackets as $bracket) {
        if ($bracket === '(') {
            // Opening brackets are always pushed to the stack
            array_push($bracketsStack, $bracket);
        } elseif ($bracket === ')') {
            // Closing brackets are popped out of the stack

            // If there are no opening brackets, and first bracket is closing
            if (empty($bracketsStack)) {
                $isProperlyNested = 0;
                break;
            } else {
                array_pop($bracketsStack);
            }
        }
    }

    // If brackets structure is correct, stack must be empty
    if (count($bracketsStack) != 0) {
        $isProperlyNested = 0;
    }

    return $isProperlyNested;
}
