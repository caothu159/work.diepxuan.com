<table class="table table-hover table-striped table-condensed">
    <tr>
        <th></th>
        <th>Xe</th>
        <th>Năng suất xe</th>
        <th>Cho nợ</th>
        <th>Thu nợ</th>
        <th>Tỉ lệ chia</th>
        <th>Năng suất</th>
        <th>Hệ số</th>
        <th>Lương</th>
    </tr>
    @foreach ($salary->divisions as $division)
    <tr>
        <td>{{ $division->datetime }}</td>
        <td>{{ $division->car->name }}</td>
        <td>{{ $division->productivity_value }}</td>
        <td>{{ $division->in_debt_value }}</td>
        <td>{{ $division->take_debt_value }}</td>
        <td>{{ $salary->employee->percent }}</td>
        <td>{{ $division->productivity_by_salary }}</td>
        <td>{{ $division->ratio_by_salary }}</td>
        <td>{{ $division->salary_value }}</td>
    </tr>
    @endforeach
</table>
