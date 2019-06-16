@foreach ($data as $salary)
<div class="col-sm-4 p-1">
    <a class="card text-decoration-none collapsed" id="heading{{ $salary->id }}" data-toggle="collapse"
        href="#collapse{{ $salary->id }}" aria-expanded="false" aria-controls="collapse{{ $salary->id }}">
        <div class="card-header p2">
            <span class="card-title text-success">
                {{ $salary->name }}
            </span>
        </div>

        <div class="card-body p-2">
            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
            <div class="card-text font-weight-light">
                <div class="d-flex justify-content-between">
                    Công: <span class="text-success font-weight-bold">{{ $salary->presence }}</span>
                </div>

                @if ($salary->productivity!=0)
                <div class="d-flex justify-content-between text-info">
                    Doanh số xe: <span>{{ $salary->turnover }}</span>
                </div>

                <div class="d-flex justify-content-between text-info">
                    Lương cứng: <span class="text-primary">{{ $salary->salary_default }}</span>
                </div>
                <div class="d-flex justify-content-between text-info">
                    Lương năng suất: <span class="text-primary">{{ $salary->productivity }}</span>
                </div>
                @endif

                <div class="d-flex justify-content-between">
                    Lương: <span class="text-success font-weight-bold">{{ $salary->salary }}</span>
                </div>
            </div>
            <!-- <a <a href="#" class="card-link">Card link</a> -->
            <!-- <a href="#" class="card-link">Another link</a> -->
        </div>
    </a>
</div>

@if ($salary->productivity!=0)
<div class="col-sm-12 collapse" id="collapse{{ $salary->id }}" aria-labelledby="heading{{ $salary->id }}"
    data-parent="#accordionSalary">
    @include('salary/salaryDetail')
</div>
@endif
@endforeach
