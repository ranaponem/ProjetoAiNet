<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
</head>
<body>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <h1>Customer List</h1>
    <ul>
        @foreach ($customers as $customer)
            <li>{{ $customer->id }}({{$customer->nif}})</li>
        @endforeach
    </ul>
</body>
</html>
