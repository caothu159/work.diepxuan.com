@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">System Management</div>

                <div class="card-body">
                    @include('salary/time', ['salary' => $salary])
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('salary/salary', ['salary' => $salary])

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
