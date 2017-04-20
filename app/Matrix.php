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

	/**
	 * @param $labels array 	i.e. ['A', 'B', 'C', 'D']
	 */
	public function __construct(array $labels)
	{
		$this->rowColumnLabels = $labels;
		$this->rows = [];
	}

    /**
	 * Applies the callback function to each element of the matrix.
	 *
     * @param $callback function 	signature: $callback($rowLetter, $columnLetter, $columnIndex, $symbol)
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

	/**
	 * @param $rowLetter string
	 */
	public function getRow($rowLetter)
	{
		return $this->rows[$rowLetter];
	}

	/**
	 * @param $letter string
	 */
	public function indexOfColumnLetter($letter)
	{
		return array_search($letter, $this->rowColumnLabels);
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
	 * @param $rowLetter 	string
	 * @param $columnLetter string
	 * @param $value		string
	 */
	public function set($rowLetter, $columnLetter, $value)
	{
		$this->rows[$rowLetter][$this->indexOfColumnLetter($columnLetter)] = $value;
	}

	/**
	 *
	 */
	public function toString()
	{
		$response = " " . implode('', $this->rowColumnLabels);
		foreach($this->rows as $rowLetter => $row) {
			$response .= "\n" . $rowLetter . implode('', $row);
		}
		return $response;
	}
}
