@extends('layouts.admin')

@section('title', 'New Post')
@section('heading', 'New Post')

@section('content')
    @include('admin.posts._form')
@endsection
