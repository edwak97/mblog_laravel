<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Http\Response;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class NoteController extends Controller
{
	public function index(Request $request)
	{
		$data = $request->validate(
			['p' => 'integer|min:1']
		);

		$mrkdn_renderer = app(MarkdownRenderer::class);

		$notes = Note::where('hidden', false)
			->select(['title', 'body', 'created_at'])
			->orderBy('created_at', 'DESC')
			->paginate(5, ['*'], 'p', $data['p'] ?? 1)
			->through(static function($item) use ($mrkdn_renderer) {
				$item->body = $mrkdn_renderer->toHtml($item->body);
				return $item;
			})
		;	

		//$meta = [ 'prev' => $notes
		return view('main', ['notes' => $notes]);
	}
}

