@php
Debugbar::startMeasure('bangluong', 'Hien thi bang luong');
@endphp
<div class="clearfix"></div>
<div class="col-12 align-items-center printhidden">
    <form method="GET" class="col-sm-6 col-auto">
        @method('GET') @csrf
        <div class="form-group">
            <label for="thoigian">Thời gian</label>
            <select class="form-control" id="thoigian" name="thoigian" onchange="this.form.submit()">
                @foreach ($service->getTimeOptions() as $time)
                @if ("$time->thang-$time->nam"==$service->getTime())
                <option value="{{ $time->thang }}-{{ $time->nam }}" selected>
                    {{ $time->thang }}/{{ $time->nam }}
                </option>
                @else
                <option value="{{ $time->thang }}-{{ $time->nam }}">{{ $time->thang }}/{{ $time->nam }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </form>
</div>
<salary users='{!! json_encode($users) !!}'
    days='{!! cal_days_in_month(CAL_GREGORIAN, $service->getMonth(),$service->getYear()) !!}'
    month="{!! $service->getMonth() !!}" year="{!! $service->getYear() !!}"
    salaries='{!! json_encode($service->getAll()) !!}' routersalary={!!route('salary.store')!!}
    routeruser={!!route('salaryuser.store')!!}></salary>
@php
Debugbar::stopMeasure('bangluong');
@endphp
