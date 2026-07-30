@extends('layouts.app')
@section('title', 'Edit University')
@section('page-title', 'Edit University')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.universities.update', $university) }}">
        @csrf @method('PUT')
        @include('admin.universities._form')
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.universities.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update University</button>
        </div>
    </form>
</div>
@endsection
