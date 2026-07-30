@extends('layouts.app')
@section('title', 'Edit Program')
@section('page-title', 'Edit Program')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.programs.update', $program) }}">
        @csrf @method('PUT')
        @include('admin.programs._form')
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.programs.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Program</button>
        </div>
    </form>
</div>
@endsection
