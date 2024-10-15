<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Luigel\Paymongo\Facades\Paymongo;

class PaymentController extends Controller
{
    //
    public function pay(Request $request)
    {
        // dd($request);
        // dd('what');

        // $request->validate([
        //     'rate' => 'required',
        //     'foods' => 'required',
        //     'name' => 'required',
        //     'contact_number' => 'required',
        //     'venue' => 'required',
        //     'date' => 'required',
        //     'contract_payments' => 'required',
        //     'payment_method' => 'required',
        //     'status' => 'required',
        // ]);

        if($request->payment_method == 'walk_in')
        {
            return redirect(route('order.success', $request->all()));
        }

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
            'cancel_url' => route('orders'),
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
            'success_url' => route('order.success', $request->all()),
            'statement_descriptor' => 'Laravel Paymongo Library',
            'metadata' => [
                'Key' => 'Value'
            ]
        ]);

        return Inertia::location($checkout->checkout_url);

    }

    public function success(Request $request)
    {
        // dd($request->add_ons);
        
        // dd('hii');

        $order = Order::create([
            'user_id' => $request->user()->id,
            'rate_id' => $request['rate']['id'],
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'venue' => $request->venue,
            'date' => $request->date,
            'event_details' => $request->event_details,
            'message' => $request->message,
            'status' => $request->status,
            'contract_payments' => $request->contract_payments,
            'payment_method' => $request->payment_method,
        ]);

        if($request->add_ons && count($request->add_ons) > 0)
        {
            foreach ($request->add_ons as $add_on) 
            {
                OrderAddOn::create([
                    'order_id' => $order->id,
                    'add_on_id' => $add_on['id']
                ]);
            }
        }

        foreach ($request->foods as $food) 
        {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $food['product']['id'],
                'quantity' => $food['quantity'],
                'special_instructions' => $food['special_instructions']
            ]);
        }

        return redirect(route('dashboard'));

    }

}
