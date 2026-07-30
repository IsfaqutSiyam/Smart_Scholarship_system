@extends('layouts.app')
@section('title', 'Add Scholarship')
@section('page-title', 'Add Scholarship')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.scholarships.store') }}">
        @csrf
        @include('admin.scholarships._form')
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.scholarships.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Scholarship</button>
        </div>
    </form>
</div>
@endsection
