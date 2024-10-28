@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Supplier</h1>
        <form action="{{ route('suppliers.store') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="form-group">
                <label for="name">Supplier Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" name="contact_person" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control" id="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>

    <script>
        function validateForm() {
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            let errorMessage = "";

            if (!/^\d+$/.test(phoneInput.value)) {
                errorMessage += "Isian phone harus berupa angka.\n";
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                errorMessage += "Isian email tidak sesuai dengan format email.\n";
            }

            if (errorMessage) {
                alert(errorMessage);
                return false;
            }

            return true;
        }
    </script>
@endsection
