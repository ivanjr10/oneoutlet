@include('front.theme.header')
<section class="cart">
    <div class="container">
        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.my_cart') }}
            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "delivery")
            <span class="text-danger">{{Helper::getrestaurant($getrestaurant->slug)->name}} {{trans('labels.provide_only_delivery')}}</span>
            @endif
            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "pickup")
            <span class="text-danger">{{Helper::getrestaurant($getrestaurant->slug)->name}} {{trans('labels.provide_only_pickup')}}</span>
            @endif
        </h2>
        <div class="row">
            @if (count($cartdata) == 0)
            <p>No Data found</p>
            @else
            <div class="col-lg-8">
                @foreach ($cartdata as $cart)
                <?php
                $data[] = array(
                    "total_price" => $cart->qty * $cart->price,
                    "tax" => ($cart->qty * $cart->price) * $cart->tax / 100
                );
                ?>
                <div class="cart-box">
                    <div class="cart-pro-img">
                        <img src="{{asset('storage/app/public/item/'.$cart->item_image)}}" alt="">
                    </div>
                    <div class="cart-pro-details">
                        <div class="cart-pro-edit">
                            <a href="#" class="cart-pro-name {{session()->get('direction') == 2 ? 'text-right' : '' }}">
                                {{$cart->item_name}} -
                                @if ($cart->variants_id != "")
                                {{$cart->variants_name}}
                                <span>
                                    {{Helper::currency_format($cart->variants_price,$getrestaurant->id)}}
                                </span>
                                @else
                                <span>
                                    {{Helper::currency_format($cart->item_price,$getrestaurant->id)}}
                                </span>
                                @endif
                            </a>
                            <a href="javascript:void(0)"><i class="fal fa-trash-alt" onclick="RemoveCart('{{$cart->id}}')"></i></a>
                        </div>
                        <div class="cart-pro-edit">
                            <div class="pro-add">
                                <div class="value-button sub" id="decrease" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','decreaseValue')" value="Decrease Value">
                                    <i class="fal fa-minus-circle"></i>
                                </div>
                                <input type="number" id="number_{{$cart->id}}" name="number" value="{{$cart->qty}}" min="1" style="background-color: #f7f7f7;" />
                                <div class="value-button add" id="increase" onclick="qtyupdate('{{$cart->id}}','{{$cart->item_id}}','increase')" value="Increase Value">
                                    <i class="fal fa-plus-circle"></i>
                                </div>
                            </div>
                            <p class="cart-pricing">{{Helper::currency_format($cart->qty * $cart->price,$getrestaurant->id)}}</p>
                        </div>

                        @if ($cart->extras_id != "")
                        <div class="cart-addons-wrap">
                            <?php
                            $extras_id = explode(",", $cart->extras_id);
                            $extras_price = explode(",", $cart->extras_price);
                            $extras_name = explode(",", $cart->extras_name);
                            ?>
                            @foreach ($extras_id as $key => $addons)
                            <div class="cart-addons">
                                <b>{{$extras_name[$key]}}</b> : <b style="color: #000; text-align: center;">{{Helper::currency_format($extras_price[$key],$getrestaurant->id)}}</b>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                <center>
                    <div class="col-lg-6 mt-3">
                        <div class="cart-delivery-type open">
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "delivery")
                            <label for="cart-delivery">
                                <input type="radio" name="cart-delivery" id="cart-delivery" checked value="1">
                            </label>
                            @endif
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "pickup")
                            <label for="cart-pickup">
                                <input type="radio" name="cart-delivery" id="cart-pickup" checked value="2">
                            </label>
                            @endif
                            @if (Helper::webinfo($getrestaurant->id)->delivery_type == "both")
                            <label for="cart-delivery">
                                <input type="radio" name="cart-delivery" id="cart-delivery" checked value="1">
                                <div class="cart-delivery-type-box">
                                    <p>{{ trans('labels.delivery') }}</p>
                                </div>
                            </label>
                            <label for="cart-pickup">
                                <input type="radio" name="cart-delivery" id="cart-pickup" value="2">
                                <div class="cart-delivery-type-box">
                                    <p>{{ trans('labels.pickup') }}</p>
                                </div>
                            </label>
                            @endif
                        </div>
                    </div>
                </center>

                <input type="hidden" name="delivery_date" id="delivery_dt" value="">
                <input type="hidden" name="delivery_time" id="delivery_time" value="">

                <div class="col-12 mt-3" id="open">
                    <div class="cart-summary">
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{trans('labels.delivery_info')}}</h2>
                        <div class="promo-wrap mt-3">
                            <select name="delivery_area" id="delivery_area" class="form-control">
                                <option value="">{{trans('labels.select')}}</option>
                                @foreach ($deliveryarea as $area)
                                <option value="{{$area->name}}" price="{{$area->price}}">{{$area->name}} - {{Helper::currency_format($area->price,$getrestaurant->id)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="promo-wrap mt-3">
                            <input type="text" placeholder="{{ trans('messages.enter_delivery_address') }}" name="address" id="address" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_building') }}" name="building" id="building" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_landmark') }}" name="landmark" id="landmark" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" id="postal_code" name="postal_code" placeholder="{{ trans('messages.enter_pincode') }}" required="" />
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="cart-summary">
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{trans('labels.customer')}}</h2>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('labels.enter_name') }}" name="customer_name" id="customer_name" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('labels.enter_email') }}" name="customer_email" id="customer_email" required="">
                        </div>
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('labels.enter_mobile') }}" name="customer_mobile" id="customer_mobile" required="">
                        </div>
                        <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.notes') }}</h2>
                        <div class="promo-wrap mt-3">
                            <textarea name="notes" id="notes" placeholder="{{ trans('labels.enter_order_note') }}" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="restaurant" name="restaurant" value="{{Helper::getrestaurant($getrestaurant->slug)->id}}" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3">
                <?php
                $sub_total = array_sum(array_column(@$data, 'total_price'));
                $tax = array_sum(array_column(@$data, 'tax'));
                $total = array_sum(array_column(@$data, 'total_price'));
                ?>
                <div class="cart-summary">
                    <h2 class="sec-head {{ session()->get('direction') == '2' ? 'text-right' : '' }}">{{ trans('labels.payment_summary') }}</h2>
                    <p class="pro-total" id="subtotal">{{ trans('labels.sub_total') }} <span>{{Helper::currency_format($sub_total,$getrestaurant->id)}}</span></p>
                    <p class="pro-total" id="delivery_charge_hide">{{ trans('labels.delivery_charge') }}<span id="shipping_charge">{{Helper::currency_format('0.0',$getrestaurant->id)}}</span></p>
                    @if (Session::has('offer_amount'))
                    <p class="pro-total offer_amount">{{ trans('labels.discount') }} ({{Session::get('offer_code')}})</span>
                        <span id="offer_amount">
                            - {{Helper::currency_format(Session::get('offer_amount'),$getrestaurant->id)}}
                        </span>
                    </p>
                    @endif
                    @if (Session::has('offer_amount'))
                    <p class="cart-total">{{ trans('labels.total_amount') }} <span id="total_amount">
                            {{Helper::currency_format($total+$tax-Session::get('offer_amount'),$getrestaurant->id)}}
                        </span></p>
                    @else
                    <p class="cart-total">{{ trans('labels.total_amount') }} <span id="total_amount">{{Helper::currency_format($total+$tax,$getrestaurant->id)}}</span></p>
                    @endif
                    @if (App\Models\SystemAddons::where('unique_identifier', 'coupons')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'coupons')->first()->activated)
                    @if (Session::has('offer_amount'))
                    <div class="promo-code mt-3">
                        <div class="promo-wrap">
                            <input type="text" name="removepromocode" id="removepromocode" autocomplete="off" readonly="" value="{{Session::get('offer_code')}}">
                            <button class="btn" onclick="RemoveCopon()">{{ trans('labels.remove') }}</button>
                        </div>
                    </div>
                    @else
                    <div class="promo-code mt-3">
                        <div class="promo-wrap">
                            <input type="text" placeholder="{{ trans('messages.enter_promocode') }}" name="promocode" id="promocode" autocomplete="off">
                            <button class="btn" onclick="ApplyCopon()">{{ trans('labels.apply') }}</button>
                        </div>
                    </div>
                    @endif
                    @endif
                    <input type="hidden" name="sub_total" id="sub_total" value="{{$sub_total}}">
                    <input type="hidden" name="tax" id="tax" value="{{$tax}}">
                    <input type="hidden" name="delivery_charge" id="delivery_charge" value="0">
                    @if (Session::has('offer_amount'))
                    <input type="hidden" name="grand_total" id="grand_total" value="{{number_format($total-Session::get('offer_amount'), 2)}}">
                    @else
                    <input type="hidden" name="grand_total" id="grand_total" value="{{number_format($total, 2)}}">
                    @endif

                    <!-- List group -->
                    <div class="list-group list-group-sm mt-3">
                        @if (App\Models\SystemAddons::where('unique_identifier', 'payment')->first() == "")
                        <div class="list-group-item">
                            <!-- Radio -->
                            <div class="custom-control custom-radio ">
                                <!-- Input -->
                                <input class="custom-control-input w-auto position-fixed" id="{{trans('labels.cod')}}" data-payment_type="{{trans('labels.cod')}}" name="payment" type="radio" checked>
                                <!-- Label -->
                                <label class="custom-control-label font-size-sm text-body text-nowrap" for="{{trans('labels.cod')}}">
                                    {{trans('labels.cod')}}
                                </label>
                            </div>
                        </div>
                        @else
                        @foreach ($paymentlist as $key => $payment)
                        <div class="list-group-item">
                            <!-- Radio -->
                            <div class="custom-control custom-radio">
                                <!-- Input -->
                                <input class="custom-control-input w-auto position-fixed" id="{{$payment->payment_name}}" data-payment_type="{{$payment->payment_name}}" name="payment" type="radio" @if (!$key) {!! "checked" !!} @endif onchange="handlePaymentSelection(this)">
                                <!-- Label -->
                                <label class="custom-control-label font-size-sm text-body text-nowrap" for="{{$payment->payment_name}}">
                                    @if($payment->payment_name == "Mercado Pago")
                                    <img src="{{asset('storage/app/public/front/images/credit-card.png')}}" class="img-fluid ml-2" alt="" width="30px" />
                                    <input type="hidden" name="mercadopago" id="mercadopago" value="{{$payment->public_key}}">
                                    @endif

                                    @if($payment->payment_name == "Mercado Pago")
                                    Cartão de Crédito / Débito
                                    @elseif($payment->payment_name == "COD")
                                    Pagamento na Entrega
                                    @else
                                    {{$payment->payment_name}}
                                    @endif
                                </label>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="button" style="width: 100%;" class="btn open comman" id="button1" onclick="Order()">{{ trans('labels.whatsapp_order') }}</button>
                        <button type="button" style="width: 100%; display: none;" class="btn open comman" id="button2" data-toggle="modal" data-target="#mercadoPagoModal">{{ trans('labels.whatsapp_order') }}</button>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <input type="hidden" id="delivery_time_required" value="{{trans('messages.delivery_time_required')}}">
    <input type="hidden" id="delivery_date_required" value="{{trans('messages.delivery_date_required')}}">
    <input type="hidden" id="address_required" value="{{trans('messages.address_required')}}">
    <input type="hidden" id="no_required" value="{{trans('messages.no_required')}}">
    <input type="hidden" id="landmark_required" value="{{trans('messages.landmark_required')}}">
    <input type="hidden" id="pincode_required" value="{{trans('messages.pincode_required')}}">
    <input type="hidden" id="delivery_area_required" value="{{trans('messages.delivery_area_required')}}">
    <input type="hidden" id="pickup_time_required" value="{{trans('messages.pickup_time_required')}}">
    <input type="hidden" id="customer_mobile_required" value="{{trans('messages.customer_mobile_required')}}">
    <input type="hidden" id="customer_email_required" value="{{trans('messages.customer_email_required')}}">
    <input type="hidden" id="customer_name_required" value="{{trans('messages.customer_name_required')}}">
    <input type="hidden" id="currency" value="{{Helper::webinfo($getrestaurant->id)->currency}}">
    @if (Session::has('offer_amount'))
    <input type="hidden" name="discount_amount" id="discount_amount" value="{{Session::get('offer_amount')}}">
    <input type="hidden" name="couponcode" id="couponcode" value="{{Session::get('offer_code')}}">
    @else
    <input type="hidden" name="discount_amount" id="discount_amount" value="">
    <input type="hidden" name="couponcode" id="couponcode" value="">
    @endif
</section>
@include('front.theme.footer')

<div class="modal fade" id="mercadoPagoModal" tabindex="-1" role="dialog" aria-labelledby="mercadoPagoModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mercadoPagoModalLabel">Escolha sua forma de pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="cardPaymentBrick_container">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://sdk.mercadopago.com/js/v2">
</script>

<script>
    const mp = new MercadoPago("{{$payment->public_key}}");
    const bricksBuilder = mp.bricks();
    const renderCardPaymentBrick = async (bricksBuilder) => {
        const settings = {
            initialization: {
                amount: parseFloat($('#sub_total').val()),
                payer: {
                    email: "",
                },
            },
            customization: {
                visual: {
                    style: {
                        theme: 'bootstrap',
                    }
                },
                paymentMethods: {
                    minInstallments: 1,
                    maxInstallments: 1
                },
            },
            callbacks: {
                onReady: () => {
                    console.log("Formulário carregado");
                },
                onSubmit: (cardFormData) => {
                    var sub_total = parseFloat($('#sub_total').val());
                    var tax = parseFloat($('#tax').val());
                    var grand_total = parseFloat($('#grand_total').val());
                    var delivery_time = $('#delivery_time').val();
                    var delivery_date = $('#delivery_dt').val();
                    var delivery_area = $('#delivery_area').val();
                    var delivery_charge = parseFloat($('#delivery_charge').val());
                    var discount_amount = parseFloat($('#discount_amount').val());
                    var couponcode = $('#couponcode').val();
                    var order_type = $("input:radio[name=cart-delivery]:checked").val();
                    var address = $('#address').val();
                    var postal_code = $('#postal_code').val();
                    var building = $('#building').val();
                    var landmark = $('#landmark').val();
                    var notes = $('#notes').val();
                    var customer_name = $('#customer_name').val();
                    var customer_email = $('#customer_email').val();
                    var customer_mobile = $('#customer_mobile').val();
                    var restaurant = $('#restaurant').val();
                    var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");
                    var flutterwavekey = $('#flutterwavekey').val();
                    var paystackkey = $('#paystackkey').val();
                    if (order_type == "1") {
                        if (delivery_time == "") {
                            $('#ermsg').text($('#delivery_time_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (delivery_date == "") {
                            $('#ermsg').text($('#delivery_date_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (address == "") {
                            $('#ermsg').text($('#address_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (building == "") {
                            $('#ermsg').text($('#no_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (landmark == "") {
                            $('#ermsg').text($('#landmark_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (postal_code == "") {
                            $('#ermsg').text($('#pincode_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (delivery_area == "") {
                            $('#ermsg').text($('#delivery_area_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_name == "") {
                            $('#ermsg').text($('#customer_name_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_email == "") {
                            $('#ermsg').text($('#customer_email_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_mobile == "") {
                            $('#ermsg').text($('#customer_mobile_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        }
                    } else if (order_type == "2") {
                        if (delivery_time == "") {
                            $('#ermsg').text($('#pickup_time_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (delivery_date == "") {
                            $('#ermsg').text($('#delivery_date_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_name == "") {
                            $('#ermsg').text($('#customer_name_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_email == "") {
                            $('#ermsg').text($('#customer_email_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        } else if (customer_mobile == "") {
                            $('#ermsg').text($('#customer_mobile_required').val());
                            $('#error-msg').addClass('alert-danger');
                            $('#error-msg').css("display", "block");
                            setTimeout(function() {
                                $("#error-msg").hide();
                            }, 5000);
                            return false;
                        }
                    }
                    $('#preloader').show();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ URL::to('/orders/checkplan') }}",
                        data: {
                            restaurant: restaurant,
                        },
                        method: 'POST',
                        success: function(response) {
                            if (response.status == 1) {
                                console.log("Chamada da transação");
                                return new Promise((resolve, reject) => {
                                    let requestBody = Object.assign({}, cardFormData, {
                                        sub_total: sub_total,
                                        tax: tax,
                                        grand_total: grand_total,
                                        delivery_time: delivery_time,
                                        delivery_date: delivery_date,
                                        delivery_area: delivery_area,
                                        delivery_charge: delivery_charge,
                                        discount_amount: discount_amount,
                                        couponcode: couponcode,
                                        order_type: order_type,
                                        address: address,
                                        postal_code: postal_code,
                                        building: building,
                                        landmark: landmark,
                                        notes: notes,
                                        customer_name: customer_name,
                                        customer_email: customer_email,
                                        customer_mobile: customer_mobile,
                                        restaurant: restaurant,
                                        payment_type: payment_type
                                    });
                                    fetch("{{ URL::to('/orders/whatsapporder') }}", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                                            },
                                            body: JSON.stringify(requestBody)
                                        })
                                        .then((response) => {
                                            $('#preloader').hide();
                                            if (response.status == 200) {
                                                response.json().then((data) => {
                                                    window.location.href = "{{URL::to($getrestaurant->slug)}}/success/" + data.order_number;
                                                });
                                            } else {
                                                $('#ermsg').text(response.message);
                                                $('#error-msg').addClass('alert-danger');
                                                $('#error-msg').css("display", "block");
                                                setTimeout(function() {
                                                    $("#error-msg").hide();
                                                }, 5000);
                                            }
                                            resolve();
                                        })
                                        .catch((error) => {
                                            $('#preloader').hide();
                                            reject();
                                        })
                                });
                            } else {
                                $('#preloader').hide();
                                $('#ermsg').text(response.message);
                                $('#error-msg').addClass('alert-danger');
                                $('#error-msg').css("display", "block");
                                setTimeout(function() {
                                    $("#error-msg").hide();
                                }, 5000);
                            }
                        },
                        error: function(error) {
                            $('#preloader').hide();
                        }
                    });
                },
                onError: (error) => {
                    $('#preloader').hide();
                },
            },
        };
        window.cardPaymentBrickController = await bricksBuilder.create('cardPayment', 'cardPaymentBrick_container', settings);
    };
    renderCardPaymentBrick(bricksBuilder);
</script>

<script>
    $(document).ready(function() {

        // Obter a data e hora atual 
        var currentDate = new Date();
        var offset = -3; // Horário de Brasília
        var currentDateTime = new Date(currentDate.getTime() + (offset * 60 * 60 * 1000)); // Adicionar uma hora

        // Formatar a data e hora no formato desejado (YYYY-MM-DD e HH:MM) 
        var formattedDate = currentDate.toISOString().split('T')[0];
        var formattedTime = currentDateTime.toISOString().slice(11, 16);

        // Definir os valores ocultos com a data atual e o horário atual mais uma hora
        document.getElementById("delivery_dt").value = formattedDate;
        document.getElementById("delivery_time").value = formattedTime;

        $("input[name$='cart-delivery']").click(function() {
            var test = $(this).val();
            if (test == 1) {
                $("#open").show();
                $("#delivery_charge_hide").show();
                $("#delivery").show();
                $("#pickup").hide();
                $("#delivery_date").show();
                $("#pickup_date").hide();
                var sub_total = parseFloat($('#sub_total').val());
                var delivery_charge = parseFloat($('#delivery_charge').val());
                var tax = parseFloat($('#tax').val());
                var discount_amount = parseFloat($('#discount_amount').val());
                if (isNaN(discount_amount)) {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax + delivery_charge)));
                    $('#grand_total').val((sub_total + tax + delivery_charge).toFixed(2));
                } else {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax + delivery_charge - discount_amount)));
                    $('#grand_total').val((sub_total + tax + delivery_charge - discount_amount).toFixed(2));
                }
            } else {
                $("#open").hide();
                $("#delivery_charge_hide").hide();
                $("#delivery").hide();
                $("#pickup").show();
                $("#delivery_date").hide();
                $("#pickup_date").show();
                var sub_total = parseFloat($('#sub_total').val());
                var delivery_charge = parseFloat($('#delivery_charge').val());
                var tax = parseFloat($('#tax').val());
                var discount_amount = parseFloat($('#discount_amount').val());
                if (isNaN(discount_amount)) {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax)));
                    $('#grand_total').val((sub_total + tax).toFixed(2));
                } else {
                    $('#total_amount').text(currency_format(parseFloat(sub_total + tax - discount_amount)));
                    $('#grand_total').val((sub_total + tax - discount_amount).toFixed(2));
                }
            }
        });

        if ("{{Helper::webinfo($getrestaurant->id)->delivery_type}}" != "both") {
            $(function() {
                $("input[name$='cart-delivery']").click();
            });
        }
    });

    $("#delivery_area").change(function() {
        var currency = parseFloat($('#currency').val());
        var deliverycharge = $('option:selected', this).attr('price');
        $('#shipping_charge').text(currency_format(deliverycharge));
        $('#delivery_charge').val(deliverycharge);
        var sub_total = parseFloat($('#sub_total').val());
        var delivery_charge = parseFloat($('#delivery_charge').val());
        var tax = parseFloat($('#tax').val());
        var discount_amount = parseFloat($('#discount_amount').val());
        if (isNaN(discount_amount)) {
            $('#total_amount').text(currency_format(parseFloat(sub_total + delivery_charge + tax)));
            $('#grand_total').val(((sub_total + delivery_charge + tax)).toFixed(2));
        } else {
            $('#total_amount').text(currency_format(parseFloat(sub_total + delivery_charge + tax - discount_amount)));
            $('#grand_total').val(((sub_total + delivery_charge + tax - discount_amount)).toFixed(2));
        }
    });

    function handlePaymentSelection(radio) {
        var paymentType = radio.getAttribute("data-payment_type");

        if (paymentType === "Mercado Pago") {
            document.getElementById("button1").style.display = "none";
            document.getElementById("button2").style.display = "block";
        } else {
            document.getElementById("button1").style.display = "block";
            document.getElementById("button2").style.display = "none";
        }
    }

    function Order() {
        var sub_total = parseFloat($('#sub_total').val());
        var tax = parseFloat($('#tax').val());
        var grand_total = parseFloat($('#grand_total').val());
        var delivery_time = $('#delivery_time').val();
        var delivery_date = $('#delivery_dt').val();
        var delivery_area = $('#delivery_area').val();
        var delivery_charge = parseFloat($('#delivery_charge').val());
        var discount_amount = parseFloat($('#discount_amount').val());
        var couponcode = $('#couponcode').val();
        var order_type = $("input:radio[name=cart-delivery]:checked").val();
        var address = $('#address').val();
        var postal_code = $('#postal_code').val();
        var building = $('#building').val();
        var landmark = $('#landmark').val();
        var notes = $('#notes').val();
        var customer_name = $('#customer_name').val();
        var customer_email = $('#customer_email').val();
        var customer_mobile = $('#customer_mobile').val();
        var restaurant = $('#restaurant').val();
        var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");
        var flutterwavekey = $('#flutterwavekey').val();
        var paystackkey = $('#paystackkey').val();
        if (order_type == "1") {
            if (delivery_time == "") {
                $('#ermsg').text($('#delivery_time_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (delivery_date == "") {
                $('#ermsg').text($('#delivery_date_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (address == "") {
                $('#ermsg').text($('#address_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (building == "") {
                $('#ermsg').text($('#no_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (landmark == "") {
                $('#ermsg').text($('#landmark_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (postal_code == "") {
                $('#ermsg').text($('#pincode_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (delivery_area == "") {
                $('#ermsg').text($('#delivery_area_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_name == "") {
                $('#ermsg').text($('#customer_name_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_email == "") {
                $('#ermsg').text($('#customer_email_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_mobile == "") {
                $('#ermsg').text($('#customer_mobile_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            }
        } else if (order_type == "2") {
            if (delivery_time == "") {
                $('#ermsg').text($('#pickup_time_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (delivery_date == "") {
                $('#ermsg').text($('#delivery_date_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_name == "") {
                $('#ermsg').text($('#customer_name_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_email == "") {
                $('#ermsg').text($('#customer_email_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            } else if (customer_mobile == "") {
                $('#ermsg').text($('#customer_mobile_required').val());
                $('#error-msg').addClass('alert-danger');
                $('#error-msg').css("display", "block");
                setTimeout(function() {
                    $("#error-msg").hide();
                }, 5000);
                return false;
            }
        }

        $('#preloader').show();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/orders/checkplan') }}",
            data: {
                restaurant: restaurant,
            },
            method: 'POST',
            success: function(response) {
                if (response.status == 1) {
                    //COD
                    if (payment_type == "COD") {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ URL::to('/orders/whatsapporder') }}",
                            data: {
                                sub_total: sub_total,
                                tax: tax,
                                grand_total: grand_total,
                                delivery_time: delivery_time,
                                delivery_date: delivery_date,
                                delivery_area: delivery_area,
                                delivery_charge: delivery_charge,
                                discount_amount: discount_amount,
                                couponcode: couponcode,
                                order_type: order_type,
                                address: address,
                                postal_code: postal_code,
                                building: building,
                                landmark: landmark,
                                notes: notes,
                                customer_name: customer_name,
                                customer_email: customer_email,
                                customer_mobile: customer_mobile,
                                restaurant: restaurant,
                                payment_type: payment_type,
                            },
                            method: 'POST',
                            success: function(response) {
                                $('#preloader').hide();
                                if (response.status == 1) {
                                    window.location.href = "{{URL::to($getrestaurant->slug)}}/success/" + response.order_number;
                                } else {
                                    $('#ermsg').text(response.message);
                                    $('#error-msg').addClass('alert-danger');
                                    $('#error-msg').css("display", "block");
                                    setTimeout(function() {
                                        $("#error-msg").hide();
                                    }, 5000);
                                }
                            },
                            error: function(error) {
                                $('#preloader').hide();
                            }
                        });
                    }
                } else {
                    $('#preloader').hide();
                    $('#ermsg').text(response.message);
                    $('#error-msg').addClass('alert-danger');
                    $('#error-msg').css("display", "block");
                    setTimeout(function() {
                        $("#error-msg").hide();
                    }, 5000);
                }
            },
            error: function(error) {
                $('#preloader').hide();
            }
        });
    }


    function ApplyCopon() {
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/cart/applypromocode') }}",
            method: 'post',
            data: {
                promocode: jQuery('#promocode').val()
            },
            success: function(response) {
                $('#preloader').hide();
                if (response.status == 1) {
                    location.reload();
                } else {
                    $('#ermsg').text(response.message);
                    $('#error-msg').addClass('alert-danger');
                    $('#error-msg').css("display", "block");
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 5000);
                }
            }
        });
    }

    function RemoveCopon() {
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/cart/removepromocode') }}",
            method: 'post',
            data: {
                promocode: jQuery('#promocode').val()
            },
            success: function(response) {
                $('#preloader').hide();
                if (response.status == 1) {
                    location.reload();
                } else {
                    $('#ermsg').text(response.message);
                    $('#error-msg').addClass('alert-danger');
                    $('#error-msg').css("display", "block");
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 5000);
                }
            }
        });
    }

    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#delivery_dt').attr('min', maxDate);
    });
</script>