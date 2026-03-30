<?php

namespace App\Domain\CustomMath;

readonly class Matrix {

	public int $w;
	public int $h;

	private function __construct(public array $data)
	{
		$this->w = count($data[0]->data);
		$this->h = count($data);
	}

	public static function fromArray(array $rows): static
	{
		if (empty($rows))
		{
			throw new \InvalidArgumentException('The array must contain elements');
		}

		foreach($rows as $row)
		{
			if (!($row instanceof MatrixRow))
			{
				throw new \InvalidArgumentException('The array of CustomMatrixRow is expected');
			}
		}
		
		for ($i = 1; $i < count($rows); $i++)
		{
			if ($rows[$i]->length != $rows[$i-1]->length)
			{
				throw new \InvalidArgumentException('The arrays must have the same length');
			}
		}

		return new static($rows);
	}
	
}
