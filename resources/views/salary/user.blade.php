<salary-component></salary-component>
<table class="table table-hover table-condensed table-sm text-center">
    <tr>
        <th></th>
        <th>Tên</th>
        <th>Công</th>
        <th>Địa điểm</th>
        <th>Doanh số</th>
        <th>Cho nợ</th>
        <th>Thu nợ</th>
        <th>Hệ số</th>
        <th>Năng suất</th>
        <th>Tỉ lệ</th>
        <th>Lương</th>
    </tr>
    @foreach ($service->getAll() as $salary)
    <tr>
        <td>{{ $salary->thoigian }}</td>
        <td>{{ $salary->ten }}</td>
        <td>{{ $salary->chamcong }}</td>
        <td>{{ $salary->diadiem }}</td>
        <td>{{ $salary->doanhso }}</td>
        <td>{{ $salary->chono }}</td>
        <td>{{ $salary->thuno }}</td>
        <td>{{ $salary->heso }}</td>
        <td>{{ $salary->nangsuat?:'-' }}</td>
        <td>{{ $salary->tile }}</td>
        <td>{{ number_format($salary->luong?:0, 3) }}</td>
    </tr>
    @endforeach

</table>
