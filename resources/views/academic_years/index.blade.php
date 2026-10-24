@extends('layouts.master')
@section('title', 'Academic Cycles')
@section('page-title', 'Academic Year Management')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Status Notification Elements -->
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

        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-primary fw-bold mb-0">Historical & Active School Cycles</h3>
                <a href="{{ route('academic_years.create') }}" class="btn btn-primary btn-sm ms-auto">
                    <i class="bi bi-calendar-plus me-1"></i> Setup New Year
                </a>
            </div>
            
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;" class="text-center">ID</th>
                            <th>Cycle Identifier Name</th>
                            <th>Start Boundary</th>
                            <th>End Boundary</th>
                            <th class="text-center">System Status Flags</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($years as $year)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $year->id }}</td>
                            <td><strong class="text-dark">{{ $year->name }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($year->start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($year->end_date)->format('M d, Y') }}</td>
                            <td class="text-center">
                                @if($year->is_active)
                                    <span class="badge bg-success px-2 py-1"><i class="bi bi-lightning-fill"></i> Current Active</span>
                                @else
                                    <span class="badge bg-secondary px-2 py-1">Inactive Standby</span>
                                @endif

                                @if($year->is_closed)
                                    <span class="badge bg-danger px-2 py-1"><i class="bi bi-lock-fill"></i> Closed Ledger</span>
                                @else
                                    <span class="badge bg-info text-dark px-2 py-1"><i class="bi bi-unlock-fill"></i> Open For Edits</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('academic_years.edit', $year->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify parameters">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form action="{{ route('academic_years.destroy', $year->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Danger! Are you completely sure you want to permanently purge this data block from the structural mapping configuration? This action is irreversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" {{ $year->is_active ? 'disabled' : '' }} title="Purge Record">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-calendar4-week fs-1 d-block mb-2"></i>
                                No academic timeline records found.
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