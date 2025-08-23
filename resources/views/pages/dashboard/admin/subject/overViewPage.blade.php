@extends('layouts.dashboard')
@section('title', 'Subject Overview')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.subject.overViewComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection
