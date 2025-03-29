<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento #{{ $quote->quote_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
            font-size: 0.8rem;
            line-height: 1.3;
            position: relative;
            min-height: 100vh;
        }

        header {
            text-align: center;
            padding: 5px 15px;
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .card {
            background: #f8f8f8;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px 15px;
        }

        .card h2 {
            margin-top: 0;
            color: #007BFF;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.8rem;
        }

        th, td {
            padding: 5px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-section {
            margin: 15px 15px;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 8px;
        }

        .total-section table {
            margin-top: 0;
        }

        .total-table td {
            font-weight: bold;
            text-align: right;
        }

        footer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 20px;
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
        }

        /* Invoice Styles */
        #container {
            padding: 4%;
            padding-bottom: 50px; /* Garante que a observação não sobreponha o footer */
        }

        #header {
            height: 80px;
        }

        #header > #reference {
            float: right;
            text-align: right;
        }

        #header > #reference h3 {
            margin: 0;
        }

        #header > #reference h4 {
            margin: 0;
            font-size: 85%;
            font-weight: 600;
        }

        #header > #reference p {
            margin: 0;
            margin-top: 2%;
            font-size: 85%;
        }

        #header > #logo {
            width: 50%;
            float: left;
        }

        #fromto {
            height: 160px;
        }

        #fromto > #from,
        #fromto > #to {
            width: 45%;
            min-height: 90px;
            margin-top: 30px;
            font-size: 85%;
            padding: 1.5%;
            line-height: 120%;
        }

        #fromto > #from {
            float: left;
            width: 45%;
            background: #efefef;
            margin-top: 30px;
            font-size: 85%;
            padding: 1.5%;
        }

        #fromto > #to {
            float: right;
            border: solid grey 1px;
        }

        #items {
            margin-top: 10px;
        }

        #items > p {
            font-weight: 700;
            text-align: right;
            margin-bottom: 1%;
            font-size: 65%;
        }

        #items > table {
            width: 100%;
            font-size: 85%;
            border: solid grey 1px;
        }

        #items > table th:first-child {
            text-align: left;
        }

        #items > table th {
            font-weight: 400;
            padding: 1px 4px;
        }

        #items > table td {
            padding: 1px 4px;
        }

        #items > table th:nth-child(2),
        #items > table th:nth-child(4) {
            width: 45px;
        }

        #items > table th:nth-child(3) {
            width: 60px;
        }

        #items > table th:nth-child(5) {
            width: 80px;
        }

        #items table td {
            border-right: solid grey 1px;
        }

        #items table tr td {
            padding-top: 3px;
            padding-bottom: 3px;
            height: 10px;
        }

        #summary {
            height: 170px;
            margin-top: 30px;
        }

        #summary #note {
            float: left;
        }

        #summary #note h4 {
            font-size: 10px;
            font-weight: 600;
            font-style: italic;
            margin-bottom: 4px;
        }

        #summary #note p {
            font-size: 10px;
            font-style: italic;
        }

        #summary #total table {
            font-size: 85%;
            width: 260px;
            float: right;
        }

        #summary #total table td {
            padding: 3px 4px;
        }

        #summary #total table tr td:last-child {
            text-align: right;
        }

        #summary #total table tr:nth-child(3) {
            background: #efefef;
            font-weight: 600;
        }

        #footer {
            margin: auto;
            position: absolute;
            left: 4%;
            bottom: 10px;
            right: 4%;
            border-top: solid grey 1px;
        }

        #footer p {
            margin-top: 1%;
            font-size: 80%;
            line-height: 140%;
            text-align: center;
        }

        .observacoes {
            margin-top: 30px;
            border-top: 1px solid #000;
            padding-top: 10px;
            padding-bottom: 20px;
            text-align: center;
        }
    </style>

    <body>
        <div id="container">
            <div id="header">
                <div id="logo">
                    <img src="http://placehold.it/230x70&text=logo" alt="">
                </div>
                <div id="reference">
                    <h3><strong>ORÇAMENTO</strong></h3>
                    <h3>Ref.: {{ $quote->quote_number }}</h3>
                    <p>Data de Criação: {{ \Carbon\Carbon::parse($quote->creation_date)->format('d/m/Y') }}</p>
                    <p>Válido até: {{ \Carbon\Carbon::parse($quote->creation_date)->addDays(30)->format('d/m/Y') }}</p>
                </div>
            </div>

            <div id="fromto">
                <div id="from">
                    <p>
                        <strong>NC PEÇAS PERSONALIZADAS</strong><br>
                        CNPJ: 56.197.702/0001-61 <br>
                        Rua: Florentina Gomes Barbosa, nº 58, Costa e Silva – Mossoró – RN <br>
                        CEP: 59.625-496 <br><br>
                        Telefone: (84) 99109-0310 (Whatsapp) <br>
                        E-mail: niadna_alana@yahoo.com.br <br>
                    </p>
                </div>
                <div id="to">
                    <p>
                        <strong>CLIENTE</strong><br><br>
                        <strong>{{ $quote->client->name }}</strong><br>
                        {{ $quote->client->address }}<br>
                        {{ $quote->client->city }} - {{ $quote->client->state }} <br>
                    </p>
                </div>
            </div>

            <div id="items">
                <p>Itens do Orçamento</p>
                <table>
                    <tr>
                        <th><strong>DESCRIÇÃO</strong></th>
                        <th><strong>QUANTIDADE</strong></th>
                        <th><strong>PREÇO UNITÁRIO</strong></th>
                        <th><strong>DESCONTO</strong></th>
                        <th><strong>TOTAL</strong></th>
                    </tr>
                    @foreach ($quote->quoteItems as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format(($item->unit_price * $item->quantity) * ($item->item_discount_percent / 100), 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->total_with_discount, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div id="summary">
                <div id="total">
                    <table>
                        <tr>
                            <td>Total Geral:</td>
                            <td>R$ {{ number_format($quote->quoteItems->sum('total_price'), 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Desconto Aplicado:</td>
                            <td>{{ $item->item_discount_percent ?? '0' }}%</td>
                        </tr>
                        <tr>
                            <td>Total com Desconto:</td>
                            <td>R$ {{ number_format(($quote->quoteItems->sum('total_with_discount')) * (1 - ($quote->discount_percentage / 100)), 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- OBSERVAÇÕES -->
            <div class="observacoes">
                <h2>Observações</h2>
                <p>Forma de Pagamento: Transferência Bancária Banco do Brasil:<br>
                Ag: 36-1<br>
                C.C: 129.102-5<br>
                Favorecido: Niadna Alana Caldas Medeiros<br>
                Obs: Entrega 18 dias úteis após confirmação de pagamento. Frete Gratuito.</p>
            </div>
            <div id="footer">
                <p>Orçamento gerado por {{ auth()->user()->name }} em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            </div>

        </div>
    </body>
    </html>
