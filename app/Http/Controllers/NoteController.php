<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Http\Response;

class NoteController extends Controller
{
	public function index()
	{
		$items = Note::where('hidden', false)
			->select(['title', 'body', 'created_at'])
			->paginate(10)
			->items()
		;

		return view('main', ['notes'=>$items]);
	}
}

