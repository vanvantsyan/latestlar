<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.02.2018
 * Time: 13:09
 */

namespace App\Http\Controllers\Front;

use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function sendOrder(Request $request){

        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required_without:email|phone',
            'email' => 'required_without:phone|email',
            'comment' => 'max:500'
        ]);

        Mail::to(config('emails.order'))->send(new OrderShipped($request->all()));

        return ['ok' => 'true', 'message' => trans('messages.order.sended')];
    }
}