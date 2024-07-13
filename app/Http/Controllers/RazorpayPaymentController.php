<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use App\Models\OrderDetail;
use App\Models\Address;
use App\Models\FoodOrder;
use App\Models\Cart;

class RazorpayPaymentController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

     public function index()
     {
        // $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // $payment = $api->payment->fetch('pay_OUmxY991YcBdqO');

        // dd($payment);
     }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['payment']['razorpay_payment_id']);
        if(count($input)  && !empty($input['payment']['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['payment']['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }

        $addressData = [
            'address' => $request['address']['address'],
            'city' => $request['address']['city'],
            'state' => $request['address']['state'],
            'country' => $request['address']['country'],
            'phone' => $request['address']['phone'],
            'email' => $request['address']['email'],
        ];
        $addressId = Address::create($addressData)->id;

        $orderDetailData = [
            'payment_id' => $input['payment']['razorpay_payment_id'],
            'address_id' => $addressId,
            'user_id' => auth()->user()->id,
        ];

        $orderDetailId = OrderDetail::create($orderDetailData)->id;

        foreach ($input['carts'] as $key => $item) {

            $data = [
                'user_id' => auth()->user()->id,
                'restaurant_id' => $item['restaurant_id'],
                'restaurant_menu_id' => $item['restaurant_menu_id'],
                'restaurant_menu_item_id' => $item['restaurant_menu_item_id'],
                'order_id' => $orderDetailId,
                'status' => 'processing',
                'status_reason' => 'Just placed order',
                'quantity' => $item['quantity'],
                'price' => $item['restaurant_menu_item']['price'],
                'delivery_charge' => null,
                'delivery_type' => null,
                'payment_type' => null,
                'payment_status' => 'paid',
                'tax' => null,
                'instructions' => null,
                'discount' => null,
                'sub_total' => null,
                'total' => $item['quantity'] * $item['restaurant_menu_item']['price'],
            ];
            FoodOrder::create($data)->id;
            Cart::where('id', $item['id'])->delete();
        }

        // Session::put('success', 'Payment successful');
        $data = [

        ];

        return response()->json([
            'message' => 'Payment successful, Please Track your order.',
            'status' => 200,
        ]);
        // return redirect()->back()->with('flash.banner', 'Payment successful, Please Track your order');;
    }
}
