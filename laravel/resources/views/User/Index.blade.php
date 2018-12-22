@extends('Layout')

{{-- https://stackoverflow.com/questions/30217795/how-to-comment-code-in-blades-like-laravel-4 --}}
{{-- https://stackoverflow.com/a/25618878/2097055 --}}
@php ($promo = $user->id . '-' . $user->promo)

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<h1>User "{{ $user->email }}"</h1>
				<h4>Balance: <b>{{ number_format($user->Balance(), 2) }}</b> <a class="btn btn-link" href="/user/balance/resupply">Resupply</a></h4>
				@if ($userLeader == null)
					Promo link: <a class="btn btn-link" href="{{ url('/user/register/' . $promo) }}">{{ url('/user/register/' . $promo) }}</a>
				@endif
				<br />
				<br />
			</div>
		</div>
		<div class="row justify-content-left">
			<div class="col-md-4">
				<h3>Network</h3>
				<ul class="list-group">
					@if ($userLeader != null)
						<div class="alert alert-info">This user has been invited by "{{ $userLeader->email }}", so he can not invite others</div>
					@else
						@if (sizeof($userFollowers) == 0)
							<div class="alert alert-info">There are no any followers of this user yet</div>
						@else
							@foreach ($userFollowers as $follower)
								<div class="list-group-item">
									<b>{{ $follower->email }}</b><br />
									{{ gmdate('d.m.Y H:i:s', strtotime($follower->created_at)) }}
								</div>
							@endforeach
						@endif
					@endif
				</ul>
			</div>
		</div>
	</div>
@endsection