@extends('layouts.dashboard')
@section('content')
    @include('components.dashboard.editor.sidebarComponent')
    @include('components.dashboard.editor.navComponent')
    @include('components.dashboard.editor.teacher.teacherCreateComponent')
    @include('components.dashboard.editor.footerComponent')
    {{-- @include('components.dashboard.editor.changePasswordComponent')
    @include('components.dashboard.editor.educationUpdateComponent')
    @include('components.dashboard.editor.addressUpdateComponent')
    @include('components.dashboard.editor.editorDetailsCVComponent') --}}
@endsection