@extends('layouts.dashboard')
@section('title', 'Admin')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.mainComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection