<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Session;
use Helper;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }
    public function check_admin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => trans('messages.email_required'),
            'email.email' =>  trans('messages.invalid_email'),
            'password.required' => trans('messages.password_required'),
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (!Auth::user()) {
                return Redirect::to('/admin/verification')->with('error', Session::get('from_message'));
            }

            if (Auth::user()->type == 1) {
                return redirect('/admin/dashboard');
            } else {
                if (Auth::user()->type == 2) {
                    if (Auth::user()->is_available == 1) {
                        return redirect('/admin/dashboard');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.block'));
                    }
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                }
            }
        } else {
            return redirect()->back()->with('error', trans('messages.email_password_not_match'));
        }
    }
    public function logout() {
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function forgotpassword() {
        return view('admin.auth.forgot-password');
    }

    public function new_password(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ],  [
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $checkadmin = User::where('email', $request->email)->where('type', 2)->first();
            if (!empty($checkadmin)) {
                $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $pass = Helper::send_pass($checkadmin->email, $checkadmin->name, $password, $checkadmin->id);
                if ($pass == 1) {
                    $checkadmin->password = Hash::make($password);
                    $checkadmin->save();
                    return redirect('admin')->with('success', trans('messages.password_sent'));
                } else {
                    return redirect()->back()->with('error', trans('messages.email_error'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_email'));
            }
        }
    }

    public function systemverification(Request $request)
    {
        $username = str_replace(' ','',$request->username);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6ImY4K01NN3Bzc3BEbXRMYzdwWGhaQ2c9PSIsInZhbHVlIjoiTCtHYjhSTWt1WVErOTlxMXFEUldIaWdodHJGQnN3Ly8zS2lPYXA4L0xrQ0dINXEyTEdYcWRPYis1UkNtaGU4MmRNQ1ZhMUJRMVpEK0RGS2s2Nlo0b1E9PSIsIm1hYyI6ImZiZmE5NmE4YzY5OGNhOWRhZTQ3OGNjMWNkOWY5OWNmNDdhMDBjNzhiYTFmM2EyMTRlYjQ3ZTVkZTA4NTAzYmIiLCJ0YWciOiIifQ=='), [
            'form_params' => [
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IklzMFlnQ1pYUmxmTGRmV3VMam5qQ2c9PSIsInZhbHVlIjoiMFZWK054NjUyVkF3dkV6TW9rSVNWVnRmdktTWTJoQUF2YWl2SHpWQy9IOD0iLCJtYWMiOiJlNDJhZGU4Yjk5ZGE4MzM2MWE1NjUyY2JlMTY5ZGE3MzQyYmMwY2QwOTdlOWIyY2Y0NmM5OGI1MzE0NGViODRhIiwidGFnIjoiIn0=') => $username,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkNOZjMxcmZuZHJLdW1pb0o5anh1Vmc9PSIsInZhbHVlIjoiYVR0MHdXaEQ2QlVjZU8yMWh6dEpDZz09IiwibWFjIjoiNDU1ODczMmQ2MGE2MjMyMjc1ZTg0ODBhMjAzOTY2MjJiZmUyYTMwNTMwNmUwNjUyYmFjNWQ4ODRlNjFhOGVhYiIsInRhZyI6IiJ9') => $request->email,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6InRzOFU3SWlyZkV5VkRSV1YrMEZWY3c9PSIsInZhbHVlIjoiYWxOaDBqSTMyWk9XMXUzdWc1Rzdhc2s0M1NQOGlqWFI3LzQxeWNUbERBND0iLCJtYWMiOiIzZjY4YjE2YjRmYmNmMmQ3YTdkMDk5ZTIwM2Q2NDg4YWZjNmZkOWVlNjQwYWUxNWVmMWJhNTcwYzkyYjc3MmY3IiwidGFnIjoiIn0=') =>$request->purchase_key,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IjBHS0ljeFU1VWFwcHg4djUrVXAvTGc9PSIsInZhbHVlIjoiMXZLYzVWOWdIcHorOXRIbHZlRGV6QT09IiwibWFjIjoiM2IxZTc0ZDBkZjBjYTU2MzE1Nzc5MWM5MjQxYjI2MzU1YTdhZDkzNGI5NDQ2YTg3MjRiMzhhYjhhMTY5YmJkZiIsInRhZyI6IiJ9') =>$request->domain,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ino2aEh6cjR6WjY2elZia0tiWWdxc2c9PSIsInZhbHVlIjoiaGZ1TDV1c3V4UlZ5WTQrajBLWVJ2QjNkQjJWNVdLcExwVTA3RzZ1Y1lycz0iLCJtYWMiOiIzMjVhYjM2ZTg1MGNjNjJhYTExNDQyMzEwZmQxZmVkZThmMzFmZTNlZDExOTliZjA1YzM5ZDE4MzgwMWJiMGI2IiwidGFnIjoiIn0=') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ik5vdjlDdEI2eVNvdmdBL096WlB1M0E9PSIsInZhbHVlIjoiSnNvM2JSa25lZ3VMZTF0U0grS3BRUT09IiwibWFjIjoiZDE2NDRjMjM1NzQ1NjQxMzE3MDI1YzI4NDg3NDU2MjZiM2QzODI4Y2VjNDU1MmU3NDNkMDI0NWY3YmYxYjgzNiIsInRhZyI6IiJ9'),
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ik9vdEVGWWpGZmZQS0dEcjRtYWZYN3c9PSIsInZhbHVlIjoiZFo5Vno4SnhuZTA1Yld6bDB0Q1lLQT09IiwibWFjIjoiMDJlYTNkYWZhN2M0YmMyNWQ3ZGJmNTIxMDU0ZGY3OWE1MDBhN2E5YjQwMDgzNGQ3NTQ1NTE3YjMxYjA1ZDFlMiIsInRhZyI6IiJ9') =>\Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Imw3eVdJTDBuOXR5ZURtMDZkRTV1b0E9PSIsInZhbHVlIjoiWjUxdndLVGJvcWxQNXcvYjZnTTR0Zz09IiwibWFjIjoiOGY5MmQ0NjdjNzBlZGEyMzQ0N2VmZTMxZTk2Yzk4MGY1YjM3MDU4YzYyMTRkY2M2YTdmMzFiMzczZGFjNjE0MyIsInRhZyI6IiJ9'),
            ]
        ]);

        $obj = json_decode($res->getBody());

        if ($obj->status == '1') {
            return Redirect::to('/admin')->with('success', 'Success');
        } else {
            return Redirect::back()->with('error', $obj->message);
        }

    }
}
