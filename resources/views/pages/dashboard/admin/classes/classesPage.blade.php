@extends('layouts.dashboard')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.classes.classesComponent')
    @include('components.dashboard.admin.footerComponent')
   
@endsection