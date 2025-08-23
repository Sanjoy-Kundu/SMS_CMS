@extends('layouts.dashboard')
@section('title', 'Teacher')
@section('content')
    @include('components.dashboard.editor.sidebarComponent')
    @include('components.dashboard.editor.navComponent')
    @include('components.dashboard.editor.teacher.teacherCreateComponent')
    @include('components.dashboard.editor.footerComponent')
    @include('components.dashboard.editor.teacher.teacherEditComponent')
@endsection