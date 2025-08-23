@extends('layouts.dashboard')
@section('title', 'Teacher')
@section('content')
    @include('components.dashboard.teacher.sidebarComponent')
    @include('components.dashboard.teacher.navComponent')
    @include('components.dashboard.teacher.mainComponent')
    @include('components.dashboard.teacher.footerComponent')
@endsection