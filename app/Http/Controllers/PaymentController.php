<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Luigel\Paymongo\Facades\Paymongo;

class PaymentController extends Controller
{
    //

    public function checkout(string $id)
    {
        $order = Order::with('add_ons.add_on', 'rate', 'order_items.product')->findOrFail($id);

        $currentDate = Carbon::now();
        $eventDate = Carbon::parse($order->event_date);
        
        $monthsDifference = $currentDate->diffInMonths($eventDate);

        // Base rate and add-ons total
        $base_rate = $order->rate->price;
        $add_ons_total = $order->add_ons->sum(function ($orderAddOn) {
            return $orderAddOn->add_on->price;
        });

        // Initialize total amount
        $total_amount = $base_rate + $add_ons_total;

        // Apply 20% service charge if the event is a wedding
        $service_charge = 0;
        if (strtolower($order->event_type) === 'wedding') {
            $service_charge = $total_amount * 0.2; // 20% of the subtotal
            $total_amount += $service_charge;
        }
        // Determine the required payment amount
        $payment_details = [];
        if ($monthsDifference > 1 && $order->status == Order::STATUS_PENDING) {
            // Reservation fee if booked at least 2 months in advance
            $payment_details = [
                'payment_type' => 'reservation_fee',
                'amount' => 3000, // Reservation fee
                'total_amount' => $total_amount,
                'service_charge' => $service_charge,
                'add_ons_total' => $add_ons_total
            ];
        } 
        elseif ($order->status == Order::STATUS_DOWN_PAYMENT_PAID) {
            $payment_details = [
                'payment_type' => 'full_payment',
                'total_amount' => $total_amount,
                'amount' => $total_amount * 0.5,
                'service_charge' => $service_charge,
                'add_ons_total' => $add_ons_total
            ];
        }
        elseif ($monthsDifference < 1 || $order->status == Order::STATUS_RESERVATION_FEE_PAID) {
            // Down payment if the reservation is within 2 months
            $down_payment = $total_amount * 0.5; // 50% of the total amount
            $payment_details = [
                'payment_type' => 'down_payment',
                'amount' => $down_payment,
                'total_amount' => $total_amount,
                'service_charge' => $service_charge,
                'add_ons_total' => $add_ons_total
            ];
        }
        else {
            switch($order->status) {
                case Order::STATUS_RESERVATION_FEE_PENDING:
                    $payment_details = [
                        'payment_type' => 'reservation_fee',
                        'amount' => 3000, // Reservation fee
                        'total_amount' => $total_amount,
                        'service_charge' => $service_charge,
                        'add_ons_total' => $add_ons_total
                    ];
                break;
                case Order::STATUS_DOWN_PAYMENT_PENDING:
                    $payment_details = [
                        'payment_type' => 'down_payment',
                        'total_amount' => $total_amount,
                        'amount' => $total_amount * 0.5,
                        'service_charge' => $service_charge,
                        'add_ons_total' => $add_ons_total
                    ];
                break;
                case Order::STATUS_FULLY_PAID_PENDING:
                    $payment_details = [
                        'payment_type' => 'full_payment',
                        'total_amount' => $total_amount,
                        'amount' => $total_amount * 0.5,
                        'service_charge' => $service_charge,
                        'add_ons_total' => $add_ons_total
                    ];
                break;
            }
        }
        // ADD ANOTHER ONE IF THE EVENT IS TODAY
        // dd($payment_details);
        return Inertia::render('User/Checkout', compact('order', 'payment_details'));
    }

