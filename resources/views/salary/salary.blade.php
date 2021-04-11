<?php $users = $service->getUserOptions(); ?>
<div class="col-12 printhidden clearfix d-block">
    <form method="GET" class="col-sm-3 col-auto">
        @method('GET')
        @csrf
        <div class="form-group">
            <label for="thoigian">Thời gian</label>
            <select class="form-control" id="thoigian" name="thoigian" onchange="this.form.submit()">
                @foreach ($service->getTimeOptions() as $time)
                @if ("$time->thang-$time->nam"==$service->getTime())
                <option value="{{ $time->thang }}-{{ $time->nam }}" selected>{{ $time->thang }}/{{ $time->nam }}
                </option>
                @else
                <option value="{{ $time->thang }}-{{ $time->nam }}">{{ $time->thang }}/{{ $time->nam }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </form>
    <form method="GET" class="col-sm-3 col-auto">
        @method('GET')
        @csrf
        <div class="form-group">
            <label for="ten">Tên</label>
            <select class="form-control" id="ten" name="ten" onchange="this.form.submit()">
                <option value="false">Chọn Tên</option>
                @foreach ($users as $user)
                @if ($user->ten==$service->getName())
                <option value="{{ $user->ten }}" selected>{{ $user->ten }}</option>
                @else
                <option value="{{ $user->ten }}">{{ $user->ten }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </form>
</div>
@php
Debugbar::startMeasure('bangluong', 'Hien thi bang luong');
@endphp
<div class="clearfix"></div>
<h1 class="text-primary clearfix d-block col-6">{{$service->getFullName()}}</h1>
<div class="col-12">
    <table class="table table-condensed table-sm col-sm-6 col-md-2 text-left">
        <tr>
            <td class="text-right">Công</td>
            <th>{{ number_format($service->getAll()->sum('chamcong')) }}</th>
        </tr>
        <tr>
            <td class="text-right">Doanh số</td>
            <th>{{ number_format($service->getAll()->sum('doanhso')) }}</th>
        </tr>
        <tr>
            <td class="text-right">Năng suất</td>
            <th>{{ number_format($service->getAll()->sum('nangsuat')) }}</th>
        </tr>
        <tr>
            <td class="text-right">Lương</td>
            <th>{{ number_format($service->getAll()->sum('luong')) }}</th>
        </tr>
    </table>
</div>
<table class="table table-hover table-condensed table-sm text-center">
    <tr>
        <th></th>
        @if (empty($service->getName()))
        <th>Tên</th>
        @endif
        <th>Công</th>
        <th></th>
        <th>Doanh số</th>
        <th>Cho nợ</th>
        <th>Thu nợ</th>
        <th>Tỉ lệ</th>
        <th>Năng suất</th>
    </tr>
    @foreach ($service->getAll() as $salary)
    <tr>
        <td>
            @auth
            <form class="d-inline" action="{{ route('salary.destroy', ['salary' => $salary->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                <input type="hidden" value="{{ $salary->id }}" name="id">
                <button type="submit" class="btn btn-link">xóa</button>
            </form>
            @endauth
            <span class="d-inline">{{ $salary->thoigian }}</span>
        </td>
        @if (empty($service->getName()))
        <td>{{ $salary->ten }}</td>
        @endif
        <td>{{ $salary->chamcong }}</td>
        <td>{{ $salary->diadiem }}</td>
        <td>{{ $salary->doanhso?number_format($salary->doanhso):'-' }}</td>
        <td>{{ $salary->chono?:'-' }}</td>
        <td>{{ $salary->thuno?:'-' }}</td>
        <td>{{ $salary->tile?number_format($salary->tile*100,0):'-' }}%</td>
        <td>{{ $salary->nangsuat?number_format($salary->nangsuat,1):'-' }}</td>
    </tr>
    @endforeach
</table>
@php
Debugbar::stopMeasure('bangluong');
@endphp
