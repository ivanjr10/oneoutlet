<!DOCTYPE html>
<html class="no-js" lang="pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ Helper::admininfo()->website_title }}</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="{{ asset('storage/app/public/landing/img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/app/public/landing/css/landing.css') }}">
</head>

<body>
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="header">
        <div class="navbar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{ route('front.landing.index') }}">
                                <img id="menu_digital_logo" src="{{ Helper::image_path($settingdata->logo) }}" alt="Logo" />
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}">Iniciar sessão</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('admin.auth.register')}}">Abrir conta</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center position-relative">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="wow fadeInUp" data-wow-delay=".4s">
                            Nunca foi tão simples receber Pedidos pelo WhatsApp!
                        </h1>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Aproveite o WhatsApp como plataforma para aceitar pedidos. Crie um menu digital para o seu Restaurante, Pizzaria, Lanchonete, Depósito de Gás... <br>Compartilhe seu catálogo de produtos com seus clientes e receba pedidos sem precisar anotar!
                        </p>
                        <a href="#parceiros" class="scroll-bottom">
                            <i class="lni lni-arrow-down"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-img wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('storage/app/public/landing/img/hero-img.png') }}" alt="" class="w-100" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="parceiros" class="pricing-section store-partners pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-9">
                    <div class="section-title text-center mb-35">
                        <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                            Novos Parceiros
                        </h2>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="row">
                    @foreach($users as $user)
                    <div class="col-sm-6 col-md-4 col-lg-3 text-center mb-3">
                        <div class="partner">
                            <div class="icon">
                                <a href="{{ URL::to($user->slug)}}" class="mb-2">
                                    @if(isset(Helper::webinfo(@$user->id)->image)) <img src="{{Helper::webinfo(@$user->id)->image}}" height="100" alt="{{$user->name}}" srcset=""> @endif
                                </a>
                            </div>
                        </div>
                        <strong><a href="{{ URL::to($user->slug)}}" target="_blank">{{$user->name}}</a></strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="feature-section pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-mobile"></i>
                        </div>
                        <div class="content">
                            <h3>Crie seu Menu Digital</h3>
                            <p>
                                Crie seu menu diretamente em nossa plataforma. Atualize a qualquer momento. Simples e Fácil.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-support"></i>
                        </div>
                        <div class="content">
                            <h3>Pedidos via WhatsApp </h3>
                            <p>
                                Você receberá o pedido no seu WhatsApp.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-wallet"></i>
                        </div>
                        <div class="content">
                            <h3>Sistema de pagamento</h3>
                            <p>
                                Aceite dinheiro na entrega ou receba o pagamento através do nosso sistema, direto na sua conta Sem Comissão.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h3>Comece a receber pedidos </h3>
                            <p>
                                Basta criar o seu menu, e então é só esperar receber pedidos no seu celular via WhatsApp.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-bar-chart"></i>
                        </div>
                        <div class="content">
                            <h3>Analises diariamente</h3>
                            <p>
                                Obtenha um relatório detalhado sobre seus pedidos e ganhos. Acompanhe o seu negócio à medida que ele cresce com a nossa ferramenta.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-users"></i>
                        </div>
                        <div class="content">
                            <h3>Fidelize</h3>
                            <p>
                                Com nosso Menu digital, você está criando um vínculo direto com seus clientes. Cliente fiel, saberá onde te encontrar da próxima vez.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about-section pt-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="about-img">
                        <img class="w-45" src="{{ asset('storage/app/public/landing/img/side-bar.png') }}" alt="" class="shape shape-1">
                        <img src="{{ asset('storage/app/public/landing/img/about-left-shape.svg') }}" alt="" class="shape shape-1" />
                        <img src="{{ asset('storage/app/public/landing/img/left-dots.svg') }}" alt="" class="shape shape-2" />
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="about-content">
                        <div class="section-title mb-30">
                            <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                                Para Pedidos de Clientes
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                O cliente pode encontrar o link para o menu do seu negócio nas redes sociais, no boca a boca feito por um amigo, ou mesmo, escaneando o QRcode. Depois de fazer o pedido através do Menu digital, ele pode enviar o pedido diretamente para o WhatsApp do seu estabelecimento.
                            </p>
                            <h2 class="mt-3 mb-25 wow fadeInUp" data-wow-delay=".2s">
                                Para Donos e Gerentes de Loja
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                O processo começa quando sua loja recebe uma nova mensagem no WhatsApp. O atendente, ou um robô customizado, precisa apenas encaminhar o link do Menu digital. A sua loja economiza tempo e não precisa mais anotar pedidos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing-section pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-9">
                    <div class="section-title text-center mb-35">
                        <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                            Plano de Assinatura
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Assine pelo Mercado Pago e cancele quando quiser.
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="row justify-content-center">
                    @foreach ($plans as $plan)
                    @if ($plan->is_deleted == 1)
                    @continue
                    @endif
                    <div class="col-lg-4 col-md-8 col-sm-10">
                        <div class="single-pricing">
                            <div class="pricing-header">
                                <h1 class="price">{{ Helper::currency_format($plan->price, 1) }}</h1>
                                <h3 class="package-name">{{ $plan->name }}</h3>
                                <p>{{ $plan->description }}</p>
                            </div>
                            <div class="content">
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

                            <div class="pricing-btn">
                                @switch($plan->name)
                                @case('Plano Essencial')
                                <button type="submit" class="main-btn btn-hover border-btn" data-toggle="modal" data-target="#myModal">
                                    Assinar Agora
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Mensagem</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Plano indisponível no momento, tente mais tarde!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break

                                @case('Plano Vip')
                                <a href="{{ route('admin.auth.register') }}">
                                    <button type="submit" class="main-btn btn-hover border-btn">Testar Agora</button>
                                </a>
                                @break

                                @default
                                <a href="{{ route('admin.auth.register') }}">
                                    <button type="submit" class="main-btn btn-hover border-btn">Assinar Agora</button>
                                </a>
                                @endswitch
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="widget-wrapper">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-6">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="footer-widget">
                            <div class="logo mb-30">
                                <h1 class="text-white">Nunca foi tão Simples receber Pedidos pelo WhatsApp!</h1>
                            </div>
                            <ul class="socials text-white">
                                {{ Helper::admininfo()->copyright }}
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6">
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>


    <script type="text/javascript" src="{{ asset('storage/app/public/assets/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('storage/app/public/landing/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('storage/app/public/landing/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('storage/app/public/landing/js/wow.min.js') }}"></script>
    <script src="{{ asset('storage/app/public/landing/js/main.js') }}"></script>
</body>

</html>