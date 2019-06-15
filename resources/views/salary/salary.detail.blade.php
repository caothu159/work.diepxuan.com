<table>
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
        <td>{{ $division->card }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</table>
