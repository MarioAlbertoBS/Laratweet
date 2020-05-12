@extends('layouts.app')

@section('content')
<div class="container">
    <p>{{ $user->username }}</p>
    <hr/>

    @if(Auth::user()->isNotTheUser($user))
        @if(Auth::user()->isFollowing($user))
            <a href="{{ route('users.unfollow', $user) }}">unfollow</a>
        @else
            <a href="{{ route('users.follow', $user) }}">follow</a>
        @endif
    @endif
</div>
@endsection