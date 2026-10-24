<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Marksheet - {{ $examTerm->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; font-family: system-ui, sans-serif; font-size: 13px; }
        .table-ledger th, .table-ledger td { border: 1px solid #ddd !important; text-align: center; vertical-align: middle; }
        .table-ledger th { background-color: #f4f6f9 !important; font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <!-- Utility Control Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <button onclick="window.history.back()" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</button>
        <button onclick="window.print()" class="btn btn-primary btn-sm px-4 fw-bold">Print/Save as PDF</button>
    </div>

    <!-- Official Report Template -->
    <div class="border p-4 rounded bg-white">
        <div class="text-center mb-4 border-bottom pb-3">
            <h3 class="fw-bold mb-1 text-uppercase">Consolidated Class Marksheet</h3>
            <h5 class="text-secondary mb-0">Exam Term: <span class="text-dark fw-bold">{{ $examTerm->name }}</span></h5>
        </div>

        <table class="table table-bordered table-ledger align-middle">
            <thead>
                <tr>
                    <th style="width: 5%;">Roll</th>
                    <th class="text-start" style="width: 20%;">Student Name</th>
                    
                    <!-- Dynamic subject columns parsed from the scheduled exams -->
                    @foreach($exams as $exam)
                        <th>
                            <div class="small text-muted font-monospace">{{ $exam->subject->code ?? '' }}</div>
                            <div>{{ $exam->subject->name }}</div>
                            <span class="badge bg-secondary-subtle text-dark font-monospace" style="font-size: 10px;">Max: {{ $exam->max_marks }}</span>
                        </th>
                    @endforeach
                    
                    <th style="width: 10%;">Total Obtained</th>
                    <th style="width: 10%;">Percentage</th>
                    <th style="width: 10%;">Result Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td class="font-monospace fw-bold">{{ str_pad($student->roll_no ?? 0, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-start fw-bold">{{ $student->student->first_name }} {{ $student->student->last_name }}</td>
                    
                    <!-- Map marks cleanly to the correct dynamic subject columns -->
                    @foreach($exams as $exam)
                        <td class="font-monospace">
                            @if($student->subject_marks[$exam->subject_id] === 'Absent')
                                <span class="text-danger fw-bold">ABS</span>
                            @else
                                {{ $student->subject_marks[$exam->subject_id] }}
                            @endif
                        </td>
                    @endforeach
                    
                    <td class="font-monospace fw-bold">{{ $student->total_obtained }} / {{ $student->total_max }}</td>
                    <td class="font-monospace fw-bold text-primary">{{ number_format($student->percentage, 2) }}%</td>
                    <td>
                        @if($student->percentage >= 40)
                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded text-uppercase">Passed</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2.5 py-1.5 rounded text-uppercase">Failed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($exams) + 5 }}" class="text-center py-4 text-muted">No students found or marks recorded for the selected class selection.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>