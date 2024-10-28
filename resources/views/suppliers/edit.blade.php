@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Supplier</h1>
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Supplier Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
            </div>
            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}"
                    required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ $supplier->phone }}"
                    required>
                <small id="phone-error" class="text-danger" style="display: none;">Isian harus berupa angka.</small>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" id="email" value="{{ $supplier->email }}"
                    required>
                <small id="email-error" class="text-danger" style="display: none;">Isian tidak sesuai dengan format
                    email.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        function validateForm() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');

            if (!/^\d+$/.test(phoneInput.value)) {
                phoneError.style.display = 'block';
                return false;
            } else {
                phoneError.style.display = 'none';
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                emailError.style.display = 'block';
                return false;
            } else {
                emailError.style.display = 'none';
            }

            return true;
        }
    </script>
@endsection
