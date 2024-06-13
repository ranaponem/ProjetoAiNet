<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach($moviesOnShow as $movie)
        <img src="{{$movie->getImageUrlAttribute()}}" alt = {{$movie->poster_filename}}>
        <p>{{$movie->title}}</p>
        <p>{{$movie->id}}</p>
    @endforeach
</body>
</html>