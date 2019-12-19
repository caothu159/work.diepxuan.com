<table class="table table-hover table-condensed table-sm text-center">
    <tr>
        <th></th>
        <th>công</th>
        <th></th>
        <th>Doanh số</th>
        <th>Cho nợ</th>
        <th>Thu nợ</th>
        @if ($salary->productivity!=0)
            <th>Tỉ lệ</th>
            <th>Năng suất</th>
            <th>Hệ số</th>
            <th>Lương</th>
        @endif
    </tr>
    @foreach ($salary->presences()->orderBy( 'date', 'ASC' )->get() as $presence)
        <tr class="{{ $presence->presence?'':'text-danger' }}">
            <td class="{{ $presence->presence?'':'table-danger' }}">{{ $presence->datetime }}</td>
            <td>{{ $presence->presence?:'-' }}</td>
            <td>{{ $presence->car?$presence->car->name:'-' }}</td>
            <td>{{ $presence->turnover?:'-' }}</td>
            <td>{{ $presence->in_debt?:'-' }}</td>
            <td>{{ $presence->take_debt?:'-' }}</td>
            @if ($salary->productivity!=0)
                <td>{{ $presence->percent?:'-' }}</td>
                <td>{{ $presence->productivity?:'-' }}</td>
                <td>{{ $presence->ratio?:'-' }}</td>
                <td>{{ number_format($presence->presence_salary + $presence->productivity_salary, 3) }}</td>
            @endif
        </tr>
    @endforeach
</table>
