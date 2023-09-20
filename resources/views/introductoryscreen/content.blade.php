<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Introductory Screen</title>
</head>
<body>
    <div class="content">
        <p>{{$intro_screendata['Title']}}</p>
        <p>{{$intro_screendata['Link']}}</p>
       <p>{{$intro_screendata['Description']}}</p>
       <p>{{$intro_screendata['Image'] ? $intro_screendata['Image'] : '' }}</p>
       <p>{{$intro_screendata['Video'] ? $intro_screendata['Video'] : '' }}</p>
    </div>
</body>
</html>