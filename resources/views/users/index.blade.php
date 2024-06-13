<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
</head>
<body>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <h1>Customer List</h1>
    <ul>
        @foreach ($users as $user)
            <li><a href="{{ route('customers.show', $user) }}">{{ $user->id }}({{$user->nome}})</a></li>
        @endforeach
    </ul>
</body>
</html>
