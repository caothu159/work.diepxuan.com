<h1 class="d-block">{{ __('user.list') }}</h1>
@foreach ($users as $user)
    <a class="row justify-content-between" href="{{ route('users.edit', ['id' => $user->id]) }}">
        <span class="col text-success font-weight-bold">{{ $user->name }}</span>
        <span class="col text-info">{{ $user->email }}</span>
        <span class="col text-info">{{ $user->username }}</span>
        <span class="col text-info">{{ $user->salary_name }}</span>
    </a>
@endforeach
