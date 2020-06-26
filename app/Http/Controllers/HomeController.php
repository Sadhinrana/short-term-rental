<?php

namespace App\Http\Controllers;

use App\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
        return redirect('/master-property');
    }

    public function registerFcmToken(Request $request)
    {
        FcmToken::whereDate('created_at', '<', date('Y-m-d'))->delete();

        $fcmToken = FcmToken::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'fcm_token' => $request->token
            ]);
        return response()->json([
            'message' => 'success',
            //'obj' => $fcmToken,
        ]);
    }
}
