<?php

/*
A DNA sequence can be represented as a string consisting of the letters A, C, G and T,
which correspond to the types of successive nucleotides in the sequence.
Each nucleotide has an impact factor, which is an integer.
Nucleotides of types A, C, G and T have impact factors of 1, 2, 3 and 4, respectively.
You are going to answer several queries of the form: What is the minimal impact factor of nucleotides
contained in a particular part of the given DNA sequence?

The DNA sequence is given as a non-empty string S = S[0]S[1]...S[N-1] consisting of N characters.
There are M queries, which are given in non-empty arrays P and Q, each consisting of M integers.
The K-th query (0 ≤ K < M) requires you to find the minimal impact factor of nucleotides contained
in the DNA sequence between positions P[K] and Q[K] (inclusive).

For example, consider string S = CAGCCTA and arrays P, Q such that:

    P[0] = 2    Q[0] = 4
    P[1] = 5    Q[1] = 5
    P[2] = 0    Q[2] = 6

The answers to these M = 3 queries are as follows:

        The part of the DNA between positions 2 and 4 contains nucleotides G and C (twice),
        whose impact factors are 3 and 2 respectively, so the answer is 2.
        The part between positions 5 and 5 contains a single nucleotide T,
        whose impact factor is 4, so the answer is 4.
        The part between positions 0 and 6 (the whole string) contains all nucleotides,
        in particular nucleotide A whose impact factor is 1, so the answer is 1.

Write a function:

    function solution($S, $P, $Q);

that, given a non-empty zero-indexed string S consisting of N characters
and two non-empty zero-indexed arrays P and Q consisting of M integers,
returns an array consisting of M integers specifying the consecutive answers to all queries.

The sequence should be returned as:

        a Results structure (in C), or
        a vector of integers (in C++), or
        a Results record (in Pascal), or
        an array of integers (in any other programming language).

For example, given the string S = CAGCCTA and arrays P, Q such that:

    P[0] = 2    Q[0] = 4
    P[1] = 5    Q[1] = 5
    P[2] = 0    Q[2] = 6

the function should return the values [2, 4, 1], as explained above.

Assume that:
        N is an integer within the range [1..100,000];
        M is an integer within the range [1..50,000];
        each element of arrays P, Q is an integer within the range [0..N − 1];
        P[K] ≤ Q[K], where 0 ≤ K < M;
        string S consists only of upper-case English letters A, C, G, T.

Complexity:
        expected worst-case time complexity is O(N+M);
        expected worst-case space complexity is O(N),
        beyond input storage (not counting the storage required for input arguments).

Elements of input arrays can be modified.
*/

/**
 * GenomicRangeQuery task.
 *
 * CODILITY ANALYSIS: https://codility.com/demo/results/trainingPEQFET-XQX/
 * LEVEL: MEDIUM
 * Correctness: 100%
 * Performance: 100%
 * Task score:  100%
 *
 * @param string $S Non-empty zero-indexed string S consisting of N characters
 * @param int[] $P Zero-indexed array P consisting of M integers
 * @param int[] $Q Zero-indexed array Q consisting of M integers
 *
 * @return int[] An array consisting of M integers specifying the consecutive answers to all queries
 */
