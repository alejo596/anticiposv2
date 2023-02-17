<?php 
use Illuminate\Support\Facades\Route;



?>

Hubo un error en tu aplicación Laravel Fondos Fijos Produccion<br />

<hr />

<table border="1" width="100%">
    <tr><th >User:</th><td></td></tr>

    <label>Errores:</label>  
 
    <tr><th >Message:</th><td>{{$e['message']}}</td></tr>
    <tr><th >Line:</th><td>{{ $e['line'] }}</td></tr>
    <tr><th >Code:</th><td>{{ $e['code'] }}</td></tr>
    <tr><th >sistema:</th><td>{{ $e['sistema'] }}</td></tr>
</table>