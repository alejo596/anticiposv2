@extends('layouts.app')
@section('content')
<reportes-component :id_session="{{ json_encode(run_session())}}" :name="{{json_encode(current_user())}}"></reportes-component>
@endsection