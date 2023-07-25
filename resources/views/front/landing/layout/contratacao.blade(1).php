
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Oneoutlet.site, onde qualquer pessoa pode realizar marketing de forma fácil e simples através do whatsapp. Apresse-se e comece a comercializar. Função de bot automatizada, conversa rápida com os clientes. Brasil">
	<title>{{ Helper::admininfo()->website_title }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{ asset('storage/app/public/landing/img/nav-logo.png') }}" type="image/x-icon">
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/lineicons.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/tiny-slider.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/first.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/first_custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/glightbox.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/owlcarousel/assets/owl.carousel.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/owlcarousel/assets/owl.theme.default.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('storage/app/public/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
	<script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/plugin.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/front/js/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/wow.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/tiny-slider.js') }}"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/count-up.min.js') }}"></script>
	<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{ asset('storage/app/public/landing/js/first.js') }}"></script>
</head>

<body>

<script src="https://sdk.mercadopago.com/js/v2"></script>


@php
	use Illuminate\Support\Facades\Auth;
	//dd(Auth::user());
@endphp

<div class="preloader">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>
	
<header>
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<div class="nav-inner">
					<nav class="navbar navbar-expand-lg wow zoomIn header_time" data-wow-delay=".2s">
						<a class="navbar-brand" href="#">
							<img src="{{ asset('storage/app/public/landing/img/nav-logo.png') }}" style="width:130px" alt="logo">
						</a>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>

<section>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title" style="margin-bottom:0px">
					<br>
					<h3 class="wow zoomIn pricing_sub_title" data-wow-delay=".2s">Contratação de Assinatura</h3>
				</div>
			</div>
		</div>
		
	</div>

</section>

<section class="contact section" id="contact" style="
 padding-top: 30px; 
  padding-left: 200px;
  padding-right: 200px">


		<div class="row">
			<div class="col-lg-5 d-flex align-items-stretch">
				<div class="info wow zoomIn contact_info" data-wow-delay=".8s">

					<div class="address">
						<i class="bi bi-person"></i>
						<h4>Cliente</h4>
						<p> {{ Auth::user()->name }} <br>
							{{ Auth::user()->email }} <br>
							{{ Auth::user()->country_code }} {{ Auth::user()->mobile }}</p>
					</div>

					@if($id == 1)
						<div class="address">
							<i class="bi bi-box"></i>
							<h4>Plano Gatis</h4>
							<p>Chatbot, Envio de mensagens em massa, Gerenciador de atraso, Envio de imagens e vídeos.</p>
						</div>
						<div class="email">
							<i class="bi bi-cash-stack"></i>
							<h4>Valor</h4>
							<p>0,00 /mês</p>
						</div>
					@endif

                    @if($id == 0)
						@if(session()->get('assinatura') == 'menudigital')
							@php
								$valor_cupom = session()->get('valor_cupom');
								$cupom = session()->get('cupom');
							@endphp

							<div class="address">
								<i class="bi bi-box"></i>
								<h4>{{ $plans[0]->name }}</h4>
								<p>{{ $plans[0]->description }}</p>
							</div>
							<div class="email">
								<i class="bi bi-cash-stack"></i>
								<h4>Valor</h4>
								<p>R$ {{ $plans[0]->price }} / mês</p>
							</div>

						@endif

					@endif
					
					@if($id == 2)
						<div class="address">
							<i class="bi bi-box"></i>
							<h4>Plano Plus</h4>
							<p>Chatbot, Envio de mensagens em massa, Gerenciador de atraso, Envio de imagens e vídeos.</p>
						</div>
						<div class="email">
							<i class="bi bi-cash-stack"></i>
							<h4>Valor</h4>
							<p>R$ 89,00 / mês</p>
						</div>
					@endif

					@if($id == 3)
						<div class="address">
							<i class="bi bi-box"></i>
							<h4>Plano Premium</h4>
							<p>Chatbot, Envio de mensagens em massa, Gerenciador de atraso, Envio de imagens e vídeos, Sistema para Gerenciar seu Delivery, Cardápio digital com sistema de pagamento, link para compartilhar nas redes sociais, Sistema para impressão de pedidos, Extrator de contatos do Google Maps, Suporte, Atualizações vitalícias</p>
						</div>
						<div class="email">
							<i class="bi bi-cash-stack"></i>
							<h4>Valor</h4>
							<p>R$ 130,00 / mês</p>
						</div>
					@endif
				</div>
			</div>

			<div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch wow fadeInDown contact_form" data-wow-delay=".8s">
				<style>
					.contact iframe {
						height: 40px;
					}
				</style>
				<form id="form-checkout" class="php-email-form" method="POST" action="{{ route('front.process_payment') }}">
						@csrf
						@php
							if($id==0){
						 		$valor = $plans[0]->price; 
							}elseif($id==2){
						 		$valor = 89; 
							}elseif($id==3){ 
								$valor = 130; 
							}else{
								$valor = 0;
							}
						@endphp
						<input type="hidden" id="plano_id" name="plano_id" value="{{ $id }}">
						<input type="hidden" id="amount" value="{{ $valor }}" />

						@if($id != 1)
							
							<div class="row">
								<div class="form-group col-md-12">
									<label for="name">Número do Cartão:</label>
									<div id="form-checkout__cardNumber" class="form-control" style="height: 53px; display: inline-block;"></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="name">MM/YY</label>
									<div id="form-checkout__expirationDate" class="form-control" style="height: 53px; display: inline-block;"></div>
								</div>
								<div class="form-group col-md-6">
									<label for="name">Código de Segurança:</label>
									<div id="form-checkout__securityCode" class="form-control"  style="height: 53px; display: inline-block;"></div>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-6">
									<label for="name">Bandeira</label>
									<select class="form-control" id="form-checkout__issuer"></select>
								</div>
								<div class="form-group col-md-6">
									<label for="name">Mensalidade de:</label>
									<select class="form-control" id="form-checkout__installments" disabled></select>
									@if($id == 0)
										<input type="text" class="form-control" id="mensalidade" value="R$ {{ $valor }}" readonly/>
									@endif
									@if($id == 2)
										<input type="text" class="form-control" id="mensalidade" value="R$ 89,00" readonly/>
									@endif
									@if($id == 3)
										<input type="text" class="form-control" id="mensalidade" value="R$ 130,00" readonly/>
									@endif
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-12">
									<label for="name">Titular do Cartão:</label>
									<input type="text" class="form-control" id="form-checkout__cardholderName" />
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-6">
									<label for="name">Documento</label>
									<select class="form-control"  id="form-checkout__identificationType"></select>
								</div>
								<div class="form-group col-md-6">
									<label for="name">Nº do Documento:</label>
									<input class="form-control"  type="text" id="form-checkout__identificationNumber" />
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-12">
									<label for="name">E-mail:</label>
									<input class="form-control"  type="email" id="form-checkout__cardholderEmail" />
								</div>
							</div>

						@endif

						<div class="text-center"><button type="submit" id="form-checkout__submit">Assinar</button>
						<progress value="0" class="progress-bar">Carregando...</progress>
					</div>
				</form>

			</div>
		</div>

		
