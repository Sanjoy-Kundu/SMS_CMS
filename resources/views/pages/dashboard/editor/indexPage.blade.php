@extends('layouts.dashboard')
@section('content')
    @include('components.dashboard.editor.sidebarComponent')
    @include('components.dashboard.editor.navComponent')
    @include('components.dashboard.editor.mainComponent')
    @include('components.dashboard.editor.footerComponent')
@endsection