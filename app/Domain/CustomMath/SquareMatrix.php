<?php

namespace App\Domain\CustomMath;

readonly class SquareMatrix extends Matrix {

	public static function fromArray(array $rows): static
	{
		$result = parent::fromArray($rows);

		return self::fromMatrix(parent::fromArray($rows);
	}

	public static function fromMatrix(Matrix $matrix): static
	{
		if ($matrix->w != $matrix->h)
		{
			throw new \InvalidArgumentException('The width of the matrix must be equal to the height');
		}

		return $matrix;
	}
	
}
