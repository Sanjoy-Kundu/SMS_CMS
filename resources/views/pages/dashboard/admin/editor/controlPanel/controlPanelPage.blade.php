@extends('layouts.dashboard')
@section('title', 'Editor Control Panel')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.editor.controlPanel.controlPanelComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection