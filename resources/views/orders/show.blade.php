@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order #{{ $order->id }} - {{ $order->customer_name }}</h1>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>

        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.addDetail', ['order' => $order->id]) }}" method="POST"
                        id="addProductForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select name="product_id" id="product_id" class="form-control" required>
                                    <option value="">Select a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" name="price" id="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required
                                    min="1" value="1">
                            </div>
                            <div class="mb-3">
                                <label for="total" class="form-label">Total Price</label>
                                <input type="text" id="total" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const productSelect = document.getElementById('product_id');
                const priceInput = document.getElementById('price');
                const quantityInput = document.getElementById('quantity');
                const totalInput = document.getElementById('total');

                function calculateTotal() {
                    const price = parseFloat(priceInput.value) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const total = price * quantity;
                    totalInput.value = total.toFixed(2);
                }

                productSelect.addEventListener('change', function() {
                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');

                    priceInput.value = price;
                    calculateTotal();
                });

                quantityInput.addEventListener('input', calculateTotal);
                priceInput.addEventListener('input', calculateTotal);
            });
        </script>

        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orderDetailsTable">
                @foreach ($order->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td class="price">{{ $detail->price }}</td>
                        <td class="quantity">{{ $detail->quantity }}</td>
                        <td class="total">{{ $detail->price * $detail->quantity }}</td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editProductModal{{ $detail->id }}">Edit</button>
                            <form
                                action="{{ route('orders.deleteDetail', ['order' => $order->id, 'detail' => $detail->id]) }}"
                                method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="editProductModal{{ $detail->id }}" tabindex="-1"
                        aria-labelledby="editProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form
                                    action="{{ route('orders.editDetail', ['order' => $order->id, 'detail' => $detail->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="price_{{ $detail->id }}" class="form-label">Price</label>
                                            <input type="text" name="price" id="price_{{ $detail->id }}"
                                                class="form-control" value="{{ $detail->price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity_{{ $detail->id }}" class="form-label">Quantity</label>
                                            <input type="number" name="quantity" id="quantity_{{ $detail->id }}"
                                                class="form-control" value="{{ $detail->quantity }}" required
                                                min="1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="total_{{ $detail->id }}" class="form-label">Total Price</label>
                                            <input type="text" id="total_{{ $detail->id }}" class="form-control"
                                                readonly value="{{ $detail->total }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const priceInput = document.getElementById('price_{{ $detail->id }}');
                            const quantityInput = document.getElementById('quantity_{{ $detail->id }}');
                            const totalInput = document.getElementById('total_{{ $detail->id }}');

                            function calculateTotal() {
                                const price = parseFloat(priceInput.value) || 0;
                                const quantity = parseInt(quantityInput.value) || 0;
                                const total = price * quantity;
                                totalInput.value = total.toFixed(2);
                            }

                            priceInput.addEventListener('input', calculateTotal);
                            quantityInput.addEventListener('input', calculateTotal);
                        });
                    </script>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Order Price:</strong></td>
                    <td colspan="2" id="totalOrderPrice"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const priceElements = document.querySelectorAll('.price');
            const quantityElements = document.querySelectorAll('.quantity');
            const totalOrderPriceElement = document.getElementById('totalOrderPrice');

            let totalOrderPrice = 0;

            priceElements.forEach((priceElement, index) => {
                const price = parseFloat(priceElement.textContent) || 0;
                const quantity = parseInt(quantityElements[index].textContent) || 0;
                totalOrderPrice += price * quantity;
            });

            totalOrderPriceElement.textContent = totalOrderPrice.toFixed(2);
        });
    </script>
@endsection
