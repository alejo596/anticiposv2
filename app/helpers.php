<?php
use Illuminate\Support\Facades\DB;
session_start();
$estado_session = session_status();

function activeMenu($uri = '') {
    $active = '';
    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
        $active = 'active';
    }
    return $active;
}


function current_user()
{  	




    return  $_SESSION['nom']; // output yes
}

function run_session()
{   
    $estado_session = session_status(); 
    if(!isset($_SESSION))
    {
        return  view('findelasession');
    }else{
    return  $_SESSION['rut']; // output yes
  }
}

function sessiones()
{
  return $_SESSION['permiso'];
}
