@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Help & Support</h4>
    <p class="mb-4">Need assistance? Search our help center or reach out to our support team.</p>

    {{-- Search Bar --}}
    <div class="input-group mb-4">
        <input type="text" class="form-control" placeholder="Search help articles..." disabled>
        <span class="input-group-text bg-secondary text-white"><i class="bx bx-search"></i></span>
    </div>

    {{-- Help Categories --}}
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bx bx-question-mark fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">FAQs</h5>
                    <p class="card-text">Browse frequently asked questions for quick answers.</p>
                    <a href="#" class="btn btn-outline-primary disabled">View FAQs</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bx bx-envelope fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Contact Support</h5>
                    <p class="card-text">Reach out to our support team for help with your issue.</p>
                    <a href="#" class="btn btn-outline-success disabled">Send a Message</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bx bx-book fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Documentation</h5>
                    <p class="card-text">Explore guides, documentation, and setup instructions.</p>
                    <a href="#" class="btn btn-outline-warning disabled">View Docs</a>
                </div>
            </div>
        </div>
    </div>

    {{-- If No Support Requests --}}
    <div class="alert alert-info mt-4">
        You have no recent support tickets or messages.
    </div>
</div>
@endsection
