@extends('user.main')

@section('header')

@include('user.main_resourse')

@endsection('header')

@section('page_title',trans('labels.user'))

@section('content')

<?php

use Omnipay\Omnipay;

class Payment124
{
	public function gateway($a, $b)
	{
		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername($a);
		$gateway->setPassword($b);
		$gateway->setSignature("EOEwezsNWMWQM63xxxxxknr8QLoAOoC6lD_-kFqjgKxxxxxwGWIvsJO6vP3syd10xspKbx7LgurYNt9");
		//$gateway->setTestMod(false);
		return $gateway;
	}

	public function purchase(array $parameters)
	{
		$response = $this->gateway()->purchase($parameters)->send();

		return $response;
	}

	public function complete(array $parameters)
	{
		$response = $this->gateway()->completePurchase($parameters)->send();
		return $response;
	}

	public function formatAmount($amount)
	{
		return number_format($amount, 2, '.', '');
	}

	public function getCancelUrl($order = "")
	{
		return $this->route("http://Oneoutlet.site/", $order);
	}

	public function getReturnUrl($order = "")
	{
		return $this->route('http://Oneoutlet.site/src/License', $order);
	}

	public function route($name, $params)
	{
		return $name;
	}
}
ob_start();
session_start();

$payment = new Payment124;
$payment->gateway($user->user_id, $user->name);
?>

@include('user.layout.header')

<section>
	<div class="user_header section">
		<!-- <h3 class="user_header_title">
			Para gerenciar seu Delivery, atualizar ou criar seu Menu digital acesse o Painel de Administração.
		</h3> -->
	</div>
</section>

