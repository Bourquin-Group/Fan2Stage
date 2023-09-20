<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgotmail</title>
</head>
<body>
    
    <p><b>Resend OTP Mail Link From Fan2Stage</b></p>
    <p>Hello,<span style="color:cadetblue;font-weight:700">{{$name}}</span></p>
    <p>OTP:<span style="color:crimson">{{$otp}}</span></p>
    {{-- <a href="{{route('changepassword',['mail'=>Crypt::encryptString($mail)])}}" style="color:chocolate">Click me! to Reset Password</a> --}}
    <h5>Regards,</h5>
    <h3>Fan2Stage</h3>
</body>
</html>