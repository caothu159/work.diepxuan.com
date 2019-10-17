<h1 class="d-block">{{ $user->name }}</h1>
<form method="post" action="{{ route('users.store') }}">
    @method('POST')
    @csrf
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">name</div>
            </div>
            <input type="text" class="form-control" name="name" placeholder="Name"
                   value="{{ $user->name }}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Username</div>
            </div>
            <input type="text" class="form-control" name="username" placeholder="UserName"
                   value="{{ $user->username }}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Email Address</div>
            </div>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                   placeholder="Email address" value="{{ $user->email }}">
        </div>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ __('Password') }}</div>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">alary Name</div>
            </div>
            <input type="text" class="form-control" name="salary_name" placeholder="Salary Name"
                   value="{{ $user->salary_name }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
