<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Http\Response;

class NoteControllerApi extends Controller
{
	public function index(Request $request)
	{
		$data = $request->validate(
			['p' => 'integer|min:1']
		);

		$notes = Note::where('hidden', false)
			->select(['title', 'body', 'created_at'])
			->orderBy('created_at', 'DESC')
			->paginate(5, ['*'], 'p', $data['p'] ?? 1)
		;
		
		return response()->json(
			[
			'data' => $notes->items(),
			'meta' => [
				'current_page' => $notes->currentPage(),
				'last_page' => $notes->lastPage(),
				'per_page' => $notes->perPage(),
				'total' => $notes->total(),
				],
			],
			Response::HTTP_OK
		);
	}

	public function show($id)
	{
		$note = Note::where('id', $id)
			->where('hidden', false)
			->select(['title', 'body', 'created_at'])
			->first()
		;

		if ($note)
		{
			return response()->json($note, Response::HTTP_OK);
		}

		return response()->json('Not found', Response::HTTP_NOT_FOUND);
	}

	public function update(Request $request, $id)
	{
		$note = Note::where('id', $id)->first();

		if (!$note)
		{
			return response()->json('Not found', Response::HTTP_NOT_FOUND);
		}

		$note->update($request->only(['title', 'body', 'hidden']));

		return response()->json(note::where('id', $id)->first());
	}

	public function store(Request $request)
	{	
		// add validation #todo
		$note = Note::create($request->only(['title', 'body', 'hidden']));
		return response()->json($note, Response::HTTP_CREATED);
	}
}

