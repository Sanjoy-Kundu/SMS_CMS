@extends('layouts.dashboard')
@section('title', 'Paper')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.subject.paper.paperComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection