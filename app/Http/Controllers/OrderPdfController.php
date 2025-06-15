<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF; // dompdf fasadas

class OrderPdfController extends Controller
{
    public function generate(Order $order)
    {
        $order->load(['client', 'service']); // įkrauna ryšius

        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        return $pdf->download('saskaita-uzsakymas-'.$order->id.'.pdf');
    }
}