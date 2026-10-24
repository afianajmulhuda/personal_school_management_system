<?php
namespace App\Http\Controllers;

use App\Models\Exam_Terms;
use App\Models\ExamInvoice;
use App\Models\Student_Enrollments;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // List accounts ledger history records
    public function index()
    {
        $invoices = ExamInvoice::with(['studentEnrollment.student', 'examTerm'])
            ->orderBy('id', 'desc')
            ->get();

        return view('accounts.index', compact('invoices'));
    }

    // Process a partial or full invoice transaction payment override
    public function recordPayment(Request $request, ExamInvoice $invoice)
    {
        $request->validate([
            'amount_received' => 'required|numeric|min:0.01|max:' . $invoice->balance,
        ]);

        $newPaidAmount = $invoice->amount_paid + $request->amount_received;
        
        $status = 'Partially Paid';
        if (bccomp($newPaidAmount, $invoice->amount_due, 2) === 0) {
            $status = 'Paid';
        }

        $invoice->update([
            'amount_paid' => $newPaidAmount,
            'status' => $status,
            'payment_date' => now()
        ]);

        return redirect()->back()->with('success', 'Payment parsed securely into active ledger records.');
    }
    public function create()
    {
        $examTerms = Exam_Terms::orderBy('id', 'desc')->get();
        return view('accounts.create', compact('examTerms'));
    }

    // Step 2: Batch process and save newly generated invoices
    public function store(Request $request)
    {
        $request->validate([
            'exam_term_id' => 'required|exists:exam_terms,id',
            'amount_due'   => 'required|numeric|min:0',
            'due_date'     => 'required|date|after_or_equal:today',
        ]);

        // Fetch all active students currently enrolled across the school
        $students = Student_Enrollments::all();

        if ($students->isEmpty()) {
            return redirect()->back()->withInput()->with('error', 'No student enrollment configurations found to generate invoices against.');
        }

        $generatedCount = 0;

        foreach ($students as $student) {
            // Prevent duplicate invoice generation for the same student and term
            $exists = ExamInvoice::where('student_enrollment_id', $student->id)
                ->where('exam_term_id', $request->exam_term_id)
                ->exists();

            if (!$exists) {
                ExamInvoice::create([
                    'student_enrollment_id' => $student->id,
                    'exam_term_id'          => $request->exam_term_id,
                    'amount_due'            => $request->amount_due,
                    'amount_paid'           => 0.00,
                    'status'                => 'Unpaid',
                    'due_date'              => $request->due_date,
                ]);
                $generatedCount++;
            }
        }

        return redirect()->route('accounts.index')
            ->with('success', "Successfully generated {$generatedCount} invoices for the selected term cycle.");
    }

    // Step 3: Edit an individual invoice's base rules
    public function edit(ExamInvoice $invoice)
    {
        $examTerms = Exam_Terms::all();
        return view('accounts.edit', compact('invoice', 'examTerms'));
    }

    // Step 4: Save the edited invoice properties
    public function update(Request $request, ExamInvoice $invoice)
    {
        $request->validate([
            'amount_due' => 'required|numeric|min:' . $invoice->amount_paid, // Cannot lower below what was already paid
            'due_date'   => 'required|date',
            'status'     => 'required|in:Unpaid,Partially Paid,Paid'
        ]);

        // If amount due matches amount paid, force clear the status to Paid
        $status = $request->status;
        if (bccomp($invoice->amount_paid, $request->amount_due, 2) === 0) {
            $status = 'Paid';
        } elseif (bccomp($invoice->amount_paid, 0, 2) === 1 && bccomp($invoice->amount_paid, $request->amount_due, 2) === -1) {
            $status = 'Partially Paid';
        }

        $invoice->update([
            'amount_due' => $request->amount_due,
            'due_date'   => $request->due_date,
            'status'     => $status
        ]);

        return redirect()->route('accounts.index')->with('success', 'Invoice modifications processed successfully.');
    }
}
