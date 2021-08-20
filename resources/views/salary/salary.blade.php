<div class="col-12 clearfix d-block">
    <form method="GET" class="col-sm-3 col-auto printhidden">
        @method('GET')
        @csrf
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
</div>
@if ($service->isSingle())
    @include('components.printheader')
    @include('salary/salaryitems')
    @include('components.printfooter')
@else
    @include('components.printheader')
    <div class="col-12 clearfix">
        <table class="table table-hover table-condensed table-sm text-left">
            <tr>
                <th></th>
                <th>Tên</th>
                <th class="text-right">Công</th>
                <th class="text-right">Năng suất</th>
                <th class="text-right">Lương</th>
                <th class="text-right">Nộp BH</th>
            </tr>
            @foreach ($service->getUserOptions() as $user)
                <tr>
                    <td class='text-left'>
                        @php Debugbar::info($user->chitieu); @endphp
                    </td>
                    <td class='text-left'>
                        <a href="{{ route('luong.home', ['time' => $service->getTime(), 'name' => $user->ten]) }}"
                            class="salary-name">
                            {{ $user->ten }}
                        </a>
                    </td>
                    <td class='text-right'>{{ $user->chamcong }}</td>
                    <td class='text-right'>{{ number_format($user->nangsuat) ?: '-' }}</td>
                    <td class='text-right'>{{ number_format($user->luong) }}</td>
                    <td class='text-right'>{{ number_format($user->baohiemphainop) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    @include('components.printfooter')
@endif
