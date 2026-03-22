<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>edwak97</title>
	<link rel="stylesheet" href="{{asset('base0.css')}}">
	<link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
</head>

<body>
	<div class="pagecontent">
		<div class="leftside">
			<div class="menu">
				<div class="menu-item"><a href="https://t.me/edwak97" target="_blank">Telegram</a></div>
				<div class="menu-item"><a href="https://github.com/edwak97">Github</a></div>
			</div>
		</div>
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
				@if ($notes->onFirstPage())	
					<a class="nav-link" href="{{$notes->nextPageUrl()}}">Следующая страница</a>
				@elseif ($notes->onLastPage())
					<a class="nav-link" href="{{$notes->previousPageUrl()}}">Предыдущая страница</a>
				@else
					<a class="nav-link" href="{{$notes->previousPageUrl()}}">Предыдущая страница</a>
					<a class="nav-link" href="{{$notes->nextPageUrl()}}">Следующая страница</a>
				@endif
			</div>
		</div>
	</div>
</body>
</html>

