<h2>Sveiki!</h2>
<p>Gavome Jūsų užsakymą:</p>
<ul>
    <li>Užsakymo ID: {{ $order->id }}</li>
    <li>Paslauga: {{ $order->service->title }}</li>
    <li>Kaina: {{ $order->price }} €</li>
    <li>Data: {{ $order->created_at->format('Y-m-d') }}</li>
</ul>
<p>Ačiū, kad naudojatės mūsų sistema!</p>