@extends('layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-between">
            {{-- <div class="col-md-2 pr-4"> --}}
            @include('layouts/sidebar/user')
            {{-- </div> --}}

            {{-- <div class="col-md-12"> --}}
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row align-items-stretch" id="accordionSalary">
                @include('salary/salary')
            </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
