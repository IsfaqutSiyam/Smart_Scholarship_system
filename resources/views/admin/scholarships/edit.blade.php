@extends('layouts.app')
@section('title', 'Edit Scholarship')
@section('page-title', 'Edit Scholarship')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.scholarships.update', $scholarship) }}">
        @csrf @method('PUT')
        @include('admin.scholarships._form')
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.scholarships.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Scholarship</button>
        </div>
    </form>
</div>
@endsection
