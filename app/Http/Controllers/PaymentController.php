<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Luigel\Paymongo\Facades\Paymongo;

class PaymentController extends Controller
{
    //
    public function pay(Request $request)
    {
        // dd($request['rate']['instructions']);

        $line_items = [];
        
        if(count($request->add_ons) > 0)
        {
            foreach ($request->add_ons as $add_on) 
            {
                array_push($line_items, [
                    'amount' => (double)$add_on['price'] * 100,
                    'currency' => 'PHP',
                    'description' => 'uhh',
                    'name' => $add_on['name'],
                    'quantity' => 1
                ]);
            }
        }

        foreach ($request->foods as $food) 
        {
            array_push($line_items, [
                'amount' => (double)$food['product']['price'] * 100,
                'currency' => 'PHP',
                'description' => $food['special_instructions'], 
                'name' => $food['product']['name'],
                'quantity' => (int)$food['quantity']
            ]);
        }

        array_push($line_items, [
            'amount' => (double)$request['rate']['price'] * 100,
            'currency' => 'PHP',
            'description' => $request['rate']['instructions'], 
            'name' => $request['rate']['pax'] . 'Pax',
            'quantity' => 1
        ]);

        $checkout = Paymongo::checkout()->create([
            'cancel_url' => route('order'),
            'billing' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->contact_number,
            ],
            'description' => 'My checkout session description',
            'line_items' => $line_items,
            'payment_method_types' => [
                'atome',
                'billease',
                'card',
                'dob',
                'dob_ubp',
                'gcash',
                'grab_pay', 
                'paymaya'
            ],
            'success_url' => route('dashboard'),
            'statement_descriptor' => 'Laravel Paymongo Library',
            'metadata' => [
                'Key' => 'Value'
            ]
        ]);

        return Inertia::location($checkout->checkout_url);

    }

    public function success(Request $request)
    {
        
    }

}
