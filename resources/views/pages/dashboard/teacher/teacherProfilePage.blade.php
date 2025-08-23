@extends('layouts.dashboard')
@section('title', 'My Profile')
@section('content')
    @include('components.dashboard.teacher.sidebarComponent')
    @include('components.dashboard.teacher.navComponent')
    @include('components.dashboard.teacher.profileComponent')
    @include('components.dashboard.teacher.footerComponent')
    {{-- @include('components.dashboard.teacher.changePasswordComponent')
    @include('components.dashboard.teacher.educationUpdateComponent')
    @include('components.dashboard.teacher.addressUpdateComponent')
    @include('components.dashboard.teacher.teacherDetailsCVComponent') --}}
@endsection