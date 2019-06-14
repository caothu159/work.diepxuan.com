@foreach ($data as $salary)
<div class="col-sm-4 p-1">
    <a class="card text-decoration-none collapsed" id="heading{{ $salary->id }}" data-toggle="collapse"
        href="#collapse{{ $salary->id }}" aria-expanded="false" aria-controls="collapse{{ $salary->id }}">
        <div class="card-header">
            <span class="card-title text-success">{{ $salary->name }}</span>
        </div>

        <div class="card-body">
            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
            <div class="card-text">
                <p>Lương cứng: <span class="text-danger font-weight-bold">{{ $salary->default }}</span></p>
                <p>Lương năng suất: <span class="text-danger font-weight-bold">{{ $salary->productivity }}</span></p>
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
