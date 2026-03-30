<?php
declare(strict_types=1);

namespace App\Domain\CustomMath;

readonly final class MatrixRow {
	
	public int $length;
	
	private function __construct(public array $data) 
	{
		$this->length = count($this->data);		
	}

	public static function fromArray(array $arr): self
	{
		if (empty($arr))
		{
			throw new \InvalidArgumentException('The array must contain elements');
		}

		$arr = array_values($arr);

		foreach($arr as $key => $item)
		{
			if (!is_numeric($item))
			{
				throw new \InvalidArgumentException('The array of numeric values is expected');
			}
			
			$arr[$key] = (float) $item;
		}
		
		return new self($arr);
	}
	
}
