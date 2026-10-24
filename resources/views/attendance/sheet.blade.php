@extends('layouts.master')
@section('title', 'Attendance Control Room')
@section('page-title', 'Class Daily Ledger Sheet Batch Registry processing')

@section('content')
<div class="card card-outline card-navy shadow-sm">
    <div class="card-header bg-white">
        <h3 class="card-title text-navy">Roster Grid Ledger Date Processing Context: <strong>{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</strong></h3>
    </div>
    <form action="{{ route('attendance.batchStore') }}" method="POST">
        @csrf
        <input type="hidden" name="attendance_date" value="{{ $date }}">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th style="width: 80px;" class="text-center">Roll No</th>
                        <th>Admission Key</th>
                        <th>Student Name Legal Record</th>
                        <th class="text-center" style="width: 450px;">Status Configuration Metrics Tuple Selection</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roster as $enrol)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $enrol->roll_no }}</td>
                        <td><small class="text-monospace font-weight-bold">{{ $enrol->student->admission_no }}</small></td>
                        <td>{{ $enrol->student->last_name }}, {{ $enrol->student->first_name }}</td>
                        <td>
                            @php 
                                $currentStatus = $existingRecords->get($enrol->id)->status ?? 'PRESENT';
                            @endphp
                            <div class="d-flex justify-content-around align-items-center bg-light p-1 rounded border">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="attendance[{{ $enrol->id }}]" id="p_{{ $enrol->id }}" value="PRESENT" {{ $currentStatus == 'PRESENT' ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-bold" for="p_{{ $enrol->id }}">PRESENT</label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="attendance[{{ $enrol->id }}]" id="a_{{ $enrol->id }}" value="ABSENT" {{ $currentStatus == 'ABSENT' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-bold" for="a_{{ $enrol->id }}">ABSENT</label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="attendance[{{ $enrol->id }}]" id="l_{{ $enrol->id }}" value="LATE" {{ $currentStatus == 'LATE' ? 'checked' : '' }}>
                                    <label class="form-check-label text-warning fw-bold" for="l_{{ $enrol->id }}">LATE</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-end bg-white border-top">
            <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Commit Changes to Global Ledger</button>
        </div>
    </form>
</div>
@endsection