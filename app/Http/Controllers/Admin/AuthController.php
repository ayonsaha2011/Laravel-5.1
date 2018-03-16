<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth, Input, Session;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function index()
    {
        if ((Auth::check()) || (Auth::viaRemember()))
        {
            return Redirect::intended('panelarea');
        }
        else
        {
            return view('admin.login');
        }
    }

    public function forgetpassword()
    {
        if (Auth::check()) {
            return Redirect::intended('panelarea');
        }
        else
        {
             return view('admin.forgetpassword');
        }
    }

    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required', // make sure the email is an actual email
            'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('sspanel')
                ->withErrors($validator) 
                ->withInput(Input::except('password')); 
        } else {

    $userdata = array(
        'email'     => Input::get('email'),
        'password'  => Input::get('password')
    );
    $remember = (Input::has('remember')) ? true : false;
    
    if (Auth::attempt($userdata, $remember)) {
        return Redirect::intended('panelarea');

    } else {
            
                return Redirect::to('sspanel')->withErrors("Email or Password wrong try again");

            }

        }
    }


public function doLogout()
{
    Auth::logout(); // log the user out of our application
   return Redirect::intended('/sspanel');
}



}