function solution($S, $P, $Q)
{
    // Supported nucleotide types with their impact factor
    $supportedNucleotideTypes = getSupportedNucleotideTypes();
    // Number of DNA subsequences which are defined by array $P and $Q
    $M = count($P);
    // DNA sequence impact factors count to some position, including the position also
    $dnaSequenceImpactFactorCountToPosition = getDNASequenceImpactFactorCountToPosition($S);

    // Minimal impact factor of nucleotides contained in the DNA sequence between positions P[K] and Q[K]
    $minSubsequenceImpactFactors = [];

    // Iterating through DNA subsequences
    for ($i = 0; $i < $M; $i++) {
        // Subsequence start position
        $start = $P[$i];
        // Subsequence end position
        $end = $Q[$i];

        // Iterating through supported nucleotide types, impact factors in given array are ordered ascending,
        // that is important because we are searching for minimal impact factor in subsequence
        foreach ($supportedNucleotideTypes as $impactFactor) {
            // Impact factor occurrences before subsequence start
            $impactFactorCountBeforeSubsequenceStart =
                isset($dnaSequenceImpactFactorCountToPosition[$impactFactor][$start - 1])
                    ? $dnaSequenceImpactFactorCountToPosition[$impactFactor][$start - 1]
                    : 0;
            // Impact factor occurrences after subsequence end
            $impactFactorCountAfterSubsequenceEnd =
                isset($dnaSequenceImpactFactorCountToPosition[$impactFactor][$end])
                    ? $dnaSequenceImpactFactorCountToPosition[$impactFactor][$end]
                    : 0;

            // If impact factor occurrences increased in given subsequence,
            // this is minimal impact factor for this subsequence
            if ($impactFactorCountAfterSubsequenceEnd > $impactFactorCountBeforeSubsequenceStart) {
                $minSubsequenceImpactFactors[$i] = $impactFactor;
                break;
            }
        }
    }

    return $minSubsequenceImpactFactors;
}

/**
 * Gets supported nucleotide types with their impact factor.
 * Nucleotide impact factors are ordered ascending, from minimum to maximum.
 *
 * @return int[] Key is nucleotide type, value is impact factor
 */
function getSupportedNucleotideTypes(): array
{
    return [
        'A' => 1,
        'C' => 2,
        'G' => 3,
        'T' => 4,
    ];
}

/**
 * Gets DNA sequence impact factors count to some position, including the position also.
 *
 * @param string $S Non-empty zero-indexed string S consisting of N characters
 *
 * @return array DNA sequence impact factors count to some position, array structure:
 * [
 *      impact factor 1 => [number of occurences till and including the position 1, ... the position 2, ...]
 *      impact factor 2 => [number of occurences till and including the position 1, ... the position 2, ...]
 *      impact factor 3 => [number of occurences till and including the position 1, ... the position 2, ...]
 *      impact factor 4 => [number of occurences till and including the position 1, ... the position 2, ...]
 * ]
 */
function getDNASequenceImpactFactorCountToPosition(string $S): array
{
    $dnaSequence = str_split($S);
    // Supported nucleotide types with their impact factor
    $supportedNucleotideTypes = getSupportedNucleotideTypes();

    // DNA sequence impact factors count to some position, including the position also
    $dnaSequenceImpactFactorCountToPosition = [];

    // Iterating through supported nucleotide types
    foreach ($supportedNucleotideTypes as $impactFactor) {
        // Iterating through every nucleotide in DNA sequence
        foreach ($dnaSequence as $position => $nucleotide) {
            $nucleotideImpactFactor = getImpactFactorForNucleotide($nucleotide);

            if ($impactFactor === $nucleotideImpactFactor) {
                // If current position has current iteration impact factor

                if (isset($dnaSequenceImpactFactorCountToPosition[$impactFactor])) {
                    // If this is not first nucleotide occurrence, we increase occurrence count
                    $dnaSequenceImpactFactorCountToPosition[$impactFactor][$position] =
                        end($dnaSequenceImpactFactorCountToPosition[$impactFactor]) + 1;
                } else {
                    // If this is first nucleotide occurrence
                    $dnaSequenceImpactFactorCountToPosition[$impactFactor][$position] = 1;
                }
            } else {
                // If current position has not current iteration impact factor

                if (isset($dnaSequenceImpactFactorCountToPosition[$impactFactor])) {
                    $dnaSequenceImpactFactorCountToPosition[$impactFactor][$position] =
                        end($dnaSequenceImpactFactorCountToPosition[$impactFactor]);
                } else {
                    $dnaSequenceImpactFactorCountToPosition[$impactFactor][$position] = 0;
                }
            }
        }
    }

    return $dnaSequenceImpactFactorCountToPosition;
}

/**
 * Gets impact factor for given nucleotide.
 *
 * @param string $nucleotide
 *
 * @return int Impact factor for given nucleotide
 */
function getImpactFactorForNucleotide(string $nucleotide): int
{
    $supportedNucleotideTypes = getSupportedNucleotideTypes();
    $impactFactor = $supportedNucleotideTypes[$nucleotide];

    return $impactFactor;
}