</section>

@include('front.landing.layout.footer')

<script>
	
	const mp = new MercadoPago("TEST-d57b5ef0-eed5-4011-91fd-ab1c68e85b4e");

	const cardForm = mp.cardForm({
		amount: document.querySelector('#amount').value,
		iframe: true,
		form: {
			id: "form-checkout",
			cardNumber: {
			id: "form-checkout__cardNumber",
			placeholder: "Número do cartão",
			},
			expirationDate: {
			id: "form-checkout__expirationDate",
			placeholder: "MM/YY",
			},
			securityCode: {
			id: "form-checkout__securityCode",
			placeholder: "Código de segurança",
			},
			cardholderName: {
			id: "form-checkout__cardholderName",
			placeholder: "Titular do cartão",
			},
			issuer: {
			id: "form-checkout__issuer",
			placeholder: "Banco emissor",
			},
			installments: {
			id: "form-checkout__installments",
			placeholder: "Mensalidade",
			},        
			identificationType: {
			id: "form-checkout__identificationType",
			placeholder: "Tipo de documento",
			},
			identificationNumber: {
			id: "form-checkout__identificationNumber",
			placeholder: "Número do documento",
			},
			cardholderEmail: {
			id: "form-checkout__cardholderEmail",
			placeholder: "E-mail",
			},
		},
		callbacks: {
			onFormMounted: error => {
			if (error) return console.warn("Form Mounted handling error: ", error);
			console.log("Form mounted");
			const installmentsField = document.querySelector('#form-checkout__installments');
  			installmentsField.style.display = 'none';
			},
			onSubmit: event => {
			event.preventDefault();
			
			var plano_id = document.querySelector('#plano_id').value;

			const {
				paymentMethodId: payment_method_id,
				issuerId: issuer_id,
				cardholderEmail: email,
				amount,
				token,
				installments,
				identificationNumber,
				identificationType,
			} = cardForm.getCardFormData();

			fetch("{{ route('front.process_payment') }}", {
				method: "POST",
				headers: {
				"Content-Type": "application/json",
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				},
				body: JSON.stringify({
				token,
				plano_id : plano_id,
				issuer_id,
				payment_method_id,
				transaction_amount: Number(amount),
				installments: Number(installments),
				description: "Descrição do produto",
				payer: {
					email,
					identification: {
					type: identificationType,
					number: identificationNumber,
					},
				},
				}),
			});
			},
			onFetching: (resource) => {
			console.log("Fetching resource: ", resource);

			// Animate progress bar
			const progressBar = document.querySelector(".progress-bar");
			progressBar.removeAttribute("value");

			return () => {
				progressBar.setAttribute("value", "0");
			};
			}
		},
	});

</script>
</body>