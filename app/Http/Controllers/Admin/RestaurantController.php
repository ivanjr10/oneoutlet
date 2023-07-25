<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Models\Plans;

use App\Models\Settings;

use App\Models\Timing;

use App\Models\Payment;

use App\Models\SystemAddons;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\DeliveryArea;
use App\Models\Extra;
use App\Models\Item;
use App\Models\Order;
use App\Models\Privacypolicy;
use App\Models\Tablebook;
use App\Models\Terms;
use App\Models\Transaction;
use App\Models\Variants;

use Str;

class RestaurantController extends Controller

{
    public function index()
    {
        $restaurants = User::where('type', 2)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.restaurants.index', compact('restaurants'));
    }
    public function add()
    {
        $plans = Plans::get();
        return view('admin.restaurants.add', compact('plans'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile'
        ], [
            "name.required" => trans('messages.restaurant_name_required'),
            "email.required" => trans('messages.email_required'),
            "email.email" => trans('messages.valid_email'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $check = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($check != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($request->name . " " . ($last->id + 1), '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $rec = Settings::where('restaurant', '1')->first();
            date_default_timezone_set($rec->timezone);
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash::make(123456);
            $user->mobile = $request->mobile;
            $user->image = "default-logo.png";
            $user->slug = $slug;
            $user->login_type = "email";
            $user->type = 2;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->save();
            $restaurant = \DB::getPdo()->lastInsertId();
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            foreach ($days as $day) {
                $timedata = new Timing;
                $timedata->restaurant = $restaurant;
                $timedata->day = $day;
                $timedata->open_time = '12:00am';
                $timedata->close_time = '11:59pm';
                $timedata->is_always_close = '2';
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
            $data->email = "";
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
Eu gostaria de fazer um pedido 👇
*{delivery_type}* Nº do pedido: {order_no}
---------------------------
{item_variable}
---------------------------
👉Taxa de Entrega: {delivery_charge}
👉Desconto: - {discount_amount}
---------------------------
📃 Total: {grand_total}
---------------------------
📄 Observação: {notes}

✅ Informação do Cliente
Nome do Cliente: {customer_name}
Telefone do Cliente: {customer_mobile}
📍 Detalhes de Entrega
Endereço: {address}, {building}, {landmark}
---------------------------
💳 Tipo de Pagamento:
{payment_type}
{store_name} confirmará seu pedido ao receber a mensagem.
Acompanhe seu pedido 👇
{track_order_url}
Clique aqui para o próximo pedido 👇
{store_url}";
            $data->save();
            return redirect(route('restaurants'))->with('success', trans('messages.success'));
        }
    }
    public function status(Request $request)
    {
        $status = User::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($status) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show($slug)
    {
        $plans = Plans::get();
        $rdata = User::where('slug', $slug)->first();
        return view('admin.restaurants.show', compact('rdata', 'plans'));
    }
    public function update(Request $request, $restaurant)
    {
        $rdata = User::where('slug', $restaurant)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $rdata->id,
            'mobile' => 'required|unique:users,mobile,' . $rdata->id,
        ], [
            "name.required" => trans('messages.restaurant_name_required'),
            "email.required" => trans('messages.email_required'),
            "email.email" => trans('messages.valid_email'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::find($rdata->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->save();
            return redirect(route('restaurants'))->with('success', trans('messages.success'));
        }
    }

    public function delete(Request $request)
    {
        $status = User::where('id', $request->id)->delete();
        if ($status) {
            Timing::where('restaurant', $request->id)->delete();
            Payment::where('restaurant', $request->id)->delete();
            Settings::where('restaurant', $request->id)->delete();
            Cart::where('restaurant', $request->id)->delete();
            Category::where('restaurant', $request->id)->delete();
            Coupons::where('restaurant', $request->id)->delete();
            DeliveryArea::where('restaurant', $request->id)->delete();
            Extra::where('restaurant', $request->id)->delete();
            Item::where('restaurant', $request->id)->delete();
            Order::where('restaurant', $request->id)->delete();
            Privacypolicy::where('restaurant', $request->id)->delete();
            Tablebook::where('restaurant', $request->id)->delete();
            Terms::where('restaurant', $request->id)->delete();
            Transaction::where('restaurant', $request->id)->delete();
            Variants::where('restaurant', $request->id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
