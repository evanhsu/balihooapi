<?php

namespace App;

/**
 * Puzzle
 *
 * This class takes a puzzle matrix (with missing values) as input
 * and provides the completed matrix as output (by calling the `solution()` method).
 *
 * High-level solution strategy:
 * 1) Use the provided input matrix to sort the letters A, B, C, D into their proper order.
 * 2) Read back the vector of letters to complete the missing matrix values.
 */
class Puzzle
{
    protected $rowColumnLabels = ['A', 'B', 'C', 'D'];
    protected $matrix;
    protected $letters;

    public function __construct($requestString)
    {
        $this->matrix = new Matrix($this->rowColumnLabels);
        $this->letters = new Vector($this->rowColumnLabels);

        // Discard the 1st 2 rows of header info
        $textRows = array_slice(explode("\n", urldecode($requestString)), 2); 
        foreach($textRows as $sentence) 
        {
            if($sentence != "") {
                $this->matrix->pushRow($sentence);
            }
        }
    }

    private function populateMatrixWithSymbols()
    {
        $this->matrix->each(function($rowLetter, $columnLetter, $columnIndex, $symbol) {
            if($symbol === '-') {
                $this->matrix->set($rowLetter, $columnLetter, $this->letters->compare($columnLetter, $rowLetter));
            }
        });
    }

    public function solution()
    {
        // Sort letters
        do {
            $this->sortLetters();
        } while ($this->letters->isDirty());

        // Populate matrix with missing symbols
        $this->populateMatrixWithSymbols();

        // Construct response from matrix
        $response = $this->matrix->toString();

        return $response;
    }

    private function sortLetters()
    {
        $this->letters->cleanUp();
        
        foreach($this->rowColumnLabels as $rowLetter)
        {
            foreach($this->matrix->getRow($rowLetter) as $i => $symbol)
            {
                $columnLetter = $this->rowColumnLabels[$i];
                $this->letters->sortLetterPair($columnLetter, $symbol, $rowLetter);
            }
        }
    }
}
