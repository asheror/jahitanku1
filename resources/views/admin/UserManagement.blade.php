<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    background-color: #8EA58C;
}

/* Responsive: Jika layar kecil, form akan ditampilkan secara vertikal */
@media (max-width: 768px) {
    .filter-form {
        flex-direction: column;
        align-items: flex-start;
    }

    .filter-form label {
        margin-bottom: 5px;
    }
}

/* Styling untuk tombol Add */
.add-button {
    display: inline-block;
    padding: 8px 15px;
    background-color: #121114ff;
    color: white;
    font-size: 14px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s;
    margin-top: 20px;
}

.add-button:hover {
    background-color: #121114ff;
}


        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="logo">
        <h2>Admin Panel</h2>
    </div>
    <ul>
    <li><li><a href="{{ url('/usermanagement') }}"><i class="fas fa-users"></i> User</a></li>
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
</div>


    <div class="main-content" id="mainContent">
        <button id="toggleSidebarBtn">☰</button>
        <div id="user-management" class="content-section">
            <h2>User Management</h2>
            <button id="addUserBtn">Add New User</button>
            <!-- Filter and Search Form -->
    <form action="{{ route('usermanagement.index') }}" method="GET" class="filter-form">
        <label for="role">Filter by Role:</label>
        <select name="role" id="role">
            <option value="">All</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <label for="email">Search by Email:</label>
        <input type="text" name="email" id="email" value="{{ request('email') }}" placeholder="Enter email...">

        <button type="submit">Apply</button>
    </form>
            <table>
            <thead>
    <tr>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Role</th> <!-- Tambahkan kolom Role -->
        <th>Password</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone_number }}</td>
        <td>{{ $user->address }}</td>
        <td>{{ ucfirst($user->role) }}</td> <!-- Tampilkan role -->
        <td>••••••••</td>
        <td class="actions">
            <button class="edit" 
                    data-id="{{ $user->id }}" 
                    data-email="{{ $user->email }}" 
                    data-phone="{{ $user->phone_number }}" 
                    data-address="{{ $user->address }}" 
                    data-role="{{ $user->role }}" 
                    data-registration-date="{{ $user->registration_date }}">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
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

    <!-- Modal for Add User -->
    <div id="addUserModal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="add-email">Email:</label>
                <input type="email" id="add-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="add-password">Password:</label>
                <input type="password" id="add-password" name="password" required>
            </div>
            <div class="form-group">
                <label for="add-phone">Phone Number:</label>
                <input type="text" id="add-phone" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="add-address">Address:</label>
                <input type="text" id="add-address" name="address">
            </div>
            <div class="form-group">
                <label for="add-registration-date">Registration Date:</label>
                <input type="date" id="add-registration-date" name="registration_date" required>
            </div>
            <div class="form-group">
    <label for="add-role">Role:</label>
    <select id="add-role" name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
</div>

            <button type="submit">Add User</button>
        </form>
    </div>
</div>

        <!-- Modal for Delete Confirmation -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h3>Are you sure you want to delete this user?</h3>
        <form id="deleteUserForm" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-confirm-btn">Yes, Delete</button>
            <button type="button" class="cancel-btn">Cancel</button>
        </form>
    </div>
</div>


   <!-- Modal for Edit User -->
   <div id="editUserModal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="edit-password">Password (leave blank to keep current password):</label>
                <input type="password" id="edit-password" name="password">
            </div>
            <div class="form-group">
                <label for="edit-phone">Phone Number:</label>
                <input type="text" id="edit-phone" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="edit-address">Address:</label>
                <input type="text" id="edit-address" name="address">
            </div>
            <div class="form-group">
                <label for="edit-registration-date">Registration Date:</label>
                <input type="date" id="edit-registration-date" name="registration_date" required>
            </div>
            <div class="form-group">
    <label for="edit-role">Role:</label>
    <select id="edit-role" name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
</div>

            <input type="hidden" id="edit-user-id" name="user_id">
            <button type="submit">Edit User</button>
        </form>
    </div>
</div>



    <script>
        // Open modal for adding a new user
        document.getElementById('addUserBtn').addEventListener('click', function() {
            document.getElementById('addUserModal').style.display = 'block';
            document.getElementById('addUserForm').reset();
        });

       // Open modal for editing a user
       document.querySelectorAll('.edit').forEach(function(button) {
    button.addEventListener('click', function() {
        var userId = this.getAttribute('data-id');
        var userEmail = this.getAttribute('data-email');
        var userPhone = this.getAttribute('data-phone');
        var userAddress = this.getAttribute('data-address');
        var registrationDate = this.getAttribute('data-registration-date');
        var userRole = this.getAttribute('data-role'); // Ambil role dari button

        document.getElementById('edit-email').value = userEmail;
        document.getElementById('edit-phone').value = userPhone;
        document.getElementById('edit-address').value = userAddress;
        document.getElementById('edit-registration-date').value = registrationDate;
        document.getElementById('edit-role').value = userRole; // Set nilai role
        document.getElementById('edit-user-id').value = userId;

        document.getElementById('editUserForm').action = "{{ url('users') }}/" + userId;
        document.getElementById('editUserModal').style.display = 'block';
    });
});





        // Close modal when clicking outside of the modal content
    window.addEventListener('click', function(event) {
        var addModal = document.getElementById('addUserModal');
        var editModal = document.getElementById('editUserModal');
        if (event.target == addModal) {
            addModal.style.display = 'none';
        } else if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    });

    // Close modal when clicking the close button
    document.querySelectorAll('.close-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });

    // Open delete confirmation modal
document.querySelectorAll('.delete').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission
        var userId = this.closest('form').getAttribute('action').split('/').pop(); // Get user ID from form action

        // Set the form action dynamically for deletion
        document.getElementById('deleteUserForm').action = "/users/" + userId;

        // Show the modal
        document.getElementById('deleteUserModal').style.display = 'block';
    });
});

// Close modal when clicking outside of the modal content
window.addEventListener('click', function(event) {
    var deleteModal = document.getElementById('deleteUserModal');
    if (event.target == deleteModal) {
        deleteModal.style.display = 'none';
    }
});

// Close modal when clicking the close button
document.querySelectorAll('.close-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
    });
});

// Cancel delete action
document.querySelector('.cancel-btn').addEventListener('click', function() {
    document.getElementById('deleteUserModal').style.display = 'none';
});



        // Toggle sidebar
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('collapsed');
        this.classList.toggle('collapsed');
    });

    // Tambahkan fungsi untuk menerapkan filter saat elemen dipilih atau diubah
document.getElementById('role').addEventListener('change', function () {
    document.querySelector('form button[type="submit"]').click(); // Apply filter otomatis
});

document.getElementById('email').addEventListener('keyup', function (e) {
    if (e.key === 'Enter') {
        document.querySelector('form button[type="submit"]').click(); // Apply filter saat tekan Enter
    }
});

    </script>
</body>
</html>