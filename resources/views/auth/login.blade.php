<!DOCTYPE html>
<html>
<head>
    <title>Login - Flat Admin V.3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/flat-admin.css')}}">
</head>
<body>
<div class="app app-default">
    <div class="app-container app-login">
        <div class="flex-center">
            <div class="app-header"></div>
            <div class="app-body">
                <div class="loader-container text-center">
                    <div class="icon">
                        <div class="sk-folding-cube">
                            <div class="sk-cube1 sk-cube"></div>
                            <div class="sk-cube2 sk-cube"></div>
                            <div class="sk-cube4 sk-cube"></div>
                            <div class="sk-cube3 sk-cube"></div>
                        </div>
                    </div>
                    <div class="title">Logging in...</div>
                </div>
                <div class="app-block">
                    <div class="app-form">
                        <div class="form-header">
                            <div class="app-brand"><span class="highlight text-white">Admin Login</span></div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group @error('email') has-error @enderror">
                                <span class="input-group-addon" id="basic-addon1">
                                    <i class="fa fa-user" aria-hidden="true" style="color:white;"></i>
                                </span>
                                <input id="email" type="email" class="form-control @error('email') has-error @enderror" style="color:white;" name="email" value="{{ old('email') }}" required autofocus aria-describedby="basic-addon1" placeholder="{{ __('E-Mail Address') }}">
                            </div>
                            @error('email')

                            <span class="help-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="input-group @error('password') has-error @enderror">
                                <span class="input-group-addon" id="basic-addon2">
                                    <i class="fa fa-key" aria-hidden="true" style="color:white;"></i>
                                </span>
                                <input id="password" type="password" class="form-control @error('password') has-error @enderror" style="color:white;" name="password" required aria-describedby="basic-addon2" placeholder="{{ __('Password') }}">
                            </div>

                            @error('password')
                            <span class="help-block">
                                    <strong>{{ $message }}</strong>
                                 </span>
                            @enderror

                            <div>
                                <div class="checkbox checkbox-inline">
                                    <input type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
                                    <label for="remember" class="text-white" style="color:white;"> {{ __('Remember Me') }}</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-submit">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="app-footer">
            </div>
        </div>
    </div>
</div>

</body>
</html>