<section id="pricing" class="pricing-table section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h3 class="wow zoomIn pricing_sub_title" data-wow-delay=".2s">preços</h3>
					<h2 class="wow fadeInUp pricing_title" data-wow-delay=".4s">Planos de Assinatura</h2>
					<p class="wow fadeInUp pricing_desc" data-wow-delay=".6s">Se você ainda não é Assinante, assine já e aproveite todos os recursos para melhorar o atendimento e aumentar suas vendas no WhatsApp.</p>
				</div>
			</div>
		</div>

		@if(session()->get('assinatura') != 'menudigital')
		<div class="row">
			<div class="col-lg-4 col-md-6 col-12 wow fadeInUp pricing_content_1" data-wow-delay=".4s">
				<div class="single-table">
					<span class="popular warning">
						@if ($user->is_free == 1)
						{{trans('labels.free_days')}}
						@else
						{{trans('labels.already_purchase_plan')}}
						@endif
					</span>
					<div class="table-head">
						<h4 class="title">GRÁTIS</h4>
						<p class="sub-title">Poderoso &amp; Elementos impressionantes</p>
						<div class="price">
							<h2 class="amount">
								<span class="currency">R$</span>0
								<span class="duration">/mês</span>
							</h2>
						</div>
					</div>
					<div class="table-content">
						<ul class="table-list">
							<li>Chatbot</li>
							<li>Envio de mensagens em massa</li>
							<li>Gerenciador de atraso</li>
							<li>Envio de imagens e vídeos</li>
							<li class="disable">Sistema para Gerenciar seu Delivery</li>
							<li class="disable">Cardápio digital com sistema de pagamento</li>
							<li class="disable">link para compartilhar nas redes sociais</li>
							<li class="disable">Sistema para impressão de pedidos</li>
							<li class="disable">Extrator de contatos do Google Maps</li>
							<li class="disable">Suporte</li>
							<li class="disable">Atualizações vitalícias</li>
						</ul>
					</div>

					@if ($user->is_free != 1)
					<div class="button">
						<a href="#" class="btn disabled">Iniciar Teste Gratuito<i class="lni lni-arrow-right"></i></a>
					</div>
					@else
					<div class="button" id="btn_free">
						<a href="#" class="btn">Iniciar Teste Gratuito<i class="lni lni-arrow-right"></i></a>
					</div>
					@endif

					<!-- <p class="no-card">Versão gratuita</p> -->
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-12 wow fadeInRight pricing_content_2" data-wow-delay=".6s">
				<div class="single-table middle">
					<span class="popular warning">
						@if ($user->is_plus == 2)
						{{trans('labels.already_purchase_plan')}}
						@endif
					</span>
					<div class="table-head">
						<h4 class="title">PLANO PLUS</h4>
						<p class="sub-title">Poderoso &amp; Elementos impressionantes</p>
						<div class="price">
							<h2 class="amount">
								<span class="currency">R $</span>89.00
								<span class="duration">/mês</span>
							</h2>
						</div>
					</div>
					<div class="table-content">
						<ul class="table-list">
							<li>Chatbot</li>
							<li>Envio de mensagens em massa</li>
							<li>Gerenciador de atraso</li>
							<li>Envio de imagens e vídeos</li>
							<li class="disable">Sistema para Gerenciar seu Delivery</li>
							<li class="disable">Cardápio digital com sistema de pagamento</li>
							<li class="disable">link para compartilhar nas redes sociais</li>
							<li class="disable">Sistema para impressão de pedidos</li>
							<li class="disable">Extrator de contatos do Google Maps</li>
							<li class="disable">Suporte</li>
							<li class="disable">Atualizações vitalícias</li>
						</ul>
					</div>

					@if ($user->is_plus == 1)
					<div class="button">
						<a href="{{ route('front.contratacao', '') }}/2" target="_top" class="btn">Assine agora<i class="lni lni-arrow-right"></i></a>
						<!--<a href="#" target="_top" class="btn" onclick="alertaPlano()">Assine agora<i class="lni lni-arrow-right"></i></a>-->
					</div>
					@else
					<div class="button">
						<a href="{{ route('front.contratacao', '') }}/2" target="_top" class="btn disabled">Assine agora<i class="lni lni-arrow-right"></i></a>
						<!--<a href="#" target="_top" class="btn disabled" onclick="alertaPlano()">Assine agora<i class="lni lni-arrow-right"></i></a>-->
					</div>
					@endif
					<!-- <p class="no-card">Não é necessário cartão de crédito</p> -->
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-12 wow zoomIn pricing_content_3" data-wow-delay=".8s">
				<div class="single-table">
					<span class="popular">
						@if ($user->is_premium == 1)
						{{trans('labels.most_popular')}}
						@else
						{{trans('labels.already_purchase_plan')}}
						@endif
					</span>
					<div class="table-head">
						<h4 class="title">PLANO PREMIUM</h4>
						<p class="sub-title">Poderoso &amp; Elementos impressionantes</p>
						<div class="price">
							<h2 class="amount">
								<span class="currency">R $</span>130,00
								<span class="duration">/mês</span>
							</h2>
						</div>
					</div>
					<div class="table-content">
						<ul class="table-list">
							<li>Chatbot</li>
							<li>Envio de mensagens em massa</li>
							<li>Gerenciador de atraso</li>
							<li>Envio de imagens e vídeos</li>
							<li>Sistema para Gerenciar seu Delivery</li>
							<li>Cardápio digital com sistema de pagamento</li>
							<li>link para compartilhar nas redes sociais</li>
							<li>Sistema para impressão de pedidos</li>
							<li>Extrator de contatos do Google Maps</li>
							<li>Suporte</li>
							<li>Atualizações vitalícias</li>
						</ul>
					</div>

					@if ($user->is_premium == 1)
					<div class="button">
						<a href="{{ route('front.contratacao', '') }}/3" target="_top" class="btn" id="btn_premium">Assine agora<i class="lni lni-arrow-right"></i></a>
						<!--<a href="#" target="_top" class="btn" id="btn_premium" onclick="alertaPlano()">Assine agora<i class="lni lni-arrow-right"></i></a>-->
					</div>
					@else
					<div class="button">
						<a href="{{ route('front.contratacao', '') }}/3" target="_top" class="btn disabled">Assine agora<i class="lni lni-arrow-right"></i></a>
						<!--<a href="#" target="_top" class="btn disabled" onclick="alertaPlano()">Assine agora<i class="lni lni-arrow-right"></i></a>-->
					</div>
					@endif

				</div>

				@if ($user->is_coupon == 2 && $user->is_premium == 1)
				<div class="input-group couponcode">
					<label class="input-group-text"><i class="lni lni-tag"></i></label>
					<input class="form-control" type="couponcode" name="couponcode" id="couponcode" placeholder="{{trans('labels.input_couponcode')}}">
				</div>
				@endif

			</div>

		</div>
		@endif
		@if(session()->get('assinatura') == 'menudigital')
		@php
		$valor_cupom = session()->get('valor_cupom');
		$cupom = session()->get('cupom');
		@endphp
		@if(isset($plans))
		@foreach ($plans as $plan)
		<div class="row" style="display: flex;
						justify-content: center;
						align-items: center;">
			<div class="col-lg-4 col-md-6 col-12 wow zoomIn pricing_content_3" data-wow-delay=".8s">
				<div class="single-table middle" style="margin: 0 auto;">
					<div class="table-head">
						<h4 class="title">{{ $plan->name }}</h4>
						<p class="sub-title">{{ $plan->description }}</p>
						<div class="price" align="center">

							@if($valor_cupom == 0)

							<span class="currency">{{ Helper::currency_format($plan->price, 1) }}</span>
							<span class="duration">/mês</span>
							</h2>
							@else
							<span class="currency"><strike>{{ Helper::currency_format($plan->price, 1) }}</strike></span>
							<span class="duration">/mês</span>
							<br>
							<h2>
								<span class="currency"></span>R$ {{ $valor_cupom }}
								<span class="duration">/mês</span>
							</h2>
							<br>
							<h4 class="title">Cupom utilizado: {{ $cupom }}</h4>
							<br><br>
							@endif


						</div>
					</div>
					<div class="table-content">
						<ul>
							<li><i class="lni lni-checkmark active"></i>
								@if ($plan->item_unit == -1)
								{{ trans('labels.item_unlimited') }}
								@else
								{{ $plan->item_unit }} {{ trans('labels.item_limit') }}
								@endif
							</li>
							<li><i class="lni lni-checkmark active"></i>
								@if ($plan->item_unit == -1)
								{{ trans('labels.order_unlimited') }}
								@else
								{{ $plan->order_limit }} {{ trans('labels.order_limit') }}
								@endif
							</li>
							<?php
							$myString = $plan->features;
							$myArray = explode(',', $myString);
							?>
							@foreach ($myArray as $features)
							<li><i class="lni lni-checkmark active"></i> {{ $features }}</li>
							@endforeach
						</ul>
					</div>


					<div class="button">
						<a href="{{ route('front.contratacao', '') }}/0" target="_top" class="btn">Assine agora<i class="lni lni-arrow-right"></i></a>
					</div>

				</div>

			</div>
		</div>
		@endforeach
		@endif
		@endif
	</div>
</section>

@include('front.landing.layout.download')

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('resources/views/user/main.js') }}"></script>
<script src="{{asset('resources/views/user/landing/landing.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('resources/views/user/landing/landing.css')}}">
<script>
	function alertaPlano() {
		alert("Plano indisponível");
	}
</script>
@endsection