<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSent;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $order_id, $client_id, $service_id, $quantity, $price, $status = 'naujas', $order_date;
    public $isEdit = false;
    public $clients, $services;
    public $filter_client_id = '';
    public $filter_status = '';
    public $filter_date_from = '';
    public $filter_date_to = '';
    public $stats = [];

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'service_id' => 'required|exists:services,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'status' => 'required|string',
        'order_date' => 'nullable|date',
    ];

    public function mount()
    {
        $this->clients = \App\Models\Client::all();
        $this->services = \App\Models\Service::all();
        $this->loadStats();
    }

    public function store()
    {
        $this->validate();

        Order::create([
            'client_id' => $this->client_id,
            'service_id' => $this->service_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status,
            'order_date' => $this->order_date,
        ]);

        $this->resetInput();
        session()->flash('message', 'Užsakymas sukurtas sėkmingai.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $this->order_id = $order->id;
        $this->client_id = $order->client_id;
        $this->service_id = $order->service_id;
        $this->quantity = $order->quantity;
        $this->price = $order->price;
        $this->status = $order->status;
        $this->order_date = $order->order_date;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $order = Order::findOrFail($this->order_id);
        $order->update([
            'client_id' => $this->client_id,
            'service_id' => $this->service_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status,
            'order_date' => $this->order_date,
        ]);

        $this->resetInput();
        session()->flash('message', 'Užsakymas atnaujintas sėkmingai.');
    }

    public function delete($id)
    {
        Order::destroy($id);
        session()->flash('message', 'Užsakymas ištrintas.');
    }

    public function resetInput()
    {
        $this->reset(['order_id', 'client_id', 'service_id', 'quantity', 'price', 'status', 'order_date', 'isEdit']);
    }

    public function render()
    {
        $query = Order::with(['client', 'service']);
    
        if ($this->filter_client_id) {
            $query->where('client_id', $this->filter_client_id);
        }
    
        if ($this->filter_status) {
            $query->where('status', $this->filter_status);
        }
    
        if ($this->filter_date_from) {
            $query->whereDate('order_date', '>=', $this->filter_date_from);
        }
    
        if ($this->filter_date_to) {
            $query->whereDate('order_date', '<=', $this->filter_date_to);
        }
    
        return view('livewire.orders', [
            'orders' => $query->latest()->paginate(10),
            'clients' => Client::all(),
        ]);
    }

    public function resetFilters()
    {
    $this->reset(['filter_client_id', 'filter_status', 'filter_date_from', 'filter_date_to']);
    }

    public function loadStats()
    {
    $this->stats = Order::selectRaw('YEAR(order_date) as year, MONTH(order_date) as month, COUNT(*) as orders_count, SUM(price * quantity) as total_revenue')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get()
        ->toArray();
    }

    public function sendEmail($id)
    {
    $order = Order::findOrFail($id);

    if ($order->client && $order->client->email) {
        Mail::to($order->client->email)->send(new OrderSent($order));
        session()->flash('message', 'El. laiškas išsiųstas klientui!');
    } else {
        session()->flash('message', 'Užsakymas neturi kliento el. pašto.');
    }
    }
}