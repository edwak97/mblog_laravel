<?php
declare(strict_types=1);

namespace App\Domain\CustomMath;

class MatrixUtils
{
	/**
	 * Obtaining the determinant of
	 * @param SquareMatrix matrix
	 */
	public function getDet(SquareMatrix $matrix): float
	{
		if ($matrix->w === 1)
		{
			return $matrix->data[0]->data[0];
		}

		$result = 0;

		// calculating the determinant of the matrix via minors 
		 
		$last_row_index = $matrix->h - 1;

		foreach($matrix->data[$last_row_index]->data as $col_i => $col)
		{

			$result += $this->getDet(SquareMatrix::fromMatrix(
				$this->getSubMatrix(
					$matrix, $last_row_index, $col_i)
				))
				* $col
				* (-1) ** ($matrix->h + (int) $col_i + 1)
			;
		}

		return $result;
	}
	
	/*
	The function excludes the corresponding row and col and returns new item
	@param Matrix $matrix
	@param int $row
	@param int $col
	throw InvalidArgumentException if row or col index is invalid
	throw InvalidArgumentException not enought rows or cols
	*/
	public function getSubMatrix(Matrix $matrix, int $row, int $col): Matrix
	{
		if ($row < 0 || $row >= $matrix->h || $col < 0 || $col >= $matrix->w)
		{
			throw new \InvalidArgumentException('Invalid row or col index');
		}

		$new_data = $matrix->data;
		unset($new_data[$row]);

		foreach($new_data as $row_i => $row_data)
		{
			$row_arr = $row_data->data;
			unset($row_arr[$col]);
			$new_data[$row_i] = MatrixRow::fromArray(array_values($row_arr));
		}

		return Matrix::fromArray(array_values($new_data));
		
	}
}
