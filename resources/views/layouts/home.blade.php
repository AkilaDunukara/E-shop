<!DOCTYPE html>
<html>
<head>

	@include('includes.head')
	<title>@yield('title')</title>
	

</head>
<body>
<!-- Shell -->	
<div class="shell">
		@include('includes.header')
		@yield('content')

		@include('includes.footer')
</div>
<!-- End Shell -->	
</body>
</html>