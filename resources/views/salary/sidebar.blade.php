@foreach ($salary->years() as $year)
<details open>
    <summary>{{ $year }}</summary>
    @foreach ($salary->months($year) as $month)
    <a href="{{ $salary->link($year, $month) }}">{{ $month }}</a>
    @endforeach
</details>
@endforeach
