<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Http\Response;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class NoteController extends Controller
{
	public function index()
	{
		$items = Note::where('hidden', false)
			->select(['title', 'body', 'created_at'])
			->paginate(10)
			->items()
		;
		#?
		$renderer = app(MarkdownRenderer::class);

		$items = array_map(
			static function($item) use ($renderer) {
				$item->body = $renderer->toHtml($item->body);
				return $item;
			},
			$items
		);
		return view('main', ['notes'=>$items]);
	}
}

