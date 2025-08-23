@extends('layouts.dashboard')
@section('title', 'Create Sub Subject')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.subject.subjectComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection