<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <img src="{{$movie->getImageUrlAttribute()}}" alt = {{$movie->poster_filename}}>
    <p>{{$movie->title}}</p>
    <p>{{$movie->id}}</p>
    <p>{{$time}}</p>
    @foreach($screenings as $screening)
        <p>{{$screening->date}} {{$screening->start_time}}</p>
    @endforeach
</body>
</html>