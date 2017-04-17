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

/**
 * Brackets task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingS2PXXF-BVW/
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
    // Opening brackets, keys are given by bracket type
    $openingBrackets = ['braces' => '{', 'square ' => '[', 'parentheses' => '('];
    // Closing brackets, keys are given by bracket type
    $closingBrackets = ['parentheses' => ')', 'square ' => ']', 'braces' => '}'];

    // Iterating through brackets
    foreach ($brackets as $bracket) {
        if (in_array($bracket, $openingBrackets)) {
            // Opening brackets are always pushed to the stack
            array_push($bracketsStack, $bracket);
        } elseif (in_array($bracket, $closingBrackets)) {
            // Closing brackets are popped out of the stack only if brackets structure is correct

            // If there are no opening brackets, and the first bracket is closing
            if (count($bracketsStack) == 0) {
                $isProperlyNested = 0;
                break;
            } else {
                // Stack top bracket
                $stackTopBracket = $bracketsStack[count($bracketsStack) - 1];

                // Stack top bracket type
                $stackTopBracketType = array_search($stackTopBracket, $openingBrackets);
                // Current iteration bracket type
                $bracketType = array_search($bracket, $closingBrackets);

                if ($stackTopBracketType == $bracketType) {
                    // If last opening and current closing bracket are of the same type
                    array_pop($bracketsStack);
                } else {
                    // If last opening and current closing bracket are not of the same type
                    $isProperlyNested = 0;
                    break;
                }
            }
        }
    }

    // If brackets structure is correct, stack must be empty
    if (count($bracketsStack) > 0) {
        $isProperlyNested = 0;
    }

    return $isProperlyNested;
}
