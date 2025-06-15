<h2>Sveiki!</h2>
<p>Gavome Jūsų užsakymą:</p>
<ul>
    <li>Užsakymo ID: {{ $order->id }}</li>
    <li>Paslauga: {{ $order->service->title }}</li>
    <li>Kiekis: {{ $order->quantity }}</li>
    <li>Vieneto kaina: {{ number_format($order->price, 2) }} €</li>
    <li>Bendra suma: {{ number_format($order->price * $order->quantity, 2) }} €</li>
    <li>Data: {{ $order->created_at->format('Y-m-d') }}</li>
</ul>
<p>Ačiū, kad naudojatės mūsų sistema!</p>