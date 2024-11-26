@extends('layouts.yellow.master')

@section('styles')
<style>
    #accordion {
        background: #f1f1f1;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    #accordion .btn-link {
        font-size: 2.5rem;
        border: none;
    }
    #accordion .card-body {
        padding-left: 30px;
        padding-right: 30px;
    }
    #accordion ul,
    #accordion ol {
        margin-left: 1rem;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper clearfix py-4">
    <div class="container">
        <div class="page-wrapper clearfix">
            <h2 class="section-title">{{ $page->title }}</h2>
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection