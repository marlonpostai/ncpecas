<!-- resources/views/emails/invoice.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento - {{ $quote->id }}</title>
</head>
<body>
    <h1>Olá {{ $quote->client->name }},</h1>
    <p>{{ $body }}</p>

    <p><strong>Detalhes do Orçamento:</strong></p>
    <ul>
        <li><strong>Número do Orçamento:</strong> {{ $quote->id }}</li>
        <li><strong>Data de Criação:</strong> {{ $quote->created_at->format('d/m/Y') }}</li>
        <li><strong>Status:</strong> {{ $quote->status }}</li>
    </ul>

    <p>Obrigado por confiar em nós!</p>
    <p>Atenciosamente,</p>
    <p>Sua Empresa</p>
</body>
</html>
