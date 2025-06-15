<div class="container mx-auto p-4">

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <h2 class="text-2xl mb-4">{{ $isEdit ? 'Redaguoti klientą' : 'Sukurti naują klientą' }}</h2>

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="mb-6">
        <div class="mb-2">
            <label>Vardas:</label>
            <input type="text" wire:model.defer="first_name" class="border p-1 w-full">
            @error('first_name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label>Pavardė:</label>
            <input type="text" wire:model.defer="last_name" class="border p-1 w-full">
            @error('last_name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label>El. paštas:</label>
            <input type="email" wire:model.defer="email" class="border p-1 w-full">
            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label>Telefonas:</label>
            <input type="text" wire:model.defer="phone" class="border p-1 w-full">
            @error('phone') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <label>Miestas:</label>
            <select wire:model="city_id" class="border p-1 w-full">
                <option value="">Pasirinkite miestą</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ $isEdit ? 'Atnaujinti' : 'Sukurti' }}
        </button>

        @if ($isEdit)
            <button type="button" wire:click="resetInput" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">
                Atšaukti redagavimą
            </button>
        @endif
    </form>

    <h2 class="text-2xl mb-4">Klientų sąrašas</h2>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2">Vardas</th>
                <th class="border border-gray-300 p-2">Pavardė</th>
                <th class="border border-gray-300 p-2">El. paštas</th>
                <th class="border border-gray-300 p-2">Telefonas</th>
                <th class="border border-gray-300 p-2">Miestas</th>
                <th class="border border-gray-300 p-2">Veiksmai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td class="border border-gray-300 p-2">{{ $client->first_name }}</td>
                    <td class="border border-gray-300 p-2">{{ $client->last_name }}</td>
                    <td class="border border-gray-300 p-2">{{ $client->email }}</td>
                    <td class="border border-gray-300 p-2">{{ $client->phone }}</td>
                    <td class="border border-gray-300 p-2">{{ $client->city ? $client->city->name : '-' }}</td>
                    <td class="border border-gray-300 p-2">
                        <button wire:click="edit({{ $client->id }})" class="bg-yellow-400 px-2 py-1 rounded">Redaguoti</button>
                        <button wire:click="confirmDelete({{ $client->id }})" class="bg-red-600 text-white px-2 py-1 rounded ml-2">Ištrinti</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>

    @if ($confirmingDeleteId)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
                <h3 class="text-lg mb-4">Ar tikrai norite ištrinti klientą?</h3>
                <button wire:click="deleteConfirmed" class="bg-red-600 text-white px-4 py-2 rounded">Taip, ištrinti</button>
                <button wire:click="cancelDelete" class="ml-2 bg-gray-400 px-4 py-2 rounded">Atšaukti</button>
            </div>
        </div>
    @endif
</div>