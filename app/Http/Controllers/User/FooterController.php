<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function term(){
        return view('user.footer.term');
    }

    public function shippingInformation(){
        return view('user.footer.shipping-information');
    }

    public function paymentConfirmation(){      
        return view('user.footer.payment-confirmation');
    }

    public function faq(){
        return view('user.footer.faq');
    }

    public function returnPolicy(){
        return view('user.footer.return-policy');
    }

    public function conditionOfUse(){
        return view('user.footer.condition-of-use');
    }

    public function about(){
        return view('user.footer.about');
    }

    public function contactCustomerCare(){
        return view('user.footer.contact-customer-care');
    }
}
