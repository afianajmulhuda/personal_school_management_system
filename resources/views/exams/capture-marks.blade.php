@extends('layouts.master')
@section('title', 'Grade Sheet Entry Vault')
@section('page-title', 'Performance Evaluation Matrix Input Deck')

@section('content')
<div class="invoice p-3 mb-3 border rounded shadow-sm bg-white">
    <div class="row text-muted small text-uppercase font-weight-bold mb-3">
        <div class="col-sm-4"><strong>Subject Evaluation Track:</strong> <span class="text-dark d-block fs-5">{{ $exam->subject->name }}</span></div>
        <div class="col-sm-4"><strong>Exam Ceiling Max Cap:</strong> <span class="badge text-bg-dark fs-6">{{ $exam->max_marks }} Points</span></div>
        <div class="col-sm-4"><strong>Minimum Processing Pass Cut:</strong> <span class="text-danger d-block fs-6 fw-bold">{{ $exam->min_passing_marks }} Points</span></div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('exams.pushMarks', $exam->id) }}" method="POST">
    @csrf
    <div class="card card-warning card-outline">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 100px;" class="text-center">Roll ID</th>
                        <th>Legal Full Name Student Record</th>
                        <th style="width: 250px;">Input Scores Scale Data</th>
                        <th style="width: 150px;" class="text-center">Absentee Flag</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classRoster as $studentEnrol)
                    @php 
                        $scoreAnchor = $savedMarksLedger->get($studentEnrol->id);
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $studentEnrol->roll_no }}</td>
                        <td>{{ $studentEnrol->student->last_name }}, {{ $studentEnrol->student->first_name }}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number" step="0.01" max="{{ $exam->max_marks }}" name="marks[{{ $studentEnrol->id }}][obtained]" value="{{ old('marks.'.$studentEnrol->id.'.obtained', $scoreAnchor->marks_obtained ?? '') }}" class="form-control fw-bold fs-6 text-center text-primary" placeholder="0.00">
                                <span class="input-group-text">/ {{ $exam->max_marks }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="marks[{{ $studentEnrol->id }}][absent]" value="0">
                            <input type="checkbox" class="form-check-input mt-0 align-middle" name="marks[{{ $studentEnrol->id }}][absent]" value="1" {{ ($scoreAnchor->is_absent ?? false) ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-end bg-light">
            <button type="submit" class="btn btn-warning font-weight-bold px-4">Publish Grade Configuration Ledgers</button>
        </div>
    </div>
</form>
@endsection