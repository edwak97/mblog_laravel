<?php
declare(strict_types=1);

use App\Domain\CustomMath\Matrix;
use App\Domain\CustomMath\SquareMatrix;
use App\Domain\CustomMath\MatrixRow;
use App\Domain\CustomMath\MatrixUtils;

beforeEach(function () {
    /** @var \App\Domain\CustomMath\MatrixUtils */
    $this->utils = new MatrixUtils();
});

test('getSubMatrix returns correct submatrix for 3x3 matrix removing middle row and column', function () {
    $rows = [
        MatrixRow::fromArray([1, 2, 3]),
        MatrixRow::fromArray([4, 5, 6]),
        MatrixRow::fromArray([7, 8, 9]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    $sub = $this->utils->getSubMatrix($matrix, 1, 1); // remove row 1, col 1 (zero-indexed)
    
    // Expected submatrix (2x2):
    // [1, 3]
    // [7, 9]
    expect($sub->h)->toBe(2);
    expect($sub->w)->toBe(2);
    
    $expectedRows = [
        MatrixRow::fromArray([1, 3]),
        MatrixRow::fromArray([7, 9]),
    ];
    
    // Compare data arrays
    expect($sub->data[0]->data)->toBe($expectedRows[0]->data);
    expect($sub->data[1]->data)->toBe($expectedRows[1]->data);
});

test('getSubMatrix removes first row and first column', function () {
    $rows = [
        MatrixRow::fromArray([10, 20, 30]),
        MatrixRow::fromArray([40, 50, 60]),
        MatrixRow::fromArray([70, 80, 90]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    $sub = $this->utils->getSubMatrix($matrix, 0, 0);
    
    // Expected:
    // [50, 60]
    // [80, 90]
    expect($sub->h)->toBe(2);
    expect($sub->w)->toBe(2);
    expect($sub->data[0]->data)->toBe([50.0, 60.0]);
    expect($sub->data[1]->data)->toBe([80.0, 90.0]);
});

test('getSubMatrix removes last row and last column', function () {
    $rows = [
        MatrixRow::fromArray([1, 2]),
        MatrixRow::fromArray([3, 4]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    $sub = $this->utils->getSubMatrix($matrix, 1, 1);
    
    // Expected 1x1 matrix: [1]
    expect($sub->h)->toBe(1);
    expect($sub->w)->toBe(1);
    expect($sub->data[0]->data)->toBe([1.0]);
});

test('getSubMatrix reduces 2x2 to 1x1 when removing row 0 col 0', function () {
    $rows = [
        MatrixRow::fromArray([5, 6]),
        MatrixRow::fromArray([7, 8]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    $sub = $this->utils->getSubMatrix($matrix, 0, 0);
    
    expect($sub->h)->toBe(1);
    expect($sub->w)->toBe(1);
    expect($sub->data[0]->data)->toBe([8.0]);
});

test('getSubMatrix throws exception for invalid row index', function () {
    $rows = [
        MatrixRow::fromArray([1, 2]),
        MatrixRow::fromArray([3, 4]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    expect(fn() => $this->utils->getSubMatrix($matrix, 5, 0))
        ->toThrow(InvalidArgumentException::class, 'Invalid row or col index');
});

test('getSubMatrix throws exception for negative row index', function () {
    $rows = [
        MatrixRow::fromArray([1, 2]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    expect(fn() => $this->utils->getSubMatrix($matrix, -1, 0))
        ->toThrow(InvalidArgumentException::class, 'Invalid row or col index');
});

test('getSubMatrix throws exception for invalid column index', function () {
    $rows = [
        MatrixRow::fromArray([1, 2]),
        MatrixRow::fromArray([3, 4]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    expect(fn() => $this->utils->getSubMatrix($matrix, 0, 5))
        ->toThrow(InvalidArgumentException::class, 'Invalid row or col index');
});

test('getSubMatrix throws exception for negative column index', function () {
    $rows = [
        MatrixRow::fromArray([1, 2]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    expect(fn() => $this->utils->getSubMatrix($matrix, 0, -2))
        ->toThrow(InvalidArgumentException::class, 'Invalid row or col index');
});

test('getSubMatrix throws exception for 1x1 matrix (removing the only row/col)', function () {
    // the method itself does not throw any exception directly
    // ::fromArray won't allow to build the entity with no items
    $matrix = Matrix::fromArray([MatrixRow::fromArray([1])]);

    expect(fn() => $this->utils->getSubMatrix($matrix, 0, 0))
        ->toThrow(InvalidArgumentException::class, 'The array must contain elements');
});

test('getSubMatrix preserves row order after removal', function () {
    $rows = [
        MatrixRow::fromArray([1, 2, 3]),
        MatrixRow::fromArray([4, 5, 6]),
        MatrixRow::fromArray([7, 8, 9]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    $sub = $this->utils->getSubMatrix($matrix, 1, 0); // remove middle row, first column
    
    // Expected rows: row0 (without col0) and row2 (without col0)
    // row0: [2, 3]
    // row2: [8, 9]
    expect($sub->h)->toBe(2);
    expect($sub->data[0]->data)->toBe([2.0, 3.0]);
    expect($sub->data[1]->data)->toBe([8.0, 9.0]);
});

test('getSubMatrix works with non‑square matrix', function () {
    $rows = [
        MatrixRow::fromArray([1, 2, 3, 4]),
        MatrixRow::fromArray([5, 6, 7, 8]),
        MatrixRow::fromArray([9, 10, 11, 12]),
    ];
    $matrix = Matrix::fromArray($rows); // 3x4
    
    $sub = $this->utils->getSubMatrix($matrix, 0, 2); // remove first row, third column (index 2)
    
    // Expected 2x3 matrix:
    // [5, 6, 8]
    // [9, 10, 12]
    expect($sub->h)->toBe(2);
    expect($sub->w)->toBe(3);
    expect($sub->data[0]->data)->toBe([5.0, 6.0, 8.0]);
    expect($sub->data[1]->data)->toBe([9.0, 10.0, 12.0]);
});

test('getSubMatrix throws exception for 3x1 matrix when removing the only column', function () {
    // 3 rows, 1 column
    $rows = [
        MatrixRow::fromArray([1]),
        MatrixRow::fromArray([2]),
        MatrixRow::fromArray([3]),
    ];
    $matrix = Matrix::fromArray($rows); // 3x1
    
    // Removing column 0 leaves rows with zero elements, causing MatrixRow::fromArray to throw
    expect(fn() => $this->utils->getSubMatrix($matrix, 0, 0))
        ->toThrow(InvalidArgumentException::class, 'The array must contain elements');
});

test('getSubMatrix throws exception for 1x3 matrix when removing the only row', function () {
    // 1 row, 3 columns
    $rows = [
        MatrixRow::fromArray([1, 2, 3]),
    ];
    $matrix = Matrix::fromArray($rows); // 1x3
    
    // Removing row 0 leaves zero rows, causing Matrix::fromArray to throw
    expect(fn() => $this->utils->getSubMatrix($matrix, 0, 0))
        ->toThrow(InvalidArgumentException::class, 'The array must contain elements');
});

test('getDet returns the single matrix value for the 1x1 matrix',  function () {
    $rows = [
        MatrixRow::fromArray([23.5]),
    ];
    $matrix = SquareMatrix::fromArray($rows); // 1x1
    
    expect($this->utils->getDet($matrix))->toBe(23.5);
});

// the determinant for that matrix must be -301
// [[3, -2, 5], [7, 4, -8], [5, -3, -4]]
test('getDet returns the correct value for the 3x3 matrix', function () {
    $rows = [
        MatrixRow::fromArray([3, -2, 5]),
        MatrixRow::fromArray([7, 4, -8]),
        MatrixRow::fromArray([5, -3, -4]),
    ];
    $matrix = SquareMatrix::fromArray($rows); // 3x3
    
    expect($this->utils->getDet($matrix))->toBe(-301.0);
});

// the determinant for that matrix must be 11707
// 8 9 1 4 1
// -8 6 3 2 5
// 2 2 1 -5 7
// 2 12 1 2 2
// 11 -11 7 8 4
test('getDet returns the correct value for the 5x5 matrix', function () {
    $rows = [
        MatrixRow::fromArray([8, 9, 1, 4, 1]),
        MatrixRow::fromArray([-8, 6, 3, 2, 5]),
        MatrixRow::fromArray([2, 2, 1, -5, 7]),
        MatrixRow::fromArray([2, 12, 1, 2, 2]),
        MatrixRow::fromArray([11, -11, 7, 8, 4]),
    ];
    $matrix = SquareMatrix::fromArray($rows); // 5x5
    
    expect($this->utils->getDet($matrix))->toBe(11707.0);
});
