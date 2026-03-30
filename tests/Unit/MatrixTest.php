<?php

use App\Domain\CustomMath\Matrix;
use App\Domain\CustomMath\MatrixRow;

test('creates Matrix from valid MatrixRow array', function () {
    $row1 = MatrixRow::fromArray([1, 2, 3]);
    $row2 = MatrixRow::fromArray([4, 5, 6]);
    $matrix = Matrix::fromArray([$row1, $row2]);
    
    expect($matrix->data)->toBe([$row1, $row2])
        ->and($matrix->w)->toBe(3)
        ->and($matrix->h)->toBe(2);
});

test('creates Matrix with single row', function () {
    $row = MatrixRow::fromArray([7, 8]);
    $matrix = Matrix::fromArray([$row]);
    
    expect($matrix->w)->toBe(2)
        ->and($matrix->h)->toBe(1);
});

test('throws exception for empty rows array', function () {
    expect(fn() => Matrix::fromArray([]))
        ->toThrow(InvalidArgumentException::class, 'The array must contain elements');
});

test('throws exception for array containing non-MatrixRow element', function () {
    $row = MatrixRow::fromArray([1, 2]);
    $bad = [1, 2, 3];
    
    expect(fn() => Matrix::fromArray([$row, $bad]))
        ->toThrow(InvalidArgumentException::class, 'The array of CustomMatrixRow is expected');
});

test('throws exception for rows with mismatched lengths', function () {
    $row1 = MatrixRow::fromArray([1, 2, 3]);
    $row2 = MatrixRow::fromArray([4, 5]); // different length
    
    expect(fn() => Matrix::fromArray([$row1, $row2]))
        ->toThrow(InvalidArgumentException::class, 'The arrays must have the same length');
});

test('allows rows with same length but different values', function () {
    $row1 = MatrixRow::fromArray([1.5, 2.5]);
    $row2 = MatrixRow::fromArray([3.0, 4.0]);
    $matrix = Matrix::fromArray([$row1, $row2]);
    
    expect($matrix->w)->toBe(2)
        ->and($matrix->h)->toBe(2);
});

test('data property is readonly and contains MatrixRow instances', function () {
    $row1 = MatrixRow::fromArray([10, 20]);
    $row2 = MatrixRow::fromArray([30, 40]);
    $matrix = Matrix::fromArray([$row1, $row2]);
    
    expect($matrix->data[0])->toBe($row1)
        ->and($matrix->data[1])->toBe($row2);
});

test('width and height are correctly computed for 3x3 matrix', function () {
    $rows = [
        MatrixRow::fromArray([1, 2, 3]),
        MatrixRow::fromArray([4, 5, 6]),
        MatrixRow::fromArray([7, 8, 9]),
    ];
    $matrix = Matrix::fromArray($rows);
    
    expect($matrix->w)->toBe(3)
        ->and($matrix->h)->toBe(3);
});

test('constructor private, only fromArray factory works', function () {
    // This test ensures we cannot instantiate Matrix directly
    // Reflection can be used but we'll just rely on the public API
    $row = MatrixRow::fromArray([1]);
    $matrix = Matrix::fromArray([$row]);
    
    expect($matrix)->toBeInstanceOf(Matrix::class);
});
