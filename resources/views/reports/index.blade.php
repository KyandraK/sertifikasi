@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h1>Stock Report</h1>

        <form action="{{ route('reports.downloadPDF') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control">Download PDF</button>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->product->name }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{ $report->type == 'in' ? $report->quantity_in : $report->quantity_out }}</td>
                        <td>{{ $report->transaction_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
