<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sąskaita</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Sąskaita už paslaugą</h2>
    <p><strong>Užsakymo ID:</strong> {{ $order->id }}</p>
    <p><strong>Data:</strong> {{ $order->order_date }}</p>

    <h4>Klientas:</h4>
    <p>{{ $order->client->first_name }} {{ $order->client->last_name }}</p>
    <p>{{ $order->client->email }}</p>
    <p>{{ $order->client->phone }}</p>

    <h4>Paslauga:</h4>
    <p>{{ $order->service->title }}</p>
    <p>Kaina: {{ $order->price }} EUR</p>
    <p>Kiekis: {{ $order->quantity }}</p>
    <p>Būsena: {{ $order->status }}</p>

    <h3>Bendra suma: {{ number_format($order->price * $order->quantity, 2) }} EUR</h3>
</body>
</html>