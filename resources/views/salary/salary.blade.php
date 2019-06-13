<div class="row">
    @foreach ($data as $salary)
    <div class="col-sm-4 p-1">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <a data-toggle="collapse" href="#collapse{{ $salary->id }}" aria-expanded="false" aria-controls="collapse{{ $salary->id }}">
                        {{ $salary->name }}
                    </a>
                </h5>


                <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                <div class="card-text">
                    <p>Lương cứng: <span class="text-danger font-weight-bold">{{ $salary->default }}</span></p>
                </div>
                <!-- <a href="#" class="card-link">Card link</a> -->
                <!-- <a href="#" class="card-link">Another link</a> -->
            </div>
        </div>
    </div>
    <div class="col-sm-12 collapse" id="collapse{{ $salary->id }}">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
    </div>
    @endforeach
<div class="row">
