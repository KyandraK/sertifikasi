<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('product')->get();
        return view('reports.index', compact('reports'));
    }

    public function downloadPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $reports = Report::with('product')
            ->whereBetween('transaction_date', [$request->start_date, $request->end_date])
            ->get();

        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected date range.');
        }

        $pdf = PDF::loadView('reports.pdf', compact('reports'));
        return $pdf->download('report_' . $request->start_date . '_to_' . $request->end_date . '.pdf');
    }
}
