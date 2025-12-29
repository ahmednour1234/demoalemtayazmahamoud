{{-- resources/views/admin/lead_sources/edit.blade.php --}}
@extends('layouts.admin.app')

@section('title','تعديل مصدر')

@section('content')
<div class="content container-fluid">
  <div class="mb-3">
    <h3 class="mb-0">تعديل مصدر: {{ $source->name }}</h3>
  </div>

  <form method="post" action="{{ route('admin.lead-sources.update',$source) }}" class="card p-3">
    @csrf @method('PUT')
    @include('admin-views.lead_sources._form', ['source' => $source])
  </form>
</div>
@endsection
