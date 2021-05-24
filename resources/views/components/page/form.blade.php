@props(['title'])

@section('title', $title)
@extends('layouts.admin_layout.admin_layout')
@section('content')
    
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title')</h1>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h1 class="card-title">@yield('title')</h1>
                        </div>
                        {{$slot}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection