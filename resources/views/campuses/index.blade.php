@extends('layouts.master')
@section('title', 'Campus Registry')
@section('page-title', 'Manage Campuses')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">All Institutional Campuses</h3>
        <a href="{{ route('campuses.create') }}" class="btn btn-primary btn-sm ms-auto">Add New Campus</a>
    </div>
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        <table class="table table-striped table-valign-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Campus Name</th>
                    <th>Active Enrollments</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campuses as $campus)
                <tr>
                    <td>{{ $campus->id }}</td>
                    <td><span class="badge text-bg-secondary">{{ $campus->code }}</span></td>
                    <td><strong>{{ $campus->name }}</strong></td>
                    <td>{{ $campus->enrollments_count }} Students</td>
                    <td class="text-end">
                        <a href="{{ route('campuses.edit', $campus->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this campus? High data cascading structural risk!')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection