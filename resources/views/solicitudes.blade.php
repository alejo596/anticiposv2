@extends('layouts.app')
@section('content')
<solicitudes-component :id_session="{{ json_encode(run_session())}}" :name="{{json_encode(current_user())}}"></solicitudes-component>
@endsection
