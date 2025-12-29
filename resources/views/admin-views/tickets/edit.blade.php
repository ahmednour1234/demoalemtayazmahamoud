@extends('layouts.layoutMaster')
@section('title', 'تعديل تذكرة')

@section('content')
<div class="card">
  <div class="card-header"><h5 class="mb-0">تعديل تذكرة #{{ $ticket->id }}</h5></div>
  <div class="card-body">
    <form method="post" action="{{ route('admin.tickets.update', $ticket->id) }}">
      @csrf @method('put')
      @include('admin.tickets._form', ['submitLabel' => 'تحديث'])
    </form>
  </div>
</div>
@endsection
