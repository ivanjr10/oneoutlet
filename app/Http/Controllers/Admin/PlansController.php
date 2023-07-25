<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plans;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Helper;

//Mercado Pago SDK
use MercadoPago\SDK as mpSDK;
use MercadoPago\Payment as mpPayment;
use MercadoPago\Payer as mpPayer;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plans::where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function add()
    {
        return view('admin.plans.add');
    }

    public function store(Request $request)
    {
        $checkfreeplan = Plans::where('price', (float)$request->price)->first();

        if (!empty($checkfreeplan)) {
            if ($request->price == "0") {
                return Redirect()->back()->with('error', trans('messages.free_plan_exist'));
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'description' => 'required',
                        'features' => 'required',
                        'price' => 'required',
                        'item_unit' => 'required',
                        'plan_period' => 'required',
                        'order_limit' => 'required'
                    ],
                    [
                        "name.required" => trans('messages.plan_name_required'),
                        "description.required" => trans('messages.description_required'),
                        "features.required" => trans('messages.features_required'),
                        "price.required" => trans('messages.price_required'),
                        "item_unit.required" => trans('messages.item_limit_required'),
                        "plan_period.required" => trans('messages.plan_period_required'),
                        "order_limit.required" => trans('messages.order_limit_required'),
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {

                    if ($request->custom_domain == "on") {
                        $custom_domain = 1;
                    } else {
                        $custom_domain = "2";
                    }

                    $plans = new Plans;
                    $plans->name = $request->name;
                    $plans->description = $request->description;
                    $plans->features = $request->features;
                    $plans->price = $request->price;
                    $plans->item_unit = $request->item_unit;
                    $plans->plan_period = $request->plan_period;
                    $plans->order_limit = $request->order_limit;
                    $plans->custom_domain = $custom_domain;
                    $plans->save();

                    return redirect(route('plans'))->with('success', trans('messages.success'));
                }
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                    'features' => 'required',
                    'price' => 'required',
                    'item_unit' => 'required',
                    'plan_period' => 'required',
                    'order_limit' => 'required'
                ],
                [
                    "name.required" => trans('messages.plan_name_required'),
                    "description.required" => trans('messages.description_required'),
                    "features.required" => trans('messages.features_required'),
                    "price.required" => trans('messages.price_required'),
                    "item_unit.required" => trans('messages.item_limit_required'),
                    "plan_period.required" => trans('messages.plan_period_required'),
                    "order_limit.required" => trans('messages.order_limit_required'),
                ]
            );
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                if ($request->custom_domain == "on") {
                    $custom_domain = 1;
                } else {
                    $custom_domain = "2";
                }

                $plans = new Plans;
                $plans->name = $request->name;
                $plans->description = $request->description;
                $plans->features = $request->features;
                $plans->price = $request->price;
                $plans->item_unit = $request->item_unit;
                $plans->plan_period = $request->plan_period;
                $plans->order_limit = $request->order_limit;
                $plans->custom_domain = $custom_domain;
                $plans->save();

                return redirect(route('plans'))->with('success', trans('messages.success'));
            }
        }
    }

    public function del(Request $request)
    {
        $del = Plans::where('id', $request->id)->update(['is_deleted' => 1]);
        if ($del) {
            return 1;
        } else {
            return 0;
        }
    }

    public function show($id)
    {
        $pdata = Plans::where('is_deleted', 2)->where('id', $id)->first();
        return view('admin.plans.show', compact('pdata'));
    }

    public function update(Request $request, $id)
    {
        $checkfreeplan = Plans::where('price', (float)$request->price)->where('id', '!=', $id)->first();

        if (!empty($checkfreeplan)) {
            if ($request->price == "0") {
                return Redirect()->back()->with('error', trans('messages.free_plan_exist'));
            } else {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'description' => 'required',
                        'features' => 'required',
                        'price' => 'required',
                        'item_unit' => 'required',
                        'plan_period' => 'required',
                        'order_limit' => 'required'
                    ],
                    [
                        "name.required" => trans('messages.plan_name_required'),
                        "description.required" => trans('messages.description_required'),
                        "features.required" => trans('messages.features_required'),
                        "price.required" => trans('messages.price_required'),
                        "item_unit.required" => trans('messages.item_limit_required'),
                        "plan_period.required" => trans('messages.plan_period_required'),
                        "order_limit.required" => trans('messages.order_limit_required'),
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {

                    if ($request->custom_domain == "on") {
                        $custom_domain = 1;
                    } else {
                        $custom_domain = "2";
                    }

                    Plans::where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'description' => $request->description,
                            'features' => $request->features,
                            'price' => $request->price,
                            'item_unit' => $request->item_unit,
                            'plan_period' => $request->plan_period,
                            'custom_domain' => $custom_domain,
                            'order_limit' => $request->order_limit
                        ]);
                    return redirect()->back()->with('success', trans('messages.success'));
                }
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                    'features' => 'required',
                    'price' => 'required',
                    'item_unit' => 'required',
                    'plan_period' => 'required',
                    'order_limit' => 'required'
                ],
                [
                    "name.required" => trans('messages.plan_name_required'),
                    "description.required" => trans('messages.description_required'),
                    "features.required" => trans('messages.features_required'),
                    "price.required" => trans('messages.price_required'),
                    "item_unit.required" => trans('messages.item_limit_required'),
                    "plan_period.required" => trans('messages.plan_period_required'),
                    "order_limit.required" => trans('messages.order_limit_required'),
                ]
            );
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                if ($request->custom_domain == "on") {
                    $custom_domain = 1;
                } else {
                    $custom_domain = "2";
                }

                Plans::where('id', $request->id)
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'features' => $request->features,
                        'price' => $request->price,
                        'item_unit' => $request->item_unit,
                        'plan_period' => $request->plan_period,
                        'custom_domain' => $custom_domain,
                        'order_limit' => $request->order_limit
                    ]);
                return redirect()->back()->with('success', trans('messages.success'));
            }
        }
    }

    public function plans()
    {
        $plans = Plans::orderBy('id', 'DESC')->paginate(10);
        return view('admin.plans.plans', compact('plans'));
    }

    public function purchase(Request $request)
    {
        $plans = Plans::where('id', $request->id)->first();
        $paymentlist = Payment::where('status', '1')->where('payment_name', '!=', 'COD')->where('restaurant', null)->get();
        $bankdetails = Payment::where('payment_name', 'PIX / Transferência Bancária')->where('restaurant', null)->first();
        return view('admin.plans.purchase', compact('plans', 'paymentlist', 'bankdetails'));
    }

    public function order(Request $request)
    {
        $plan = Plans::where('name', $request->plan)->first();

        date_default_timezone_set(Helper::webinfo(Auth::user()->id)->timezone);

        if ($request->payment_type == 3) {
            $paymentlist = Payment::where('status', '1')->where('payment_name', '!=', 'COD')->where('restaurant', null)->get();
            foreach ($paymentlist as $payment_method) {
                if ($payment_method->payment_name == "Mercado Pago") {
                    switch ($request->plan_period) {
                        case 1:
                            $repeticoes = 1;
                            break;
                        case 2:
                            $repeticoes = 3;
                            break;
                        case 3:
                            $repeticoes = 6;
                            break;
                        case 4:
                            $repeticoes = 12;
                            break;
                        default:
                            $repeticoes = 1;
                            break;
                    }
                    
                    $data = array(
                        "reason" => $plan->name,
                        "external_reference" => "Outlet-" . date('Y'),
                        "payer_email" => strval($request->payer['email']),
                        "card_token_id" => strval($request->token),
                        "auto_recurring" => array(
                            "frequency" => $repeticoes,
                            "frequency_type" => "months",
                            "start_date" => strval(gmdate('Y-m-d\TH:i:s.v\Z')),
                            "end_date" => strval(gmdate('Y-m-d\TH:i:s.u\Z', strtotime("+{$repeticoes} months"))),
                            "transaction_amount" => $request->transaction_amount,
                            "currency_id" => "BRL"
                        ),
                        "back_url" => "https://www.oneoutlet.com.br",
                        "status" => "authorized"
                    );
                    
                    $curl = curl_init();
                    
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.mercadopago.com/preapproval',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($data),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $payment_method->secret_key
                        ),
                    ));
                    
                    $response = curl_exec($curl);
                    curl_close($curl);
                    
                    $obj = json_decode($response);
                    
                    if ($obj === false) {
                        return response()->json(['message' => curl_error($curl)], 500);
                    } else if ($obj->status != 200) {
                        return response()->json(['message' => $obj->message ], $obj->status);
                    } else {
                        $payment_id = $obj->id;
                        $status = "1";
                    }
                }
            }
        }

        $transaction = new Transaction;

        if ($request->payment_type == 2) {
            if ($request->hasFile('screenshot')) {
                $validator = Validator::make($request->all(), [
                    'screenshot' => 'image|mimes:jpg,jpeg,png',
                ], [
                    'screenshot.mage' => trans('messages.enter_image_file'),
                    'screenshot.mimes' => trans('messages.valid_image'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    $file = $request->file('screenshot');
                    $filename = 'payment-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/payment/', $filename);
                    $transaction->screenshot = $filename;
                }
            }
            User::where('id', Auth::user()->id)
                ->update([
                    'payment_id' => @$payment_id,
                    'plan' => $request->plan,
                    'purchase_amount' => $request->amount,
                    'payment_type' => $request->payment_type,
                    'free_plan' => 1,
                    'purchase_date' => date("Y-m-d h:i:sa"),
                ]);
            $date = NULL;
            $status = "1";
            $amount = $request->amount;
        } else {
            User::where('id', Auth::user()->id)
                ->update([
                    'payment_id' => @$payment_id,
                    'plan' => $request->plan,
                    'purchase_amount' => $request->amount,
                    'payment_type' => $request->payment_type,
                    'free_plan' => 1,
                    'purchase_date' => date("Y-m-d h:i:sa"),
                ]);
            $date = date("Y-m-d h:i:sa");
            $status = "2";
            $amount = $request->amount;
        }

        $transaction->restaurant = Auth::user()->id;
        $transaction->plan = $request->plan;
        $transaction->amount = $amount;
        $transaction->payment_type = $request->payment_type;
        $transaction->payment_id = @$payment_id;
        $transaction->date = $date;
        $transaction->status = $status;
        $transaction->plan_period = $request->plan_period;
        $transaction->custom_domain = $plan->custom_domain;

        $transaction->save();

        $admininfo = User::where('type', 1)->first();

        $msg = trans('labels.new_vendor_subscription');
        $vmsg = trans('labels.subscribed_package');

        if ($request->payment_type == 2) {
            $payment_type = trans('labels.bank_transfer');
            $msg = trans('labels.request_for_subscription');
            $vmsg = trans('labels.received_package_request');
        }

        if ($request->payment_type == 0) {
            $payment_type =  "GRÁTIS";
        }

        if ($request->payment_type == 3) {
            $payment_type = "Mercado Pago : " . @$payment_id;
        }

        if ($request->payment_type == 2 or $request->payment_type == 0) {
            return redirect()->route('plans')->with('success', trans('messages.success'));
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        }
    }
}
