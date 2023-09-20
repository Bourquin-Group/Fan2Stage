<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
</head>
<body>
    <div class="content">
        @if($aboutus['Slug'] == 'about-us')
        <p>{{$aboutus['Title']}}</p>
        <p>{{$aboutus['Slug']}}</p>
       <p>{{$aboutus['Description']}}</p>
        @endif
        @if($privacypolicy['Slug'] == 'privacy-policy')
        <p>{{$privacypolicy['Title']}}</p>
        <p>{{$privacypolicy['Slug']}}</p>
       <p>{{$privacypolicy['Description']}}</p>
        @endif
        @if($termsandcondition['Slug'] == 'terms-and-condition')
        <p>{{$termsandcondition['Title']}}</p>
        <p>{{$termsandcondition['Slug']}}</p>
       <p>{{$termsandcondition['Description']}}</p>
        @endif
    </div>
</body>
</html>