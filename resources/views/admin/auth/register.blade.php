@extends('user.main')

@section('header')

@include('user.main_resourse')

@endsection('header')

@section('content')

<div class="preloader">
	<div class="preloader-inner">
		<div class="preloader-icon">
			<span></span>
			<span></span>
		</div>
	</div>
</div>

<div class="breadcrumbs">
	<div class="container wow zoomIn" data-wow-delay=".2s">
		<div class="row align-items-center">
			<div class="col-lg-6 offset-lg-3 col-md-12 col-12">
				<div class="breadcrumbs-content">
					<h1 class="page-title">Crie sua Conta</h1>
					<ul class="breadcrumb-nav">
						<li><a href="/">Home</a></li>
						<li>Crie sua Conta</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="account-login section">
	<div class="container wow fadeInUp" data-wow-delay=".4s">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
				<form class="card login-form inner-content" action="{{ route('admin.create') }}" id="form_register" method="post">
					@csrf
					<div class="card-body">
						<div class="title">
							<h3>Crie sua Conta Agora</h3>
							<p>Preencha todos os campos abaixo para criar sua conta.</p>
						</div>
						
						@error('erro_mercado')
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						
						<div class="input-head">
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-user"></i></label>
										<input class="form-control" type="text" name="name" id="name" placeholder="{{trans('labels.name')}}" value="{{old('name')}}" required>
									</div>
									@error('name')<span class="text-danger">{{ $message }}</span>@enderror
								</div>

								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
											<label><i class="lni lni-envelope"></i></label>
											<input type="text" class="form-control" name="email" id="email" placeholder="{{trans('labels.email')}}" required value="{{old('email')}}">
									</div>
									@error('email')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
							</div>


							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-empty-file"></i></label>
										<select class="form-control" name="tipo_documento" id="tipo_documento" required>
											<option value="CPF">CPF</option>
											<option value="CNPJ">CNPJ</option>
										</select>
									</div>
									@error('name')<span class="text-danger">{{ $message }}</span>@enderror
								</div>

								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
											<label><i class="lni lni-keyboard"></i></label>
											<input type="text" class="form-control" name="documento" id="documento" placeholder="Documento" required value="{{old('documento')}}">
									</div>
									@error('email')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-mobile"></i>+55</label>
										<input type="text" class="form-control phone_code_after" name="phone" id="phone" placeholder="(13)99999-9999" required value="{{old('phone')}}">
									</div>
									@error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
											<label><i class="lni lni-comments-reply"></i></label>
											<input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" required value="{{old('cep')}}">
									</div>
									@error('email')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-text-align-center"></i></label>
										<input class="form-control" type="text" name="endereco" id="endereco" placeholder="Endereço" value="{{old('endereco')}}" required>
									</div>
									@error('name')<span class="text-danger">{{ $message }}</span>@enderror
								</div>

								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
											<label><i class="lni lni-direction"></i></label>
											<input type="text" class="form-control" name="numero" id="numero" placeholder="Número" required value="{{old('numero')}}">
									</div>
									@error('email')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-lock-alt"></i></label>
										<input type="password" class="form-control" name="password" id="password" placeholder="{{trans('labels.password')}}" required>
									</div>
									@error('password')<span class="text-danger">{{ $message }}</span>@enderror
								</div>
								<div class="col-lg-6 col-12">
									<div class="form-group input-group">
										<label><i class="lni lni-lock-alt"></i></label>
										<input class="form-control" name="confirm_password" id="confirm_password" type="password" placeholder="Confirme sua senha" required>
									</div>
								</div>
							</div>
						</div>

						<div class="button">
							<button class="btn" type="submit" id="btn_register">Criar Conta</button>
						</div>
						<h4 class="create-account">Já possui conta?<a href="{{ URL::to('/admin/') }}">Acesse</a>
						</h4>
						</div>
						<input type="hidden" class="form-control" name="mobile" id="mobile" required>
				</form>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="{{asset('resources/views/admin/auth/auth.css')}}">
<div id="loading_request" style="display: none;">
    <div class="loading_request">
        <div class="loader">
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__ball"></div>
        </div>
        <div class="loadind_text">Processando...</div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('storage/app/public/assets/css/loading.css')}}">
<script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$("#btn_register").click(function (e) {
      e.preventDefault();

      var name = $('#name').val().trim();
      var email = $('#email').val().trim();
      var mobile = $('#phone').val().trim();
      var password = $('#password').val();
      var confirm = $('#confirm_password').val();


      if (password.trim() == "") {
      	ErrorMsg('Você deve inserir a senha');
      	return;
      }

      if (password != confirm) {
      	ErrorMsg('Senha e Confirmação de senha não são iguais!!!');
      	return;
      }

      $("#loading_request").css("display", "block");

      $('#mobile').val('+55' + mobile);

      $("#form_register").submit();      
  });

</script>

@endsection