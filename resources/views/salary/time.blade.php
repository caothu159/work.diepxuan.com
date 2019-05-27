@foreach ($salary->years() as $year)
    <details>
        <summary>{{ $year }}</summary>
        @foreach ($salary->months($year) as $month)
            <a href="{{ $month }}">{{ $month }}</a>
        @endforeach
    </details>
@endforeach
