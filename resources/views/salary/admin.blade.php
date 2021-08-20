@php
Debugbar::startMeasure('bangluong', 'Hien thi bang luong');
@endphp
<div class="clearfix"></div>
<div class="col-12 align-items-center printhidden">
    <form method="GET" class="col-sm-3 col-auto">
        @method('GET') @csrf
        <div class="form-group">
            <label for="thoigian">Thời gian</label>
            <select class="form-control" id="thoigian" name="thoigian" onchange="this.form.submit()">
                @foreach ($service->getTimeOptions() as $time)
                    @if ($time->key == $service->getTime())
                        <option value="{{ $time->key }}" selected>
                            {{ $time->view }}
                        </option>
                    @else
                        <option value="{{ $time->key }}">
                            {{ $time->view }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </form>

    @if ($service->isSingle())
        <form method="GET" class="col-sm-3 col-auto">
            @method('GET')
            @csrf
            <div class="form-group">
                <label for="ten">Tên</label>
                <select class="form-control" id="ten" name="ten" onchange="this.form.submit()">
                    <option value="false">Chọn Tên</option>
                    @foreach ($service->getUserOptions() as $user)
                        @if ($user->ten == $service->getName())
                            <option value="{{ $user->ten }}" selected>{{ $user->ten }}</option>
                        @else
                            <option value="{{ $user->ten }}">{{ $user->ten }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </form>
    @endif

</div>
@php
// Debugbar::info($service->getAll());
@endphp
@if ($service->isSingle())
    @include('salary/salaryitems')
@else
    <salary daysdata='{!! cal_days_in_month(CAL_GREGORIAN, $service->getMonth(), $service->getYear()) !!}' monthdata="{!! $service->getMonth() !!}" yeardata="{!! $service->getYear() !!}"
        routersalary={!! route('salary.store') !!} routeruser={!! route('salaryuser.store') !!}>
    </salary>
@endif
@php
Debugbar::stopMeasure('bangluong');
@endphp
