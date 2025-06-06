@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Billing & Payments</h4>
    <p>Billing details and payment history for your account.</p>

    {{-- Current Plan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Current Plan</h5>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1"><strong>Plan:</strong> xxx</p>
                    <p class="mb-1"><strong>Price:</strong> xxx</p>
                    <p class="mb-0"><strong>Next Billing Date:</strong> xxx</p>
                </div>
                <a href="#" class="btn btn-outline-primary disabled">Change Plan</a>
            </div>
        </div>
    </div>

    {{-- Payment Method --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Payment Method</h5>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">Visa ending in **** </p>
                    <p class="mb-0 text-muted">Expires ****</p>
                </div>
                <a href="#" class="btn btn-outline-secondary">Update Card</a>
            </div>
        </div>
    </div>

      {{-- Billing History --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Billing History</h5>
            <div class="alert alert-info mb-0">
                No billing history found.
            </div>
        </div>
    </div>


    {{-- Billing History --}}
    <!-- <div class="card">
        <div class="card-body">
            <h5 class="card-title">Billing History</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Invoice #</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>June 1, 2025</td>
                            <td>INV-00123</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-success">Paid</span></td>
                            <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                        </tr>
                        <tr>
                            <td>May 1, 2025</td>
                            <td>INV-00122</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-success">Paid</span></td>
                            <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
</div>
@endsection
