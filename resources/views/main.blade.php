<!DOCTYPE html>
<html lang="ru">
@include('parts.header')
<body>
	<div class="pagecontent">
		@include('parts.menu')
		<div class="rightside">
			<div class="notelist">
				@foreach($notes->items() as $note)
				<div class="note">
					<div class="header">
						<h1>{{$note->title}}</h1>
					</div>
					<div class="notecontent">
					{!!$note->body!!}
					</div>
				</div>
				@endforeach
			</div>
			<div class="pagination">
				@if ($notes->hasPages())
					@if ($notes->onFirstPage())	
						<a class="nav-link" href="{{$notes->nextPageUrl()}}">Следующая страница</a>
					@elseif ($notes->onLastPage())
						<a class="nav-link" href="{{$notes->previousPageUrl()}}">Предыдущая страница</a>
					@else
						<a class="nav-link" href="{{$notes->previousPageUrl()}}">Предыдущая страница</a>
						<a class="nav-link" href="{{$notes->nextPageUrl()}}">Следующая страница</a>
					@endif
				@endif
			</div>
		</div>
	</div>
</body>
</html>

