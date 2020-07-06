<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function index(){

        if(Cart::content()->count()==0){

            Session::flash('info','Your cart is still empty. do some shopping');

               return redirect()->back();
        }


        return view('checkout');
    }


    public function pay(){

     // dd(request()->all());

        Stripe::setApiKey('sk_test_TnnnAMbWNITimWdOswR5snmD007HRbiVOR');

        $token=request()->stripeToken;

        $charge=Charge::create([
            'amount'=>Cart::total()*100,
            'currency'=>'usd',
            'description'=>'Udemy course selling book',
            'source'=>$token]);
        //dd('charged');
        Session::flash('success','Successfully charged ,wait for our email');

        Cart::destroy();


        return redirect('/');



    }



}
