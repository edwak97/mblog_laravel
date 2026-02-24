<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	protected $fillable = [
		'title',
		'body',
		'hidden'
	];

	protected $guarded = [
		'rating'
	];

	protected $casts = [
		'hidden' => 'boolean' 
	];
}
