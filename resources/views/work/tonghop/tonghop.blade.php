@extends('work.tonghop')

@section('content')
    @include('work.components.timer')

    <div class="container">
        <form class="form row" action="{{ route(Route::currentRouteName()) }}" method="POST">
            @method('POST')
            @csrf
            <button class="btn btn-outline-success" name="synctype" type="submit" value="dmsp">{{ 'dmsp' }}</button>
        </form>
    </div>

    <table class="table table-hover table-condensed table-sm text-monospace small">
        <tbody>
        </tbody>
    </table>
@endsection
