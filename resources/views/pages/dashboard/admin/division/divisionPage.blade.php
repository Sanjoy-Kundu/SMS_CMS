@extends('layouts.dashboard')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.division.divisionComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection