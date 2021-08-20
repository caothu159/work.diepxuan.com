@php
$thoigian = '';
$ten = '';
if ($service) {
    $thoigian = $service->getTime();
    $ten = $service->getFullName();
}
@endphp

<table class="table table-sm text-center printvisiable no-border">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <h3>{{ 'CÔNG TY TNHH ĐIỆP XUÂN' }}</h3>
        </td>
        <td>{{ 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM' }}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ 'Độc Lập - Tự Do - Hạnh Phúc' }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan='2'>
            <h3>{{ "Bảng lương $ten $thoigian" }}</h3>
        </td>
    </tr>
</table>
