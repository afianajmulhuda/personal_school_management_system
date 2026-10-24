@extends('layouts.master')
@section('title', 'Guardian Registry')
@section('page-title', 'Family & Guardian Matrix Profiles')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card card-outline card-indigo shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-indigo fw-bold mb-0">Registered Guardians Hierarchy</h3>
                <a href="{{ route('guardians.create') }}" class="btn btn-indigo btn-sm ms-auto text-white" style="background-color: #4e73df;">
                    <i class="bi bi-person-plus-fill me-1"></i> Register New Family Unit
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;" class="text-center">ID</th>
                            <th>Parents Information Log</th>
                            <th>Primary Emergency Responder</th>
                            <th>Email Contact</th>
                            <th class="text-center">Active Dependents</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guardians as $guardian)
                        <tr>
                            <td class="text-center text-muted fw-bold">#{{ $guardian->id }}</td>
                            <td>
                                @if($guardian->father_name)
                                    <div><small class="text-muted">F:</small> <strong class="text-dark">{{ $guardian->father_name }}</strong> ({{ $guardian->father_phone ?? 'No Phone' }})</div>
                                @endif
                                @if($guardian->mother_name)
                                    <div><small class="text-muted">M:</small> <strong class="text-dark">{{ $guardian->mother_name }}</strong> ({{ $guardian->mother_phone ?? 'No Phone' }})</div>
                                @endif
                                @if(!$guardian->father_name && !$guardian->mother_name)
                                    <span class="text-muted italic">See Emergency Card</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-indigo"><i class="bi bi-telephone-outbound me-1"></i>{{ $guardian->emergency_contact_name }}</div>
                                <span class="badge bg-light text-dark border font-monospace mt-1">{{ $guardian->emergency_relation }} : {{ $guardian->emergency_contact_phone }}</span>
                            </td>
                            <td><span class="text-secondary small">{{ $guardian->guardian_email ?? 'N/A' }}</span></td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary px-3">{{ $guardian->students_count }} Students</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('guardians.edit', $guardian->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Configuration">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('guardians.destroy', $guardian->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purge this parent guardian record structural setup?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Record">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-person-bounding-box fs-1 d-block mb-2"></i>
                                No parent or backup guardian directories initialized.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection