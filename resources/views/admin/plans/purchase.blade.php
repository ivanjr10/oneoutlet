@extends('admin.layout.main')
@section('page_title',trans('labels.pricing_plans'))
@section('content')
<section id="content-types">
	<div class="row">
		<div class="col-12 mt-3 mb-1">
			<h4 class="content-header">{{trans('labels.pricing_plans')}}</h4>
		</div>
	</div>
	<div class="row match-height">
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="card" style="height: 473px;">
				<div class="card-body">
					<div class="card-block">
						<h4 class="card-title">{{$plans->name}}</h4>
						<p class="card-text">{{$plans->description}}</p>
					</div>
					<ul class="list-group">
						<li class="list-group-item">
							<h4 class="card-title">{{Helper::currency_format($plans->price,1)}} /
								@if($plans->plan_period == 1)
								{{trans('labels.1_month')}}
								@endif
								@if($plans->plan_period == 2)
								{{trans('labels.3_month')}}
								@endif
								@if($plans->plan_period == 3)
								{{trans('labels.6_month')}}
								@endif
								@if($plans->plan_period == 4)
								{{trans('labels.1_year')}}
								@endif
							</h4>
						</li>
						<li class="list-group-item"><i class="ft-check"></i> {{$plans->item_unit}} {{trans('labels.item_limit')}}</li>
						<li class="list-group-item"><i class="ft-check"></i> {{$plans->order_limit}} {{trans('labels.order_limit')}}</li>
						@if($plans->custom_domain == 1)
						<li class="list-group-item"><i class="ft-check"></i>
							{{trans('labels.custom_domain')}}
						</li>
						@endif
						<?php
						$myString = $plans->features;
						$myArray = explode(',', $myString);
						?>
						@foreach($myArray as $features)
						<li class="list-group-item"><i class="ft-check"></i> {{$features}}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="card">
				<div class="card-body">
					<div class="card-block">
						<h4 class="card-title">{{trans('labels.select_payment')}}</h4>
					</div>
					@foreach ($paymentlist as $key => $payment)
					<div class="list-group-item">
						<!-- Radio -->
						<div class="custom-control custom-radio">
							<!-- Input -->
							<input class="custom-control-input" id="{{$payment->payment_name}}" data-payment_type="{{$payment->id}}" name="payment" type="radio" @if (!$key) {!! "checked" !!} @endif>
							<!-- Label -->
							<label class="custom-control-label font-size-sm text-body text-nowrap" for="{{$payment->payment_name}}">
								@if($payment->payment_name == "Mercado Pago")
								<img src="{{asset('storage/app/public/payment/mercado-pago.png')}}" class="ml-2" alt="" width="30px" />
								<input type="hidden" name="mercado-pago" id="mercado-pago" value="{{$payment->public_key}}">
								@endif
								@if($payment->payment_name == "PIX / Transferência Bancária")
								<img src="{{asset('storage/app/public/payment/bank.png')}}" class="ml-2" alt="" width="30px" />
								@endif
								{{$payment->payment_name}}
							</label>
						</div>
					</div>
					@endforeach
				</div>
				<div class="card-block">
					@if (env('Environment') == 'sendbox')
					<button onclick="myFunction()" class="btn btn-raised btn-success btn-min-width mr-1 mb-1">{{trans('labels.buy_now')}}</button>
					@else
					<button onclick="Paynow()" class="btn btn-raised btn-success btn-min-width mr-1 mb-1">{{trans('labels.buy_now')}}</button>
					@endif
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="plan" id="plan" value="{{$plans->name}}">
	<input type="hidden" name="amount" id="amount" value="{{$plans->price}}">
	<input type="hidden" name="plan_period" id="plan_period" value="{{$plans->plan_period}}">
	<input type="hidden" name="email" id="email" value="{{Helper::getrestaurant(Auth::user()->slug)->email}}">
	<input type="hidden" name="mobile" id="mobile" value="{{Helper::getrestaurant(Auth::user()->slug)->mobile}}">
	<input type="hidden" name="name" id="name" value="{{Helper::getrestaurant(Auth::user()->slug)->name}}">
</section>
@endsection
<!-- Bank info -->
<div class="modal fade" id="transaction_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.bank_transfer') }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="form" enctype="multipart/form-data" action="{{ URL::to('/vendor/plans/order')}}" method="POST">
				@csrf
				<input type="hidden" name="payment_type" id="payment_type" class="form-control" value="">
				<input type="hidden" name="plan" id="plan_bank" class="form-control" value="">
				<input type="hidden" name="amount" id="amount_bank" class="form-control" value="">
				<input type="hidden" name="plan_period" id="plan_period_bank" class="form-control" value="">
				<div class="modal-body">
					<p>Bank name : {{$bankdetails->bank_name}}</p>
					<p>Account holder name : {{$bankdetails->account_holder_name}}</p>
					<p>Account number : {{$bankdetails->account_number}}</p>
					<p>IFSC : {{$bankdetails->ifsc}}</p>
					<hr>
					<div class="form-group col-md-12">
						<label for="screenshot"> Transaction image </label>
						<div class="controls">
							<input type="file" name="screenshot" id="screenshot" class="form-control  @error('screenshot') is-invalid @enderror" required>
							@error('screenshot') <span class="text-danger"> {{$message}} </span> @enderror
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">{{trans('labels.close')}}</button>
					@if (env('Environment') == 'sendbox')
					<button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"> <i class="fa fa-edit"></i> {{trans('labels.update')}} </button>
					@else
					<input type="submit" class="btn btn-raised btn-primary" value="{{trans('labels.submit')}}">
					@endif
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Checkout Mercado Pago -->
<div class="modal fade" id="checkout-mercado-pago" tabindex="-1" aria-labelledby="mercadoPagoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mercadoPagoModalLabel">Checkout Mercado Pago</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div id="cardPaymentBrick_container">
			</div>
			<div id="cardMsg"></div>
		</div>
	</div>
</div>

@section('scripts')
<script src="{{asset('resources/views/admin/plans/plans.js')}}" type="text/javascript"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script type="text/javascript">
	function Paynow() {
		"use strict";
		var payment_type = $('input[name="payment"]:checked').attr("data-payment_type");
		var plan = $('#plan').val();
		var amount = $('#amount').val();
		var plan_period = $('#plan_period').val();

		//Mercado Pago
		if (payment_type == 3) {
			$('#checkout-mercado-pago').modal('show');
			const mp = new MercadoPago($('#mercado-pago').val(), {
				locale: 'pt'
			});
			const bricksBuilder = mp.bricks();
			const renderCardPaymentBrick = async (bricksBuilder) => {
				const settings = {
					initialization: {
						amount: amount, // valor total a ser pago
						payer: {
							email: "",
						},
					},
					customization: {
						visual: {
							style: {
								theme: 'bootstrap'
							}
						},
						paymentMethods: {
							minInstallments: 1,
							maxInstallments: 1
						},
					},
					callbacks: {
						onReady: () => {
							console.log("Bricks iniciado");
						},
						onSubmit: (cardFormData) => {
							return new Promise((resolve, reject) => {
								fetch("{{ URL::to('/vendor/plans/order')}}", {
										method: "POST",
										headers: {
											"Content-Type": "application/json",
											"X-CSRF-TOKEN": @json(csrf_token())
										},
										body: JSON.stringify({
											...cardFormData,
											"plan": plan,
											"payment_type": payment_type,
											"amount": amount,
											"plan_period": plan_period
										})
									})
									.then((response) => {
										if (response.status == 200) {
											$("#cardMsg").html('<div class="alert alert-success">Pagamento realizado com sucesso! Redirecionando em <span id="contador">5</span> segundos...</div>');

											// Redirecionamento após 5 segundos
											var contador = 5;
											var contadorInterval = setInterval(function() {
												contador--;
												$("#contador").text(contador);

												if (contador == 0) {
													clearInterval(contadorInterval);
													//window.location.href = "{{ URL::to('/vendor/plans')}}";
												}
											}, 1000);

											resolve();
										} else {
											$("#cardMsg").html('<div class="alert alert-danger">Erro ao processar o pagamento: ' + response.message + '. Tente de novo em alguns minutos. Redirecionando em <span id="contador">5</span> segundos...</div>');

											// Redirecionamento após 5 segundos
											var contador = 5;
											var contadorInterval = setInterval(function() {
												contador--;
												$("#contador").text(contador);

												if (contador == 0) {
													clearInterval(contadorInterval);
													//window.location.href = "{{ URL::to('/vendor/plans')}}";
												}
											}, 1000);
										}
									})
									.catch((error) => {
										console.log("Transação recusada");
										console.log(response);
										reject();
									})
							});
						},
						onError: (error) => {
							console.log("Erro ao iniciar o Bricks");
						},
					},
				};
				window.cardPaymentBrickController = await bricksBuilder.create('cardPayment', 'cardPaymentBrick_container', settings);
			};
			renderCardPaymentBrick(bricksBuilder);
		}
		//PIX / Transferência Bancária
		if (payment_type == 2) {
			$('#transaction_details').modal('show');
			$('#payment_type').val(payment_type);
			$('#plan_bank').val(plan);
			$('#amount_bank').val(amount);
			$('#plan_period_bank').val(plan_period);
		}
	}
</script>
@endsection