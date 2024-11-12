<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Luigel\Paymongo\Facades\Paymongo;

class PaymentController extends Controller
{
    //
    public function pay(Request $request, OrderService $orderService)
    {
        if($request->payment_method == 'walk_in')
        {
            return redirect(route('order.success', $request->all()));
        }
        // dd($request);
        // dd($request['rate']['instructions']);
        // $isDownPayment = $request->contract_payments === 'down_payment';
        // $line_items = [];
        
        // if($request->add_ons && count($request->add_ons) > 0)
        // {
        //     foreach ($request->add_ons as $add_on) 
        //     {

        //         $amount = (double) $add_on['price'] * 100;
        //         // Apply 50% reduction if it is a down payment
        //         if ($isDownPayment) {
        //             $amount = $amount * 0.5;
        //         }

        //         array_push($line_items, [
        //             'amount' => $amount,
        //             'currency' => 'PHP',
        //             'description' => 'uhh',
        //             'name' => $add_on['name'],
        //             'quantity' => 1
        //         ]);
        //     }
        // }

        // foreach ($request->foods as $food) 
        // {
        //     $amount = (double)$food['product']['price'] * 100;
        //     // Apply 50% reduction if it is a down payment
        //     if ($isDownPayment) {
        //         $amount = $amount * 0.5;
        //     }

        //     array_push($line_items, [
        //         'amount' => $amount,
        //         'currency' => 'PHP',
        //         'description' => $food['special_instructions'], 
        //         'name' => $food['product']['name'],
        //         'quantity' => (int)$food['quantity']
        //     ]);
        // }

        // $rateAmount = (double)$request['rate']['price'] * 100;
        // // Apply 50% reduction if it is a down payment
        // if ($isDownPayment) {
        //     $rateAmount = $rateAmount * 0.5;
        // }

        // array_push($line_items, [
        //     'amount' => $rateAmount,
        //     'currency' => 'PHP',
        //     'description' => $request['rate']['instructions'], 
        //     'name' => $request['rate']['pax'] . 'Pax',
        //     'quantity' => 1
        // ]);

        $total_amount = $orderService->computeTotalAmount($request);

        // Add a single line item with the total amount
        $line_items = [
            [
                'amount' => $total_amount,
                'currency' => 'PHP',
                'description' => $request->contract_payments === 'down_payment' ? 'Down Payment' : 'Full Payment',
                'name' => 'Virtucio Catering Service - ' . $request['rate']['pax'] . ' Pax',
                'quantity' => 1
            ]
        ];

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

        session(['checkout_id' => $checkout->id]);

        return Inertia::location($checkout->checkout_url);

    }

    public function success(Request $request)
    {
        // dd($request->add_ons);
        
        // dd('hii');

        // rate: null,
        // add_ons: [],
        // name: '',
        // contact_number: '',
        // date: null,
        // venue: '',
        // event: '',
        // message: '',
        // status: 'pending',
        // payment_method: 'online',
        // contract_payments: 'full_payment',
        // soup: null,
        // main_dishes: [],
        // dessert: null
        $order = Order::create([
            'user_id' => $request->user()->id,
            'rate_id' => $request['rate']['id'],
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'venue' => $request->venue,
            'date' => $request->date,
            'event' => $request->event,
            'message' => $request->message,
            'status' => $request->status,
            'contract_payments' => $request->contract_payments,
            'payment_method' => $request->payment_method,
            'payment_id' => 'null'
        ]);
        // dd('hii');

        foreach($request->main_dishes as $dish) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $dish['id'],
                'category' => OrderItem::CATEGORY_MAIN_DISH
            ]);
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->soup['id'],
            'category' => OrderItem::CATEGORY_SOUP
        ]);

        OrderItem::create([
            'order_id' => $order['id'],
            'product_id' => $request->dessert['id'],
            'category' => OrderItem::CATEGORY_DESSERT
        ]);

        if($request->payment_method == 'online') {
            $checkout_session = Paymongo::checkout()->find(session('checkout_id'));
            $order->update([
                'payment_method' => $checkout_session->payment_method_used,
                'payment_id' => $checkout_session->payments[0]['id'],
                'status' => 'confirmed'
            ]);
        }

        // if($request->add_ons && count($request->add_ons) > 0)
        // {
        //     foreach ($request->add_ons as $add_on) 
        //     {
        //         OrderAddOn::create([
        //             'order_id' => $order->id,
        //             'add_on_id' => $add_on['id']
        //         ]);
        //     }
        // }

        return redirect(route('dashboard'));

    }

    public function pay_balance(Order $order, OrderService $orderService, Request $request)
    {

        $total_amount = $orderService->getTotalAmount($order);
        // dd($total_amount * 100);
        $line_items = [
            [
                'amount' => $total_amount * 100,
                'currency' => 'PHP',
                'description' => $order->contract_payments == 'down_payment' ? 'Down Payment' : 'Full Payment',
                'name' => 'Virtucio Catering Service - ' . $order->rate->pax . ' Pax',
                'quantity' => 1
            ]
        ];

        $checkout = Paymongo::checkout()->create([
            'cancel_url' => route('orders'),
            'billing' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->contact_number,
            ],
            'description' => 'Pay the remaining balance of Order ' . $order->id,
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
            'success_url' => route('order.pay_balance_success', ['order' => $order->id]),
            'statement_descriptor' => 'Laravel Paymongo Library',
            'metadata' => [
                'Key' => 'Value'
            ]
        ]);

        session(['checkout_id' => $checkout->id]);

        return Inertia::location($checkout->checkout_url);


    }

    public function pay_balance_success(Order $order)
    {
        $order->update([
            'contract_payments' => 'full_payment'
        ]);

        return redirect(route('orders'));
    }



}
