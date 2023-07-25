<!DOCTYPE html>
<html lang="en">


    <head>
    <title>{{ Helper::webinfo(1)->website_title }}</title>
    <!-- meta tag -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{ Helper::webinfo(1)->meta_title }}" />
    <meta property="og:description" content="{{ Helper::webinfo(1)->meta_description }}" />
    <meta property="og:image" content='{{ Helper::webinfo(1)->og_image }}' />
    <!-- favicon-icon  -->
    <link rel="icon" href='{{ Helper::webinfo(1)->favicon }}' type="image/x-icon">
    <!-- font-awsome css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/font-awsome.css') !!}">
    <!-- fonts css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/fonts/fonts.css') !!}">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/bootstrap.min.css') !!}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/owl.carousel.min.css') !!}">
    <!-- style css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/style.css') !!}">
    <link href="{!! asset('storage/app/public/assets/plugins/sweetalert/css/sweetalert.css') !!}" rel="stylesheet">
    <!-- responsive css  -->
    <link rel="stylesheet" type="text/css" href="{!! asset('storage/app/public/front/css/responsive.css') !!}">
    </head>


    <body class="error-class">
        <div class="d-flex align-items-center justify-content-center ">
            <div class="text-center">
                <h1 class="display-1 fw-bold">405</h1>
                <p> <span class="text-danger">Oops!</span> An Error Occurred</p>
                <p class="info text-danger">The server returned a "405 Method Not Allowed".</p>
                <p>Something is broken. Please let us know what you were doing when this error occurred. We will fix it as soon as possible. Sorry for any inconvenience caused.</p>
                <a href="{{ URL::to('/') }}" class="btn btn-block btn-dark mb-2  w-50">Go Home</a>
            </div>
        </div>
    </body>


</html>