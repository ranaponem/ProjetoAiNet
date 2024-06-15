<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Cliente</title>
</head>
<body>
<h1>Detalhes do Cliente</h1>

<h2>Informações do Cliente</h2>
<p><strong>NIF:</strong> {{ $customer->nif }}</p>
<p><strong>Tipo de Pagamento:</strong> {{ $customer->payment_type }}</p>
<p><strong>Referência de Pagamento:</strong> {{ $customer->payment_ref }}</p>

<h2>Informações do Utilizador</h2>
<p><strong>Nome:</strong> {{ $customer->user->name }}</p>
<p><strong>Email:</strong> {{ $customer->user->email }}</p>
<p><strong>Tipo:</strong> {{ $customer->user->type }}</p>
<p><strong>Bloqueado:</strong> {{ $customer->user->blocked ? 'Sim' : 'Não' }}</p>
<p>
    <strong>Foto:</strong>
    @if($customer->user->photo_filename)
        <img src="{{ $customer->user->getImageUrlAttribute() }}" alt="Foto do Utilizador" width="100">
    @else
        Sem foto
    @endif
</p>
</body>
</html>
