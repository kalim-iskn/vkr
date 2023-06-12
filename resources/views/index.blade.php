@if($credentialsInvalid)
    <div class="alert alert-danger">
        Введен неправильный логин или пароль
    </div>
@endif

<form method="post" action="{{ route('login-send') }}">
    @csrf
    <input type="text" name="login">
    <input type="password" name="password">
    <input type="submit">
</form>
