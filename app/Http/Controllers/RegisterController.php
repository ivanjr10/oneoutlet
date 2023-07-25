<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Timing;
use App\Models\Payment;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.auth.register');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
        ],[ 
            "name.required"=>trans('messages.restaurant_name_required'),
            "email.required"=>trans('messages.email_required'),
            "email.email"=>trans('messages.valid_email'),
            "email.unique"=>trans('messages.email_exist'),
            "mobile.required"=>trans('messages.mobile_required'),
            "mobile.unique"=>trans('messages.mobile_exist')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $check = User::where('slug',Str::slug($request->name, '-'))->first();
            if($check != ""){
                $last = User::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->name." ".($last->id+1),'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }

            $rec = Settings::where('restaurant','1')->first();

            date_default_timezone_set($rec->timezone);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash::make($request->password);
            $user->mobile = $request->mobile;
            $user->document_type = $request->tipo_documento;
            $user->document_id = $request->documento;
            $user->address = $request->endereco;            
            $user->address_number = $request->numero;            
            $user->zip_code = $request->cep;
            $user->image = "default-logo.png";
            $user->slug = $slug;
            $user->login_type = "email";
            $user->type = 2;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->save();

            $restaurant = \DB::getPdo()->lastInsertId();

            $days = [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ];

            foreach ($days as $day) {

                $timedata = new Timing;
                $timedata->restaurant =$restaurant;
                $timedata->day =$day;
                $timedata->open_time ='12:00';
                $timedata->close_time ='23:59';
                $timedata->is_always_close ='2';
                $timedata->save();
            }

            $check = SystemAddons::where('unique_identifier', 'payment')->first();

            $paymentlist = Payment::select('payment_name')->where('restaurant', null)->where('account_number', null)->get();

            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->restaurant = $restaurant;
                $gateway->payment_name = $payment->payment_name;
                $gateway->public_key = NULL;
                $gateway->secret_key = NULL;
                $gateway->encryption_key = NULL;
                $gateway->environment = '1';
                $gateway->status = '1';
                $gateway->save();
            }

            $data = new Settings;
            $data->restaurant = $restaurant;
            $data->currency = $rec->currency;
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = "";
            $data->contact = "";
            $data->email = $request->email;
            $data->description = "";
            $data->copyright = $rec->copyright;
            $data->website_title = "";
            $data->meta_title = "";
            $data->meta_description = "";
            $data->facebook_link = "Insira o link do seu Facebook aqui";
            $data->linkedin_link = "Insira o link do seu Linkedin aqui";
            $data->instagram_link = "Insira o link do seu Instagram aqui";
            $data->twitter_link = "Insira o link do seu Twitter aqui";
            $data->delivery_type = "both";
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->whatsapp_message = "Olá,
            Eu gostaria de confirmar meu pedido 👇
            *{delivery_type}* Nº do pedido: {order_no}
            --------------------------- 
            {item_variable} 
            --------------------------- 
            👉 Taxa de Entrega : {delivery_charge} 
            👉 Desconto : - {discount_amount} 
            --------------------------- 
            📃 Total : {grand_total}
            --------------------------- 
            📄 Observação : {notes}
            
            ✅ Informação do Cliente 
            Nome do Cliente: {customer_name} 
            Telefone do Cliente: {customer_mobile} 
            📍 Detalhe da Entrega Endereço : {address}, {building}, {landmark} 
            --------------------------- 
            💳 Forma de pagamento: {payment_type} 
            {store_name} irá confirmar seu pedido assim que receber a mensagem. 
            Acompanhe seu pedido por aqui 👇 
            {track_order_url} 
            Use sempre esse link para continuar comprando com a gente! 👇 
            {store_url}";

            $data->save();

            Auth::attempt($request->only('email', 'password'));

            return redirect()->route('dashboard');
        }
    }
}
