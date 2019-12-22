@extends('work.components.timer')

@section('work.components.timer.extend')
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon1" value="donhang" checked>
        <label class="form-check-label" for="tuychon1">{{ 'Đơn hàng' }}</label>
    </div>
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon2" value="khachhang">
        <label class="form-check-label" for="tuychon2">{{ 'Khách hàng' }}</label>
    </div>
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon3" value="bophan" disabled>
        <label class="form-check-label" for="tuychon3">{{ 'Bộ phận (disabled)' }}</label>
    </div>
@endsection
