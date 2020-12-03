<form action="{{-- route('salary.thoigian', $time) --}}">
    @method('POST')
    @csrf
    <div class="form-group">
        <label for="exampleFormControlSelect1">Thời gian</label>
        <select class="form-control" id="exampleFormControlSelect1">
            @foreach ($service->getTimeOptions() as $time)
            <option>{{ $time->thang }}/{{ $time->nam }}</option>
            @endforeach
        </select>
    </div>
</form>

<form method="post" action="{{ route('salary.store') }}">
    @method('POST')
    @csrf
    <div class="form-group">
        <input type="number" class="form-control form-control-sm" name="ngay" placeholder="{{ __('default.day') }}" />
        <input type="number" class="form-control form-control-sm" name="thang" placeholder="{{ __('default.month') }}" />
        <input type="number" class="form-control form-control-sm" name="nam" placeholder="{{ __('default.year') }}" />
    </div>
    <div class="form-group"><input type="text" class="form-control form-control-sm" name="ten" placeholder="tên" /></div>
    <div class="form-group"><input type="number" class="form-control form-control-sm" name="chamcong" placeholder="chấm công" /></div>
    <div class="form-group"><input type="text" class="form-control form-control-sm" name="diadiem" placeholder="địa điểm" /></div>
    <div class="form-group"><input type="number" class="form-control form-control-sm" name="doanhso" placeholder="doanh số" /></div>
    <div class="form-group"><input type="number" class="form-control form-control-sm" name="chono" placeholder="cho nợ" /></div>
    <div class="form-group"><input type="number" class="form-control form-control-sm" name="thuno" placeholder="thu nợ" /></div>
    <button type="submit" class="btn btn-primary">{{ __('default.add') }}</button>
</form>

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
        <td>
            <form class="d-inline" action="{{ route('salary.destroy', ['id' => $salary->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                <input type="hidden" value="{{ $salary->id }}" name="id">
                <button type="submit" class="btn btn-link">xóa</button>
            </form>
            <span class="d-inline">{{ $salary->thoigian }}</span>
        </td>
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
