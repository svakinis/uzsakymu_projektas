<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class Services extends Component
{
    public $title;
    public $price;

    public $editMode = false;  // režimas: ar redaguojame?
    public $serviceId;         // redaguojamos paslaugos id

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($this->editMode) {
            // atnaujinam esamą paslaugą
            $service = Service::find($this->serviceId);
            if ($service) {
                $service->update([
                    'title' => $this->title,
                    'price' => $this->price,
                ]);
                session()->flash('message', 'Paslauga sėkmingai atnaujinta.');
            }
            $this->editMode = false;
            $this->serviceId = null;
        } else {
            // kuriam naują paslaugą
            Service::create([
                'title' => $this->title,
                'price' => $this->price,
            ]);
            session()->flash('message', 'Paslauga sėkmingai pridėta.');
        }

        $this->reset(['title', 'price']);
    }

    // laukai redagavimui
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->title = $service->title;
        $this->price = $service->price;
        $this->editMode = true;
    }

    // išvalyti formą ir išjungti redagavimo režimą
    public function cancel()
    {
        $this->reset(['title', 'price', 'serviceId']);
        $this->editMode = false;
    }

    // trinti paslaugą
    public function delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        session()->flash('message', 'Paslauga sėkmingai pašalinta.');
        // jei šiuo metu redaguojame tą pačią, atšaukti redagavimą
        if ($this->editMode && $this->serviceId == $id) {
            $this->cancel();
        }
    }
    
    public function render()
    {
        $services = Service::all();
        return view('livewire.services', ['services' => $services]);
    }
}