{{-- resources/views/admin/lead_sources/create.blade.php --}}
@extends('layouts.admin.app')

@section('title','إضافة مصدر')

@section('content')
<div class="content container-fluid">
  <div class="mb-3">
    <h3 class="mb-0">إضافة مصدر</h3>
  </div>

  <form method="post" action="{{ route('admin.lead-sources.store') }}" class="card p-3">
    @csrf
    @include('admin-views.lead_sources._form')
  </form>
</div>
@endsection
