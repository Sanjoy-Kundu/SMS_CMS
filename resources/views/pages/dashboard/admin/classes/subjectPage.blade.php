@extends('layouts.dashboard')
@section('title', 'Subjects')
@section('content')
    @include('components.dashboard.admin.sidebarComponent')
    @include('components.dashboard.admin.navComponent')
    @include('components.dashboard.admin.classes.workSpace.subject.subjectListsComponent')
    {{-- @include('components.dashboard.admin.classes.workSpace.announcement.modal.announcementViewModalComponent')
    @include('components.dashboard.admin.classes.workSpace.announcement.modal.announcementEditModalComponent') --}}
    @include('components.dashboard.admin.footerComponent')
@endsection