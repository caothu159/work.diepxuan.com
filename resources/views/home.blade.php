@extends($controller->getLayout())

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="col-12">
        <div class="row align-items-stretch" id="accordionSalary">
            @include('components/sidebar')
            @include('salary/salary')
        </div>
    </div>

@endsection

@section('sidebar.salary')
    <ul>
        <li>
            <form method="post" class="mb-1" action="{{ route('salary', $time) }}">
                @method('POST')
                @csrf
                <button class="btn btn-link text-left p-0 m-0 border-0 text-decoration-none text-capitalize"
                        type="submit" name="import" value="import">
                    {{ __('salary.import') }}
                </button>
            </form>
        </li>
    </ul>
@endsection