    public function pay(Request $request, OrderService $orderService)
    {
        if($request->payment_method == 'walk_in')
        {
            session(['checkout_data' => $request->all()]);
            return redirect(route('order.success'));
        }

        // array_push($line_items, [
        //     'amount' => $rateAmount,
        //     'currency' => 'PHP',
        //     'description' => $request['rate']['instructions'], 
        //     'name' => $request['rate']['pax'] . 'Pax',
        //     'quantity' => 1
        // ]);

        $line_items = [
            [
                'amount' => $request->amount * 100,
                'currency' => 'PHP',
                'description' => $request->payment_type,
                'name' => 'Virtucio Catering Service - ' . $request->pax . ' Pax',
                'quantity' => 1
            ]
        ];

        $checkout = Paymongo::checkout()->create([
            'cancel_url' => route('checkout', $request->order_id),
            'billing' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->contact_number,
            ],
            'description' => 'Virtucio Catering Service',
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
            'success_url' => route('order.success'),
            'statement_descriptor' => 'Laravel Paymongo Library',
            'metadata' => [
                'Key' => 'Value'
            ]
        ]);

        session(['checkout_id' => $checkout->id]);
        session(['checkout_data' => $request->all()]);

        return Inertia::location($checkout->checkout_url);

    }

    public function success(Request $request)
    {

        // dd(session('checkout_data'));
        $checkout_data = session('checkout_data');
        if(!$checkout_data) {
            abort(403);
        }
        $order = Order::find($checkout_data['order_id']);
        if ($checkout_data['payment_method'] === 'walk_in') {
            switch ($checkout_data['payment_type']) {
                case 'reservation_fee':
                    $order->update([
                        'status' => Order::STATUS_RESERVATION_FEE_PENDING,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                case 'down_payment':
                    $order->update([
                        'status' => Order::STATUS_DOWN_PAYMENT_PENDING,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                case 'full_payment':
                    $order->update([
                        'status' => Order::STATUS_FULLY_PAID_PENDING,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                default:
                    abort(400, 'Invalid payment type for walk-in.');
            }
        } else {
            switch ($checkout_data['payment_type']) {
                case 'reservation_fee':
                    $order->update([
                        'status' => Order::STATUS_RESERVATION_FEE_PAID,
                        'reservation_fee' => 0,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                case 'down_payment':
                    $down_payment = $checkout_data['amount']; // Amount paid as down payment
                    $order->update([
                        'status' => Order::STATUS_DOWN_PAYMENT_PAID,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                case 'full_payment':
                    $order->update([
                        'status' => Order::STATUS_FULLY_PAID,
                        'payment_method' => $checkout_data['payment_method']
                    ]);
                    break;
        
                default:
                    abort(400, 'Invalid payment type.');
            }
        }

        session()->forget('checkout_data');
        return redirect(route('orders.show', $order->id));

    }

    // public function pay_balance(Order $order, OrderService $orderService, Request $request)
    // {

    //     $total_amount = $orderService->getTotalAmount($order);
    //     $line_items = [
    //         [
    //             'amount' => $total_amount * 100,
    //             'currency' => 'PHP',
    //             'description' => $order->contract_payments == 'down_payment' ? 'Down Payment' : 'Full Payment',
    //             'name' => 'Virtucio Catering Service - ' . $order->rate->pax . ' Pax',
    //             'quantity' => 1
    //         ]
    //     ];

    //     $checkout = Paymongo::checkout()->create([
    //         'cancel_url' => route('orders'),
    //         'billing' => [
    //             'name' => $request->user()->name,
    //             'email' => $request->user()->email,
    //             'phone' => $request->contact_number,
    //         ],
    //         'description' => 'Pay the remaining balance of Order ' . $order->id,
    //         'line_items' => $line_items,
    //         'payment_method_types' => [
    //             'atome',
    //             'billease',
    //             'card',
    //             'dob',
    //             'dob_ubp',
    //             'gcash',
    //             'grab_pay', 
    //             'paymaya'
    //         ],
    //         'success_url' => route('order.pay_balance_success', ['order' => $order->id]),
    //         'statement_descriptor' => 'Laravel Paymongo Library',
    //         'metadata' => [
    //             'Key' => 'Value'
    //         ]
    //     ]);

    //     session(['checkout_id' => $checkout->id]);

    //     return Inertia::location($checkout->checkout_url);


    // }

    // public function pay_balance_success(Order $order)
    // {
    //     $order->update([
    //         'contract_payments' => 'full_payment'
    //     ]);

    //     return redirect(route('orders'));
    // }



}
