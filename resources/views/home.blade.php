@extends('layouts.app')
@section('content')
<inicio-fondo :id_session="{{ json_encode(run_session())}}" :name="{{json_encode(current_user())}}"></inicio-fondo>
@endsection