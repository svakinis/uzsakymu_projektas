<div>
    <h2>{{ $isEdit ? 'Redaguoti užsakymą' : 'Naujas užsakymas' }}</h2>

    @if (session()->has('message'))
        <p style="color: green">{{ session('message') }}</p>
    @endif

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
        <label>Klientas:</label>
        <select wire:model="client_id">
            <option value="">Pasirinkite klientą</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
            @endforeach
        </select>

        <label>Paslauga:</label>
        <select wire:model="service_id">
            <option value="">Pasirinkite paslaugą</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->title }}</option>
            @endforeach
        </select>

        <label>Kiekis:</label>
        <input type="number" wire:model="quantity">

        <label>Kaina:</label>
        <input type="number" step="0.01" wire:model="price">

        <label>Būsena:</label>
        <input type="text" wire:model="status">

        <label>Data:</label>
        <input type="date" wire:model="order_date">

        <button type="submit">{{ $isEdit ? 'Atnaujinti' : 'Išsaugoti' }}</button>
        <button type="button" wire:click="resetInput">Atšaukti</button>
    </form>

    <hr>

    <div style="margin-bottom:20px; border: 1px solid #ccc; padding: 10px;">
    <h3>Filtruoti užsakymus</h3>

    <label>Klientas:</label>
    <select wire:model="filter_client_id">
        <option value="">Visi</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
        @endforeach
    </select>

    <label>Būsena:</label>
    <select wire:model="filter_status">
        <option value="">Visos</option>
        <option value="naujas">Naujas</option>
        <option value="vykdomas">Vykdomas</option>
        <option value="baigtas">Baigtas</option>
    </select>

    <label>Data nuo:</label>
    <input type="date" wire:model="filter_date_from">

    <label>Data iki:</label>
    <input type="date" wire:model="filter_date_to">

    <button wire:click="$refresh">Filtruoti</button>
    <button wire:click="resetFilters">Išvalyti filtrus</button>
    </div>

    <h2>Užsakymų sąrašas</h2>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Klientas</th>
                <th>Paslauga</th>
                <th>Kiekis</th>
                <th>Kaina</th>
                <th>Būsena</th>
                <th>Data</th>
                <th>Veiksmai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client ? $order->client->first_name . ' ' . $order->client->last_name : '-' }}</td>
                    <td>{{ $order->service ? $order->service->title : '-' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>
                        <button wire:click="edit({{ $order->id }})">Redaguoti</button>
                        <button wire:click="delete({{ $order->id }})">Trinti</button>
                        <button wire:click="sendEmail({{ $order->id }})">Siųsti el. paštu</button>
                        <a href="{{ route('orders.pdf', $order->id) }}" target="_blank">PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}

    <!-- Statistikos atnaujinimo mygtukas -->
    <div style="margin-top: 10px; margin-bottom: 20px;">
        <button wire:click="loadStats">Atnaujinti statistiką</button>
    </div>

    <h2>Statistika pagal mėnesius</h2>

    <table border="1" cellpadding="5" style="margin-top:20px;">
        <thead>
            <tr>
                <th>Metai</th>
                <th>Mėnuo</th>
                <th>Užsakymų kiekis</th>
                <th>Visos pajamos (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stats as $stat)
                <tr>
                    <td>{{ $stat['year'] }}</td>
                    <td>{{ $stat['month'] }}</td>
                    <td>{{ $stat['orders_count'] }}</td>
                    <td>{{ number_format($stat['total_revenue'], 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>