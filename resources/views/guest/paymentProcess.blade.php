<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <title>Process Payment</title>
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center">Confirm Your Registration Payment</h3>

        <form method="POST" action="{{ route('processPayment') }}">
            @csrf
            <input type="hidden" name="registrationFee" value="{{ $registrationFee }}">

            <h5>Your Details:</h5>
            <p>Name: {{ $registrationData['name'] }}</p>
            <p>Email: {{ $registrationData['email'] }}</p>
            <p>Gender: {{ $registrationData['gender'] }}</p>
            <p>Field of Work: {{ $registrationData['field_of_work'] }}</p>
            <p>LinkedIn: {{ $registrationData['linkedin_username'] }}</p>
            <p>Mobile Number: {{ $registrationData['mobile_number'] }}</p>

            <div class="mb-3">
                <label for="amount" class="form-label">Enter Amount</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                    name="amount" placeholder="Enter the fee amount"
                    value="{{ old('amount', session('previousAmount')) }}" required>
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <p>Registration Fee: <strong>Rp <span id="registrationFee">{{ $registrationFee }}</span></strong></p>

            <button type="submit" class="btn btn-primary">Confirm Payment</button>
        </form>
        @if (session('confirmationNeeded'))
            <div class="modal fade" id="overpaymentModal" tabindex="-1" aria-labelledby="overpaymentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="overpaymentModalLabel">Overpayment Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="overpaymentMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <form method="POST" action="{{ route('confirmOverpayment') }}">
                                @csrf
                                <input type="hidden" name="confirmOverpayment" value="yes">
                                <input type="hidden" name="overpaidAmount" value="{{ session('overpaidAmount') }}">
                                <input type="hidden" name="amount" value="{{ session('previousAmount') }}">
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <script>
        @if (session('confirmationNeeded'))
            document.addEventListener('DOMContentLoaded', function() {
                const overpaymentAmount = {{ session('overpaidAmount') }};
                document.getElementById('overpaymentMessage').innerText = "You overpaid by Rp " +
                    overpaymentAmount + ". Would you like to confirm?";
                const overpaymentModal = new bootstrap.Modal(document.getElementById('overpaymentModal'));
                overpaymentModal.show();
            });
        @endif
    </script>
</body>

</html>
