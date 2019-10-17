<div class="col-12">
    <div class="row align-items-stretch salary-container" id="accordionSalary">

        @include('components/timepicker')
        @foreach ($cars as $car)
            <div class="col-sm-3 pl-1 pr-1 pt-0 pb-2">
                <div class="card text-decoration-none collapsed h-100" id="heading{{ $car->id }}">
                    <div class="card-header p-2">
                        <span class="card-title text-success font-weight-bold">{{ $car->name }}</span>
                    </div>
                    <div class="card-body p-2">
                        <div class="card-text font-weight-light text-info">
                            <div class="d-flex justify-content-between">
                                Doanh số:
                                <span class="text-success font-weight-bold">
                                    {{ $car->productivities
                                    ->whereBetween('date', array($time['from'], $time['to']))
                                    ->sum( 'productivity' ) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
