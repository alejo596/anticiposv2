<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">




<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">


	<title>{{ config('app.name', 'Fondos Fijos v2') }}</title>
	<!--     Fonts and icons     -->
	
	<!-- CSS Files -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link href="{{ asset('css/libs.css') }}"  rel="stylesheet"> 

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">  
  <style type="text/css">
    .box:hover {
     border-color: purple;
   }
   .elegir:hover {

    color:#f96332;
  }
</style> 
<script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

</head>

<body class="">

	
	<div class="wrapper ">
		<div class="sidebar" data-color="red">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
       <a href="#" class="simple-text logo-mini">

       </a>
       <a href="#" class="simple-text logo-normal">
        Fondos Fijos
      </a>
    </div>

    <div class="sidebar-wrapper" id="sidebar-wrapper" style="overflow-y: scroll; overflow-x:hidden;overflow-y:hidden;">

    	<ul class="nav">
        <div class="accordion" id="accordionExample">        


          <a class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <div class="row">
              <div class="col-xs-1">
                <i class="now-ui-icons design_app" ></i>
              </div>
              <div class="col-xs-11">
                @php
                $s = sessiones();
                @endphp
                <label class="mt-2">SOLICITUDES</label>
                
              </div>

            </div>

          </a>          


          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card">
              <div class="card-body ">
                <a href="solicitudes" ><i class="now-ui-icons files_paper" style="color:#f56131"> </i> <label class="mt-2 elegir" >Ingresar Solicitudes</label>

                </a>            


              </a>

            </div>
          </div>
        </div>



        <a class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapsedos"  aria-expanded="true" aria-controls="collapsedos">
          <div class="row">
            <div class="col-xs-1">
              <i class="now-ui-icons education_atom"></i>
            </div>
            <div class="col-xs-11">
              <label class="mt-2">ANTICIPOS</label>
            </div>

          </div>

        </a> 
        <div id="collapsedos" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card">
            <div class="card-body ">
              @if (in_array(223,$s)!= NULL)
              <a href="rendiciones" ><i class="now-ui-icons business_bank" style="color:#f56131"> </i> <label class="mt-2 elegir" >Ingreso de Rendicion</label></a>
              @endif
              <br>
              @if (in_array(222,$s)!= NULL)
              <a href="rendicionesfinanza"  ><i class="now-ui-icons business_bank" style="color:#f56131"> </i> <label class="mt-2 elegir" >Ingreso de Rendicion</label></a>  
              @endif
              <br>

            </div>
          </div>
        </div>  

        <a class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapsetres"  aria-expanded="true" aria-controls="collapsetres">
          <div class="row">
            <div class="col-xs-1">
              <i class="now-ui-icons education_atom"></i>
            </div>
            <div class="col-xs-11">
              <label class="mt-2">MANTENEDOR</label>
            </div>

          </div>

        </a>   @if (in_array(210,$s)!= NULL)
        <div id="collapsetres" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card">

            <a href="solicitudeslista"  ><i class="now-ui-icons business_bank" style="color:#f56131"> </i> <label class="mt-2 elegir" >Lista de solicitudes</label></a>  
            
          </div>
        </div>  
        @endif


      </div>




    </div>
  </div>
  <div class="main-panel" id="main-panel">
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" id="index" href="#">
          <label style="max-width: 271px;">Servicio de Salud Arica</label>
          <div class="col-lg-12" style="padding-right:0 !important;padding-left:0 !important;max-width: 271px;">
            <div class="row">
              <div class="col-lg-6" style="padding-right:0 !important;padding-left:0 !important;">
                <div style="height:4px;background-color:red;width:100%;"></div>
              </div>
              <div class="col-lg-6" style="padding-right:0 !important;padding-left:0 !important;">
                <div style="height:4px;background-color:blue;width:100%;"></div>
              </div>                            
            </div>
          </div>

          <label style="max-width: 271px;font-size: large;">Fondos Fijos V2</label>
        </a>
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <form>
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Buscar...">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="now-ui-icons ui-1_zoom-bold"></i>
            </div>
          </div>
        </div>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#pablo">
            <i class="now-ui-icons media-2_sound-wave"></i>
            <p>
              <span class="d-lg-none d-md-block">Stats</span>
            </p>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="now-ui-icons users_single-02"></i>{{ current_user()}}
            <p>
              <span class="d-lg-none d-md-block">Some Actions</span>
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#"> <i class="now-ui-icons media-1_button-power"> </i> Salir</a> 

          </div>
        </li>

      </ul>
    </div>
  </div>
</nav>
<div class="panel-header panel-header-lg">

</div>
<div id="app">
  <div class="container-fluid mt-4">
    @yield('content')
  </div>
</div>

</div>

</div>
<!--   Core JS Files   -->
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/libs.js') }}" ></script>      



</body>

</html>