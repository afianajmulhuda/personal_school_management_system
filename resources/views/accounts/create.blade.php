@extends('layouts.master')
@section('title', 'Batch Generate Exam Invoices')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if(session('error'))
            <div class="alert alert-danger shadow-sm mb-3">
                <i class="bi bi-x-octagon-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm border-top border-primary" style="border-top-width: 3px !important;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Batch Invoice Generation</h5>
            </div>
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select target Exam Term *</label>
                        <select name="exam_term_id" class="form-select" required>
                            <option value="">Choose target Term cycle...</option>
                            @foreach($examTerms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fee Amount Due ($) *</label>
                        <input type="number" name="amount_due" step="0.01" min="0" class="form-control font-monospace" placeholder="0.00" required value="{{ old('amount_due') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Deadline Date *</label>
                        <input type="date" name="due_date" class="form-control" required value="{{ old('due_date') }}">
                    </div>
                </div>
                <div class="card-footer bg-white text-end py-3">
                    <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-secondary me-1">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">Generate Matrix Enrolments</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection