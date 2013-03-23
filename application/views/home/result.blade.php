@layout("master")

@section("container")
<h1>Your shorten url is:</h1>
<a href="/{{ $shortenurl }}">{{ $shortenurl }}</a>


@endsection