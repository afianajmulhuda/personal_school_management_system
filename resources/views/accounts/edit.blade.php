@extends('layouts.master')
@section('title', 'Modify Individual Invoice Properties')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-top border-warning" style="border-top-width: 3px !important;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Invoice Context</h5>
            </div>
            <form action="{{ route('accounts.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3 bg-light p-3 rounded border">
                        <small class="text-muted d-block">Student Recipient Target</small>
                        <strong class="text-dark d-block mb-2">{{ $invoice->studentEnrollment->student->first_name }} {{ $invoice->studentEnrollment->student->last_name }}</strong>
                        
                        <small class="text-muted d-block">Associated Cycle Track</small>
                        <span class="badge bg-secondary">{{ $invoice->examTerm->name }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Adjusted Amount Due ($) *</label>
                        <input type="number" name="amount_due" step="0.01" min="{{ $invoice->amount_paid }}" class="form-control font-monospace" value="{{ old('amount_due', $invoice->amount_due) }}" required>
                        <div class="form-text text-muted">Cannot be set lower than the currently recorded paid amount: <strong>${{ number_format($invoice->amount_paid, 2) }}</strong></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Extended/Adjusted Due Date *</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Manual Settlement Status Override</label>
                        <select name="status" class="form-select">
                            <option value="Unpaid" {{ $invoice->status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="Partially Paid" {{ $invoice->status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                            <option value="Paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-white text-end py-3">
                    <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-secondary me-1">Cancel Changes</a>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold text-dark px-4">Commit Balance Updates</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection