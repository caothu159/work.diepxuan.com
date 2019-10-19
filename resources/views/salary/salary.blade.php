@foreach ($data as $salary)
    <div class="col-sm-3 pl-1 pr-1 pt-0 pb-2">
        <div class="card text-decoration-none collapsed h-100" id="heading{{ $salary->id }}">
            <div class="card-header p-2">
                <span class="card-title text-success font-weight-bold">
                    {{ $salary->name }}
                </span>
            </div>

            <div class="card-body p-2">
                <div class="card-text font-weight-light text-info">
                    <div class="d-flex justify-content-between">
                        Lương: <span class="text-success font-weight-bold">{{ number_format($salary->salary,2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        Công:
                        <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false"
                           href="#collapse{{ $salary->id }}presence"
                           aria-controls="collapse{{ $salary->id }}presence">
                            {{ $salary->presence }}
                        </a>
                    </div>

                    @if ($salary->turnover!=0)
                        <div class="d-flex justify-content-between">
                            {{ 'Năng suất:' }}
                            <a class="font-weight-normal font-weight-bold" data-toggle="collapse" aria-expanded="false"
                               href="#collapse{{ $salary->id }}" aria-controls="collapse{{ $salary->id }}">
                                {{ number_format($salary->turnover, 2) }}
                                @if ($salary->productivity!=0 && isset($controller) && $controller->isAdmin())
                                    <span class="font-weight-lighter">
                                        /{{ number_format($salary->salary_default, 2) }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endif

                    @if ($salary->productivity!=0 && $salary->chitieu==0)
                        <div class="d-flex justify-content-between">
                            {{ 'Lương cứng:' }}
                            <span class="text-primary">{{ number_format($salary->salary_default, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{ 'Lương năng suất:' }}
                            <span class="text-primary">{{ number_format($salary->productivity, 2) }}</span>
                        </div>
                    @endif

                    <div class="collapse" id="collapse{{ $salary->id }}presence"
                         aria-labelledby="heading{{ $salary->id }}" data-parent="#accordionSalary">
                        @include('salary.calendar')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    @if ($salary->turnover!=0)--}}
    <div class="col-sm-12 collapse" id="collapse{{ $salary->id }}" aria-labelledby="heading{{ $salary->id }}"
         data-parent="#accordionSalary">
        @include('salary.detail')
    </div>
    {{--    @endif--}}
@endforeach
