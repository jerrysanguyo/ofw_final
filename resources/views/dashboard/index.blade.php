@extends('layouts.dashboard')
@section('content')
    @role('superadmin|admin')
        @include('dashboard.admin')
    @endrole
    
    @role('user')
        @include('dashboard.user')
    @endrole
@endsection