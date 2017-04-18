<?php

namespace App;


class Puzzle
{
    /**
     * Letters with a larger array index have larger value.
     */
    public $letters = ['A', 'B', 'C', 'D'];

    protected $columnLabels = ['A', 'B', 'C', 'D'];

    public $rows = [];

    public function __construct(String $requestString)
    {
        $textRows = array_slice(explode("\n", urldecode($requestString)),2); // Discard the 1st 2 rows of header info
        foreach($textRows as $sentence) 
        {
            if($sentence != "") {
                $this->pushRow($sentence);
            }
        }
    }


    public function pushRow($sentence)
    {
        $row = str_split($sentence);
        $this->rows[array_shift($row)] = $row;
    }


    public function sortLetters()
    {
        foreach($this->letters as $rowLetter)
        {
            foreach($this->rows[$rowLetter] as $i => $symbol)
            {
                $columnLetter = $this->columnLabels[$i];
                $this->setLetterPosition($columnLetter, $symbol, $rowLetter);
            }
        }
    }


    private function setLetterPosition($columnLetter, $symbol, $rowLetter)
    {
        $rowLetterIndex = $this->indexOf($rowLetter);
        $columnLetterIndex = $this->indexOf($columnLetter);

        switch($symbol) {
            case '>':
                // Signifies that the column letter should be greater than the row letter
                if($rowLetterIndex > $columnLetterIndex) {
                   $this->swap($rowLetterIndex, $columnLetterIndex);
                }
                break;

            case '<':
                // Signifies that the row letter should be greater than the column letter
                if($columnLetterIndex > $rowLetterIndex) {
                   $this->swap($rowLetterIndex, $columnLetterIndex);
                }
                break;
        }
    }

    private function compare($columnLetter, $rowLetter)
    {
        $rowLetterIndex = $this->indexOf($rowLetter);
        $columnLetterIndex = $this->indexOf($columnLetter);

        if($rowLetterIndex === $columnLetterIndex) {
            return '=';
        }

        if($columnLetterIndex > $rowLetterIndex) {
            return '>';
        }

        if($columnLetterIndex < $rowLetterIndex) {
            return '<';
        }
    }

    private function populateMatrixWithSymbols()
    {
        foreach($this->rows as $rowLetter => $symbols)
        {
            foreach($symbols as $columnIndex => $symbol)
            {
                $columnLetter = $this->columnLabels[$columnIndex];

                if($symbol === '-') {
                    $this->rows[$rowLetter][$columnIndex] = $this->compare($columnLetter, $rowLetter);
                }
            }
        }
    }

    private function swap($index1, $index2)
    {
        $letter1 = $this->letters[$index1];
        $this->letters[$index1] = $this->letters[$index2];
        $this->letters[$index2] = $letter1;
    }

    private function indexOf($letter)
    {
        return array_search($letter, $this->letters);
    }

    public function solution()
    {
        // Sort letters
        $this->sortLetters();

        // Populate matrix with missing symbols
        $this->populateMatrixWithSymbols();

        // Construct response from matrix
        return $this->rows;
    }

}
