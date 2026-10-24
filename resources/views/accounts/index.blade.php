@extends('layouts.master')
@section('title', 'Exam Accounts Ledger Balance')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            
            <!-- System Feedback Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 4px solid #198754 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                        <div>
                            <span class="fw-bold d-block">Transaction Updated</span>
                            {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-octagon-fill text-danger fs-4 me-3"></i>
                        <div>
                            <span class="fw-bold d-block">Action Processing Failure</span>
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Ledger Workstation Card -->
            <div class="card shadow-sm border-0 border-top border-success" style="border-top-width: 4px !important;">
                
                <!-- Card Header Layout Context -->
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-success bg-opacity-10 text-success rounded me-3">
                            <i class="bi bi-bank2 fs-4 lh-1"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Exam Fee Collection Ledger</h5>
                            <small class="text-muted">Monitor invoicing runs, process custom financial exceptions, and receive student balances</small>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('accounts.create') }}" class="btn btn-success fw-bold px-3 shadow-sm d-inline-flex align-items-center">
                            <i class="bi bi-plus-lg me-2"></i> Batch Create Invoices
                        </a>
                    </div>
                </div>

                <!-- Ledger Responsive Matrix Content View -->
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light text-secondary small text-uppercase font-monospace border-bottom">
                            <tr>
                                <th class="ps-4" style="width: 15%">Invoice Token</th>
                                <th style="width: 30%">Student Demographics</th>
                                <th style="width: 15%">Exam Term Cycle</th>
                                <th style="width: 10%">Due Base</th>
                                <th style="width: 10%">Settlement Status</th>
                                <th class="text-center" style="width: 10%">Remittance Remaining</th>
                                <th class="text-end pe-4" style="width: 10%">Action Context Override</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $inv)
                            <tr class="border-bottom border-light-subtle">
                                <!-- Unique System Code Segment -->
                                <td class="ps-4">
                                    <span class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-medical text-muted me-2"></i>
                                        <code class="font-monospace fw-bold text-secondary">#EX-{{ str_pad($inv->id, 5, '0', STR_PAD_LEFT) }}</code>
                                    </span>
                                </td>
                                
                                <!-- Linked Student Node Roster Profile -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold">
                                            {{ $inv->studentEnrollment->student->first_name }} {{ $inv->studentEnrollment->student->last_name }}
                                        </span>
                                        <span class="text-muted small font-monospace">
                                            Roll ID: #{{ $inv->studentEnrollment->student->id }}
                                        </span>
                                    </div>
                                </td>
                                
                                <!-- Active Cycle Mapping Info -->
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded border border-secondary-subtle">
                                        {{ $inv->examTerm->name }}
                                    </span>
                                </td>
                                
                                <!-- Ledger Cost Parameters Base -->
                                <td class="font-monospace text-dark fw-medium">
                                    ${{ number_format($inv->amount_due, 2) }}
                                </td>
                                
                                <!-- Visual Status Badges Tracking State -->
                                <td>
                                    @if($inv->status == 'Paid')
                                        <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 rounded-pill border border-success border-opacity-20 d-inline-flex align-items-center">
                                            <i class="bi bi-patch-check-fill me-1"></i> Paid
                                        </span>
                                    @elseif($inv->status == 'Partially Paid')
                                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-2.5 py-1.5 rounded-pill border border-warning border-opacity-20 d-inline-flex align-items-center">
                                            <i class="bi bi-hourglass-split me-1"></i> Partial
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 rounded-pill border border-danger border-opacity-20 d-inline-flex align-items-center">
                                            <i class="bi bi-exclamation-circle-fill me-1"></i> Unpaid
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Core Dynamic Calculations Ledger Remainder Balance -->
                                <td class="text-center font-monospace fw-bold {{ $inv->balance > 0 ? 'text-danger' : 'text-success' }}">
                                    ${{ number_format($inv->balance, 2) }}
                                </td>
                                
                                <!-- Operational Interface Control Actions Menu Trigger -->
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <!-- Edit Adjustments Override Button Redirect -->
                                        <a href="{{ route('accounts.edit', $inv->id) }}" class="btn btn-sm btn-outline-warning text-dark border-opacity-20 p-2 d-inline-flex align-items-center shadow-sm" title="Modify Base Specifications">
                                            <i class="bi bi-pencil-square lh-1 fs-6"></i>
                                        </a>

                                        @if($inv->balance > 0)
                                            <!-- Launch Payments Collection Inline View Panel Modal -->
                                            <button class="btn btn-sm btn-success fw-bold px-2.5 py-1.5 shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#payModal_{{ $inv->id }}">
                                                <i class="bi bi-cash-coin fs-6"></i> Pay
                                            </button>
                                        @else
                                            <!-- Completed Lockout State Badge Indicator -->
                                            <button class="btn btn-sm btn-light text-muted border border-light-subtle px-2.5 py-1.5" disabled>
                                                <i class="bi bi-check-all me-1"></i> Cleared
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Transaction Injection Modal (Rendered contextually ONLY if balance remainder exists) -->
                            @if($inv->balance > 0)
                            <div class="modal fade text-wrap" id="payModal_{{ $inv->id }}" tabindex="-1" aria-labelledby="payModalLabel_{{ $inv->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('accounts.pay', $inv->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header bg-success text-white py-3">
                                                <h5 class="modal-title fw-bold id="payModalLabel_{{ $inv->id }}">
                                                    <i class="bi bi-currency-dollar me-1"></i> Record Exam Fee Payment
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3 bg-light p-3 rounded border border-light-subtle">
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">Student Recipient</small>
                                                            <span class="fw-bold text-dark">{{ $inv->studentEnrollment->student->first_name }} {{ $inv->studentEnrollment->student->last_name }}</span>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <small class="text-muted d-block">Current Balance</small>
                                                            <span class="fw-bold font-monospace text-danger fs-5">${{ number_format($inv->balance, 2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-0">
                                                    <label class="form-label fw-bold text-dark">Enter Amount Received ($) *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 text-muted font-monospace">$</span>
                                                        <input type="number" 
                                                               name="amount_received" 
                                                               step="0.01" 
                                                               min="0.01" 
                                                               max="{{ $inv->balance }}" 
                                                               class="form-control border-start-0 font-monospace fs-5 text-dark" 
                                                               value="{{ $inv->balance }}" 
                                                               required 
                                                               autofocus>
                                                    </div>
                                                    <div class="form-text text-muted mt-2">
                                                        System automatically flags transaction entries as <strong>Paid</strong> or <strong>Partial</strong> depending on totals received.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light py-2.5">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-success fw-bold px-4">Post Payment Entry</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @empty
                            <!-- Empty Set Fallback Template -->
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5 border-0">
                                    <div class="d-flex flex-column align-items-center py-4">
                                        <i class="bi bi-wallet-fill text-black-50 fs-1 mb-3 bg-light p-3 rounded-circle"></i>
                                        <h6 class="fw-bold text-dark">No Financial Records Found</h6>
                                        <p class="small text-muted mb-3 max-width-350 mx-auto">There are currently no exam invoices logged into the tracking structure system matrix.</p>
                                        <a href="{{ route('accounts.create') }}" class="btn btn-sm btn-success fw-bold px-3">
                                            Run Initial Batch Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary Information Layout Block -->
                @if($invoices->isNotEmpty())
                <div class="card-footer bg-light border-top py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small font-monospace">
                    <div>
                        Total Invoices Processed: <strong>{{ $invoices->count() }} records</strong>
                    </div>
                    <div>
                        Aggregate Balance Remaining: <strong class="text-danger">${{ number_format($invoices->sum(fn($i) => $i->balance), 2) }}</strong>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection