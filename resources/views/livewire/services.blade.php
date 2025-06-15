<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="store" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Pavadinimas</label>
            <input type="text" class="form-control" wire:model="title">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kaina (€)</label>
            <input type="number" step="0.01" class="form-control" wire:model="price">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $editMode ? 'Atnaujinti paslaugą' : 'Pridėti paslaugą' }}
        </button>

        @if ($editMode)
            <button type="button" class="btn btn-secondary ms-2" wire:click="cancel">Atšaukti</button>
        @endif
    </form>

    <h3>Paslaugų sąrašas</h3>
    <ul class="list-group">
        @foreach ($services as $service)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    {{ $service->title }}
                    <span class="badge bg-secondary ms-2">{{ number_format($service->price, 2) }} €</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary me-2" wire:click="edit({{ $service->id }})">Redaguoti</button>
                    <button class="btn btn-sm btn-outline-danger" wire:click="delete({{ $service->id }})" onclick="confirm('Ar tikrai norite ištrinti šią paslaugą?') || event.stopImmediatePropagation()">Trinti</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>