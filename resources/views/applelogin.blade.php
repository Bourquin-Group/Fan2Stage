<style>
    body { padding: 2em; }


    /* Shared */
    .loginBtn {
    box-sizing: border-box;
    position: relative;
    /* width: 13em;  - apply for fixed size */
    margin: 0.2em;
    padding: 0 15px 0 46px;
    border: none;
    text-align: left;
    line-height: 34px;
    white-space: nowrap;
    border-radius: 0.2em;
    font-size: 16px;
    color: #FFF;
    }
    .loginBtn:before {
    content: "";
    box-sizing: border-box;
    position: absolute;
    top: 0;
    left: 0;
    width: 34px;
    height: 100%;
    }
    .loginBtn:focus {
    outline: none;
    }
    .loginBtn:active {
    box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
    }


    /* Facebook */
    .loginBtn--facebook {
    background-color: #4C69BA;
    background-image: linear-gradient(#4C69BA, #3B55A0);
    /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
    text-shadow: 0 -1px 0 #354C8C;
    }
    .loginBtn--facebook:before {
    border-right: #364e92 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
    }
    .loginBtn--facebook:hover,
    .loginBtn--facebook:focus {
    background-color: #5B7BD5;
    background-image: linear-gradient(#5B7BD5, #4864B1);
    }


    /* Google */
    .loginBtn--google {
    /*font-family: "Roboto", Roboto, arial, sans-serif;*/
    background: #DD4B39;
    }
    .loginBtn--google:before {
    border-right: #BB3F30 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
    }
    .loginBtn--google:hover,
    .loginBtn--google:focus {
    background: #E74B37;
    }
    .loginBtn--instagram{
        background: #e737e783;

    /* Instagram */
    .loginBtn--instagram {
    /*font-family: "Roboto", Roboto, arial, sans-serif;*/
    background: #dd399e;
    }
    .loginBtn--instagram:before {
    border-right: #dd399e 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_instagram.png') 6px 6px no-repeat;
    }
    .loginBtn--instagram:hover,
    .loginBtn--instagram:focus {
    background: #dd399e;
    }

    /* Apple */
    .loginBtn--apple {
    /*font-family: "Roboto", Roboto, arial, sans-serif;*/
    background: #0e0d0d;
    }
    .loginBtn--apple:before {
    border-right: #0e0d0d 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_instagram.png') 6px 6px no-repeat;
    }
    .loginBtn--apple:hover,
    .loginBtn--apple:focus {
    background: #0e0d0d;
    }
</style>
@extends('layouts.app')

@section('content')


<div id="appleid-signin"  data-color="white" data-border="true" data-type="sign in" data-height="40" data-width="200" style="margin-top: 18px; cursor: pointer;"></div>
<script type="text/javascript" src="https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/en_US/appleid.auth.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){

AppleID.auth.init({
clientId : Y3EW23KC44, // Replace with your own client ID
scope : 'name email',
redirectURI: 'http://localhost:8000/auth/apple/callback',
//usePopup : true
});
});
function signInWithApple() {



AppleID.auth.init({
clientId : 'in.colanapps.fan2stage', // Replace with your own client ID
scope : 'name email',
redirectURI: 'https://fan2stage.colanapps.in/auth/apple/callback',
// usePopup : true
});

alert('coming');
AppleID.auth.signIn();
}



</script>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    <div class="card-header">{{ __('Login') }}</div>

    @if(session('error_message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-top: -13px;">×</button>
            {{ session('error_message') }}
        
        </div>
    @endif

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
          
        </form>
        <br />
        <div class="row mb-3">
            <div class="col-md-6 offset-md-4">
                <a href="{{ URL('auth/facebook')}}"> <button class="loginBtn loginBtn--facebook">
                    Login with Facebook
                </button></a>
            
                <a href="{{ URL('auth/google')}}"><button class="loginBtn loginBtn--google">
                    Login with Google
                </button></a>
                <a href="{{ URL('auth/instagram')}}"><button class="loginBtn loginBtn--instagram">
                    Login with Instagrams
                </button></a>

                
                <a href="{{ URL('auth/apple')}}"><button class="loginBtn loginBtn--apple">
                    Login with Apple
                </button></a>

              <button class="loginBtn loginBtn--apple" onclick="signInWithApple()">
                    Login with Apple
                </button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


@endsection
