<?php
declare(strict_types=1);

use App\Domain\CustomMath\MatrixRow;

test('creates MatrixRow from valid numeric array', function () {
    $row = MatrixRow::fromArray([1, 2.5, 3, -4]);
    
    expect($row->data)->toBe([1.0, 2.5, 3.0, -4.0])
        ->and($row->length)->toBe(4);
});

test('creates MatrixRow from associative array with numeric values', function () {
    $row = MatrixRow::fromArray(['a' => 5, 'b' => 6.2, 'c' => 7]);
    
    // array_values should reset keys
    expect($row->data)->toBe([5.0, 6.2, 7.0])
        ->and($row->length)->toBe(3);
});

test('converts string numeric values to float', function () {
    $row = MatrixRow::fromArray(['10', '3.14', '-5']);
    
    expect($row->data)->toBe([10.0, 3.14, -5.0]);
});

test('throws exception for empty array', function () {
    expect(fn() => MatrixRow::fromArray([]))
        ->toThrow(InvalidArgumentException::class, 'The array must contain elements');
});

test('throws exception for non-numeric value', function () {
    expect(fn() => MatrixRow::fromArray([1, 'abc', 3]))
        ->toThrow(InvalidArgumentException::class, 'The array of numeric values is expected');
});

test('throws exception for array containing null', function () {
    expect(fn() => MatrixRow::fromArray([1, null, 3]))
        ->toThrow(InvalidArgumentException::class, 'The array of numeric values is expected');
});

test('throws exception for array containing boolean', function () {
    expect(fn() => MatrixRow::fromArray([1, true, 3]))
        ->toThrow(InvalidArgumentException::class, 'The array of numeric values is expected');
});

test('data property is readonly and accessible', function () {
    $row = MatrixRow::fromArray([1, 2, 3]);
    
    expect($row->data)->toBe([1.0, 2.0, 3.0]);
});