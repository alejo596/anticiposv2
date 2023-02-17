@extends('layouts.app')
@section('content')
<rendiciones-finanza-component :id_session="{{ json_encode(run_session())}}" :name="{{json_encode(current_user())}}"></rendiciones-finanza-component>
@endsection