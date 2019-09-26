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
    @foreach ($salary->presences as $presence)
        <tr class="{{ $presence->presence?'':'text-danger' }}">
            <td class="{{ $presence->presence?'':'table-danger' }}">{{ $presence->datetime }}</td>
            <td>{{ $presence->presence?:'-' }}</td>
            <td>{{ $presence->presence?($presence->car?$presence->car->name:'-'):'-' }}</td>
            <td>{{ $presence->turnover?:'-' }}</td>
            <td>{{ $presence->in_debt?:'-' }}</td>
            <td>{{ $presence->take_debt?:'-' }}</td>
            @if ($salary->productivity!=0)
                <td>{{ $presence->percent?:'-' }}</td>
                <td>{{ $presence->productivity?:'-' }}</td>
                <td>{{ $presence->ratio?:'-' }}</td>
                <td>{{ $presence->productivity_salary ? number_format($presence->productivity_salary, 2) : '-' }}</td>
            @endif
        </tr>
    @endforeach
</table>
