<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
    <link rel="stylesheet" href="assets/admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <style>
        /* Your existing CSS for sidebar, main content, table, and modal here */
        h2 {
    color: black;
}

       /* Styling untuk form filter */
.filter-form {
    display: flex;
    align-items: center;
    gap: 15px;
    max-width: 100%; /* Memungkinkan form untuk memanjang sepanjang lebar kontainer */
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: auto; /* Pastikan form memanjang sesuai ukuran kontainer */
}

.filter-form label {
    font-weight: bold;
    margin-right: 10px;
    font-size: 14px;
}

.filter-form select,
.filter-form input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    width: 200px; /* Memberikan lebar tetap pada input dan select */
}

.filter-form button {
    padding: 8px 15px;
    border: none;
    background-color: #738A6E;
    color: white;
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
    margin-left: 10px;
    margin-bottom: 0px;
}

.filter-form button:hover {
    background-color: #45a049;
}
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <ul>
        <li><a href="{{ url('/usermanagement') }}"><i class="fas fa-users"></i> User</a></li>
        <li><a href="{{ url('/products') }}"><i class="fas fa-box"></i> Product</a></li>
        <li><a href="{{ url('/categories') }}"><i class="fas fa-tags"></i> Category</a></li>
        <li><a href="{{ url('/orders') }}"><i class="fas fa-shopping-cart"></i> Transaction</a></li>
        <li><a href="{{ url('/PesananManagement') }}"><i class="fas fa-clipboard-list"></i> Order</a></li>
        <li><a href="{{ url('/blogs') }}"><i class="fa-solid fa-newspaper"></i> Blog</a></li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <button id="toggleSidebarBtn">☰</button>
        <div id="orders" class="content-section">
            <h2>Orders Management</h2>
            <button id="addOrderBtn">Add New Order</button>
            <div class="filter-form">
    <form action="{{ route('orders.index') }}" method="GET">
        <label for="filter-email">Email:</label>
        <input type="email" id="filter-email" name="email" value="{{ request('email') }}">

        <label for="filter-recipient-name">Recipient Name:</label>
        <input type="text" id="filter-recipient-name" name="recipient_name" value="{{ request('recipient_name') }}">

        <label for="filter-payment-status">Payment Status:</label>
        <select id="filter-payment-status" name="payment_status">
            <option value="">All</option>
            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>Success</option>
            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>

        <button type="submit">Filter</button>
    </form>
</div>

            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Recipient Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Subtotal</th>
                        <th>Shipping Cost</th>
                        <th>Total</th>
                        <th>Payment Status</th> <!-- Added Payment Status column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->user_id }}</td>
                        <td>{{ $order->recipient_name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->message }}</td>
                        <td>{{ $order->subtotal }}</td>
                        <td>{{ $order->shipping_cost }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->payment_status }}</td> <!-- Display Payment Status -->
                        <td class="actions">
                            <button class="edit" 
                                    data-id="{{ $order->id }}" 
                                    data-user-id="{{ $order->user_id }}"
                                    data-recipient-name="{{ $order->recipient_name }}" 
                                    data-email="{{ $order->email }}" 
                                    data-message="{{ $order->message }}" 
                                    data-subtotal="{{ $order->subtotal }}" 
                                    data-shipping-cost="{{ $order->shipping_cost }}" 
                                    data-total="{{ $order->total }}"
                                    data-payment-status="{{ $order->payment_status }}"> <!-- Added Payment Status data -->
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add Order -->
    <div id="addOrderModal" class="modal">
        <div class="modal-content">
            <button class="close-btn">&times;</button>
            <form id="addOrderForm" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="add-user-id">User ID:</label>
                    <input type="text" id="add-user-id" name="user_id" required>
                </div>
                <div class="form-group">
                    <label for="add-recipient-name">Recipient Name:</label>
                    <input type="text" id="add-recipient-name" name="recipient_name" required>
                </div>
                <div class="form-group">
                    <label for="add-email">Email:</label>
                    <input type="email" id="add-email" name="email">
                </div>
                <div class="form-group">
                    <label for="add-message">Message:</label>
                    <textarea id="add-message" name="message"></textarea>
                </div>
                <div class="form-group">
                    <label for="add-subtotal">Subtotal:</label>
                    <input type="number" id="add-subtotal" name="subtotal" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="add-shipping-cost">Shipping Cost:</label>
                    <input type="number" id="add-shipping-cost" name="shipping_cost" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="add-total">Total:</label>
                    <input type="number" id="add-total" name="total" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="add-payment-status">Payment Status:</label>
                    <select id="add-payment-status" name="payment_status">
                        <option value="pending">Pending</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <button type="submit">Add Order</button>
            </form>
        </div>
    </div>

    <!-- Modal for Edit Order -->
    <div id="editOrderModal" class="modal">
        <div class="modal-content">
            <button class="close-btn">&times;</button>
            <form id="editOrderForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit-user-id">User ID:</label>
                    <input type="text" id="edit-user-id" name="user_id" required>
                </div>
                <div class="form-group">
                    <label for="edit-recipient-name">Recipient Name:</label>
                    <input type="text" id="edit-recipient-name" name="recipient_name" required>
                </div>
                <div class="form-group">
                    <label for="edit-email">Email:</label>
                    <input type="email" id="edit-email" name="email">
                </div>
                <div class="form-group">
                    <label for="edit-message">Message:</label>
                    <textarea id="edit-message" name="message"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-subtotal">Subtotal:</label>
                    <input type="number" id="edit-subtotal" name="subtotal" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit-shipping-cost">Shipping Cost:</label>
                    <input type="number" id="edit-shipping-cost" name="shipping_cost" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit-total">Total:</label>
                    <input type="number" id="edit-total" name="total" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit-payment-status">Payment Status:</label>
                    <select id="edit-payment-status" name="payment_status">
                        <option value="pending">Pending</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <button type="submit">Update Order</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add Order Modal
            const addOrderBtn = document.getElementById('addOrderBtn');
            const addOrderModal = document.getElementById('addOrderModal');
            const addOrderForm = document.getElementById('addOrderForm');
            const closeAddOrderBtn = addOrderModal.querySelector('.close-btn');

            addOrderBtn.addEventListener('click', function () {
                addOrderModal.style.display = 'block';
            });

            closeAddOrderBtn.addEventListener('click', function () {
                addOrderModal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target === addOrderModal) {
                    addOrderModal.style.display = 'none';
                }
            });

            // Edit Order Modal
            const editOrderModal = document.getElementById('editOrderModal');
            const editOrderForm = document.getElementById('editOrderForm');
            const closeEditOrderBtn = editOrderModal.querySelector('.close-btn');

            document.querySelectorAll('.edit').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = btn.getAttribute('data-id');
                    document.getElementById('edit-user-id').value = btn.getAttribute('data-user-id');
                    document.getElementById('edit-recipient-name').value = btn.getAttribute('data-recipient-name');
                    document.getElementById('edit-email').value = btn.getAttribute('data-email');
                    document.getElementById('edit-message').value = btn.getAttribute('data-message');
                    document.getElementById('edit-subtotal').value = btn.getAttribute('data-subtotal');
                    document.getElementById('edit-shipping-cost').value = btn.getAttribute('data-shipping-cost');
                    document.getElementById('edit-total').value = btn.getAttribute('data-total');
                    document.getElementById('edit-payment-status').value = btn.getAttribute('data-payment-status');

                    editOrderForm.action = `/orders/${id}`;
                    editOrderModal.style.display = 'block';
                });
            });

            closeEditOrderBtn.addEventListener('click', function () {
                editOrderModal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target === editOrderModal) {
                    editOrderModal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
