@extends('Layout')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<form class="col-md-12" action="/user/balance/resupply" method="POST">
				<h1>Balance resupply</h1>
				This is a placeholder resupplier, just enter a desired amount of money for adding them to your balance<br />
				<br />
				<div class="row">
					<div class="col-md-2">
						<input class="form-control" name="amount" placeholder="Amount" />
					</div>
				</div>
				<br />
				@csrf
				<button class="btn btn-lg btn-success pull-right" type="submit">Add</button>
			</form>
		</div>
	</div>
@endsection