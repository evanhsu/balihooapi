<?php

namespace App;

class Vector
{
	/**
     * Letters with a larger array index have larger value.
     */
	protected $letters;
    private $dirtySort = false;

	public function __construct(array $letters)
	{
		$this->letters = $letters;
	}

	public function compare($letter1, $letter2)
    {
        $letter1Index = $this->indexOf($letter1);
        $letter2Index = $this->indexOf($letter2);

        if($letter1Index === $letter2Index) {
            return '=';
        }

        if($letter1Index > $letter2Index) {
            return '>';
        }

        if($letter1Index < $letter2Index) {
            return '<';
        }
    }

	public function sortLetterPair($letter1, $symbol, $letter2)
    {
        $letter1Index = $this->indexOf($letter1);
        $letter2Index = $this->indexOf($letter2);

        switch($symbol) {
            case '>':
                // Signifies that letter1 should be greater than letter2
                if($letter1Index < $letter2Index) {
                    $this->swap($letter2Index, $letter1Index);
                    if(abs($letter2Index - $letter1Index) > 1) {
                        $this->dirtySort = true;
                    }
                    return true;
                }
                break;

            case '<':
                // Signifies that letter2 should be greater than letter1
                if($letter1Index > $letter2Index) {
                   $this->swap($letter2Index, $letter1Index);
                   if(abs($letter2Index - $letter1Index) > 1) {
                        $this->dirtySort = true;
                    }
                   return true;
                }
                break;
        }

        return false;
    }

    private function swap($index1, $index2)
    {
        $letter1 = $this->letters[$index1];
        $this->letters[$index1] = $this->letters[$index2];
        $this->letters[$index2] = $letter1;
    }

    public function indexOf($letter)
    {
        return array_search($letter, $this->letters);
    }

    public function isDirty()
    {
    	return $this->dirtySort;
    }

    public function cleanUp()
    {
    	$this->dirtySort = false;
    }
}
