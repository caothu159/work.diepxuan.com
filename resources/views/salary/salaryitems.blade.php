@if ($service->isSingle())
    @php
        Debugbar::startMeasure('bangluong', 'Hien thi bang luong');
        $user = $service->getUser();
    @endphp

    <div class="clearfix"></div>
    <h1 class="text-primary clearfix col-6 printhidden">{{ $service->getFullName() }}</h1>
    <div class="col-12">
        <table class="table table-condensed table-sm col-sm-6 col-md-3 text-left">
            <tr>
                <td class="text-right">Công</td>
                <th>{{ number_format($service->getAll()->sum('chamcong'), 1) }}</th>
            </tr>
            <tr>
                <td class="text-right">Năng suất</td>
                <th>
                    {{ number_format($service->getAll()->sum('nangsuat')) ?: '-' }}
                </th>
            </tr>
            @if (isset($controller) && $controller->isAdmin())
                <tr>
                    <td class="text-right">Doanh số</td>
                    <td>
                        {{ number_format($service->getAll()->sum('doanhso')) ?: '-' }}
                    </td>
                </tr>
                <tr class="printhidden">
                    <td class="text-right">Lương</td>
                    <th>{{ number_format($user->luong) }}</th>
                </tr>
                <tr class="printhidden">
                    <td class="text-right">Bảo hiểm</td>
                    <td>{{ number_format($service->getUser()->baohiemmucnop, 2) }}</td>
                </tr>
                <tr class="printhidden">
                    <td class="text-right">Trợ cấp bảo hiểm</td>
                    <td>{{ number_format($service->getUser()->baohiemtrocap, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td class="text-right">Bảo hiểm phải nộp</td>
                <th>
                    {{ number_format($service->getUser()->baohiemphainop, 2) }}
                </th>
            </tr>
        </table>
    </div>
    @if (number_format($service->getAll()->sum('doanhso')))
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
                @if (isset($controller) && $controller->isAdmin())
                    <th class="printhidden">Hệ số</th>
                    <th class="printhidden">Lương</th>
                @endif
            </tr>
            @foreach ($service->getAll() as $salary)
                <tr>
                    <td>
                        @auth
                            <form class="d-inline" action="{{ route('salary.destroy', ['salary' => $salary->id]) }}"
                                method="POST">
                                @method('DELETE') @csrf
                                <input type="hidden" value="{{ $salary->id }}" name="id" />
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
                    <td>{{ $salary->doanhso ? number_format($salary->doanhso) : '-' }}</td>
                    <td>{{ $salary->chono ?: '-' }}</td>
                    <td>{{ $salary->thuno ?: '-' }}</td>
                    <td>{{ $salary->tile ? number_format($salary->tile * 100, 0) : '-' }}%</td>
                    <td>{{ $salary->nangsuat ? number_format($salary->nangsuat, 1) : '-' }}</td>
                    @if (isset($controller) && $controller->isAdmin())
                        <td class="printhidden">{{ $salary->hesoStr }}</td>
                        <td class="printhidden">{{ number_format($salary->luong ?: 0, 1) }}</td>
                    @endif
                </tr>
            @endforeach
        </table>
    @else
        <table class="table table-hover table-condensed table-sm text-center">
            <tr>
                <th></th>
                @if (empty($service->getName()))
                    <th>Tên</th>
                @endif
                <th>Công</th>
                <th></th>
                @if (isset($controller) && $controller->isAdmin())
                    <th class="printhidden">Lương</th>
                @endif
                <th class="printhidden">Phụ cấp bảo hiểm</th>
            </tr>
            @foreach ($service->getAll() as $salary)
                <tr>
                    <td>
                        @auth
                            <form class="d-inline" action="{{ route('salary.destroy', ['salary' => $salary->id]) }}"
                                method="POST">
                                @method('DELETE') @csrf
                                <input type="hidden" value="{{ $salary->id }}" name="id" />
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
                    @if (isset($controller) && $controller->isAdmin())
                        <td class="printhidden">{{ number_format($salary->luong ?: 0, 1) }}</td>
                    @endif
                    <td class="printhidden">{{ number_format($salary->baohiem, 2) }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    @php Debugbar::stopMeasure('bangluong'); @endphp
@endif
