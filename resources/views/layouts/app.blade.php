<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>



	<!-- Styles -->
    @vite(['resources/sass/app.scss'])


	<style>
		html {
			font-size: 14px !important;
			font-family: 'Sarabun', sans-serif;
		}
	</style>
	@yield('css')
</head>

<body>
	<div class="container-fluid">

		<div class="row">
			<button class="btn btn-web btn-side" type="button" id="ctrlSide">
				<i class="fa-solid fa-chevron-right"></i>
			</button>

			@include('layouts.sidebar')

			<div class="col">
				<div class="row">
					<div class="container">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	@vite(['resources/js/app.js'])
</body>

</html>
