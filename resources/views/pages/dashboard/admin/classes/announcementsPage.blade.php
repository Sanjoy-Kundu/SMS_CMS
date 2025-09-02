@extends('layouts.dashboard')
@section('title', 'Announcement')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.classes.workSpace.announcement.announcementComponent')
    @include('components.dashboard.admin.classes.workSpace.announcement.modal.announcementViewModalComponent')
    @include('components.dashboard.admin.footerComponent')
@endsection