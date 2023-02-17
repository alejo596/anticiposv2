@extends('layouts.app')
@section('content')
<lista-solicitudes-component :id_session="{{ json_encode(run_session())}}"></lista-solicitudes-component>
@endsection
