@extends('layouts.app')

@section('content')
<div class="container">
    <hr/>
    @if ($users->isEmpty())
        <p>No Results</p>
    @else
        @foreach ($users as $user)
            <p><a href="{{route('users', $user->username)}}">
                <img src="{{$user->avatar}}" />
                {{$user->username}}
            </a></p>
        @endforeach
    @endif
</div>
@endsection