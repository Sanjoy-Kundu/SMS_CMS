@extends('layouts.dashboard')
@section('title', 'WorkSpace Panel')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.classes.workSpace.workSpaceComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection
