<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Models\City;

class Clients extends Component
{
    use WithPagination;

    public $first_name, $last_name, $email, $phone, $city_id, $client_id;
    public bool $isEdit = false;
    public $confirmingDeleteId = null;

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $this->client_id,
            'phone' => 'nullable|string|max:20',
            'city_id' => 'nullable|exists:cities,id',
        ];
    }

    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function render()
    {
        $clients = Client::paginate(10);
        $cities = City::all();

        return view('livewire.clients', compact('clients', 'cities'));
    }

    public function store()
    {
        $this->validate();

        Client::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
        ]);

        session()->flash('message', 'Klientas sukurtas.');

        $this->resetInput();
        $this->resetPage();
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $this->client_id = $client->id;
        $this->first_name = $client->first_name;
        $this->last_name = $client->last_name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->city_id = $client->city_id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $client = Client::findOrFail($this->client_id);
        $client->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
        ]);

        session()->flash('message', 'Klientas atnaujintas.');

        $this->resetInput();
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function deleteConfirmed()
    {
        Client::findOrFail($this->confirmingDeleteId)->delete();
        session()->flash('message', 'Klientas ištrintas.');

        $this->resetInput();
        $this->resetPage();
        $this->confirmingDeleteId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    public function resetInput()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->city_id = null;
        $this->client_id = null;
        $this->isEdit = false;
    }
}