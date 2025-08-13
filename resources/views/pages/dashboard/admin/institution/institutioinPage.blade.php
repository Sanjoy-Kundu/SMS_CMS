@extends('layouts.dashboard')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.institution.institutionComponent')
    @include('components.dashboard.admin.footerComponent')
    @include('components.dashboard.admin.institution.modal.institutionEditModalComponent')
@endsection