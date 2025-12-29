@extends('layouts.layoutMaster')
@section('title', 'تذكرة جديدة')

@section('content')
<div class="card">
  <div class="card-header"><h5 class="mb-0">إنشاء تذكرة</h5></div>
  <div class="card-body">
    <form method="post" action="{{ route('admin.tickets.store') }}">
      @csrf
      @include('admin.tickets._form', ['submitLabel' => 'إنشاء'])
    </form>
  </div>
</div>
@endsection
