@layout("master")

@section("container")

<h1>My URL Shortner</h1>
<form action="/" method="post">
	<input type="text" name="url" id="url" placeholder="http://google.com" autofocus="autofocus" />
	<input type="submit" value="Shorten" name="shorten" /> 
</form>

{{ $errors->first("url", '<p class=errors>:message</p>') }}
@endsection