@extends('layouts.app')
@section('content')
<rendiciones-component :id_session="{{ json_encode(run_session())}}" :name="{{json_encode(current_user())}}"></rendiciones-component>
@endsection