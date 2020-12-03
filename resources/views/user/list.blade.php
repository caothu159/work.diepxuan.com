<h3 class="d-block">{{ __('user.list') }}</h3>
@foreach ($users as $user)
<a class="row justify-content-between" href="{{ route('users.edit', ['id' => $user->id]) }}">
    <span class="col text-success font-weight-bold">{{ $user->name }}</span>
    <span class="col text-info">{{ $user->email }}</span>
    <span class="col text-info">{{ $user->username }}</span>
    <span class="col text-info">{{ $user->salary_name }}</span>
</a>
@endforeach
<form method="post" action="{{ route('users.store') }}">
    @method('POST')
    @csrf
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">name</div>
            </div>
            <input type="text" class="form-control" name="name" placeholder="Name">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Username</div>
            </div>
            <input type="text" class="form-control" name="username" placeholder="UserName">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Email Address</div>
            </div>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email address">
        </div>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ __('Password') }}</div>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Salary Name</div>
            </div>
            <input type="text" class="form-control" name="salary_name" placeholder="Salary Name">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
