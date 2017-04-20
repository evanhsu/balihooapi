<?php

namespace App;

/**
 * Example:
 *
 *  ABCD
 * A->-- 
 * B-=-- 
 * C-<-- 
 * D>---
 */
class Matrix
{
	protected $rows;
	protected $rowColumnLabels;

	public function __construct($labels)
	{
		$this->rowColumnLabels = $labels;
		$this->rows = [];
	}

	/**
	 * Convert the input $sentence into an array, indexed by the first char:
	 *  "A->--"  ==>  [A => [-,>,-,-]]
	 *
	 * @param $sentence	string 	"A->--"
	 */
    public function pushRow($sentence)
    {
        $row = str_split($sentence);
        $this->rows[array_shift($row)] = $row;
    }
	
    /**
	 * Applies the callback function to each element of the matrix.
	 *
     * Function signature: $callback($rowLetter, $columnLetter, $columnIndex, $symbol)
     */
	public function each(callable $callback)
	{
		foreach($this->rowColumnLabels as $rowLetter)
        {
            foreach($this->rows[$rowLetter] as $columnIndex => $symbol)
            {
                $columnLetter = $this->rowColumnLabels[$columnIndex];
            	call_user_func_array($callback, [$rowLetter, $columnLetter, $columnIndex, $symbol]);
            }
        }
	}

	public function getRow($rowLetter)
	{
		return $this->rows[$rowLetter];
	}

	public function set($rowLetter, $columnLetter, $value)
	{
		$this->rows[$rowLetter][$this->indexOfColumnLetter($columnLetter)] = $value;
	}

	public function indexOfColumnLetter($letter)
	{
		return array_search($letter, $this->rowColumnLabels);
	}

	public function toString()
	{
		$response = " " . implode('', $this->rowColumnLabels);
        foreach($this->rows as $rowLetter => $row) {
            $response .= "\n" . $rowLetter . implode('', $row);
        }
        return $response;
	}
}
