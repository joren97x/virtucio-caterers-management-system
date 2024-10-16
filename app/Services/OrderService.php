<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderService {
    public function computeTotalAmount(Request $request)
    {
        $totalAmount = 0;

        if ($request->add_ons && count($request->add_ons) > 0) {
            foreach ($request->add_ons as $add_on) {
                $totalAmount += (double) $add_on['price'] * 100;
            }
        }

        foreach ($request->foods as $food) {
            $totalAmount += (double) $food['product']['price'] * 100 * (int) $food['quantity'];
        }

        $totalAmount += (double) $request['rate']['price'] * 100;

        // Apply a 50% discount if it is a down payment
        if ($request->contract_payments === 'down_payment') {
            $totalAmount *= 0.5;
        }

        return $totalAmount;
    }

    public function getTotalAmount(Order $order)
    {
        // dd($order->add_ons[0]);
        $totalAmount = 0;

        if ($order->add_ons && count($order->add_ons) > 0) {
            foreach ($order->add_ons as $order_add_on) {
                // dd($order_add_on->add_on->price);
                $totalAmount +=  $order_add_on->add_on->price;
            }
        }
        // dd($totalAmount);
        foreach ($order->products as $order_product) {
            $totalAmount +=  $order_product->product->price *  $order_product->quantity;
        }

        $totalAmount += $order->rate->price;

        // Apply a 50% discount if it is a down payment
        if ($order->contract_payments === 'down_payment') {
            $totalAmount /= 2;
        }

        return $totalAmount;

    }

}