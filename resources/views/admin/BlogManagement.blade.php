<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Product Management</title>
    <link rel="stylesheet" href="assets/admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
/* Your existing CSS for sidebar, main content, table, and modal here */
<style>
/* Your existing CSS for sidebar, main content, table, and modal here */
h2 {
    color: black;
    text-decoration: seashell;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    align-items: end;
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
    background-color: #ad8572ff;
}
        
        .pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.pagination a {
    text-decoration: none;
    color: #bfb1a5ff;
    padding: 8px 16px;
    border: 1px solid #bfb1a5ff;
    border-radius: 4px;
}

.pagination .disabled {
    color: #ccc;
    padding: 8px 16px;
}

.pagination span {
    margin: 0 10px;
}

        .product-description {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 200px; /* Anda bisa menyesuaikan lebar ini */
            display: inline-block;
        }

        .read-more {
        color: #306EE8; /* Warna biru */
        cursor: pointer;
        text-decoration: underline;
    }

        .full-description {
            display: none; /* Sembunyikan deskripsi lengkap secara default */
        }

        .filter-sort {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
}
.filter-sort form select,
.filter-sort form input[type="text"] {
    padding: 8px;
    font-size: 14px;
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
        <div id="products" class="content-section">
            <h2>Blog Management</h2>
            <button id="addProductBtn">Add New Content</button>
            <div class="filter-section">
    <form action="{{ route('products.index') }}" method="GET" class="filter-form">
        <label for="sort">Sort By: </label>
        <select name="sort" id="sort">
            <option value="newest">Newest</option>
            <option value="oldest">Latest</option>
        </select>

        

        <label for="name"> title:</label>
        <input type="text" name="name" id="name" value="" placeholder="">

        <button type="submit">Apply</button>
    </form>
</div>

            <!-- Tabel Produk -->
            <table>
    <thead>
        <tr>
            <th>Blog ID</th>
            <th>Title</th>
            <th>Photo</th>
            <th>Blog content</th>
            <th>View</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
        <tr>
            <td>{{ $blog->id }}</td>
            <td>{{ $blog->judul }}</td>
            <td>
                <img src="{{ asset('storage/' . $blog->gambar) }}" alt="Gambar Blog" style="width: 100px; height: auto;">
            </td>
            <td>{{ Str::limit($blog->isi_blog, 100) }}</td>
            <td>{{ $blog->view }}</td>
            <td class="actions">
            <button class="edit" 
        data-id="{{ $blog->id }}" 
        data-judul="{{ $blog->judul }}" 
        data-isi-blog="{{ $blog->isi_blog }}" 
        data-gambar="{{ asset('storage/' . $blog->gambar) }}">
    <i class="fas fa-pencil-alt"></i>
</button>



                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Tambahkan navigasi pagination -->



        </div>
    </div>

    <!-- Modal for Add Blog -->
<div id="addBlogModal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
            <div class="form-group">
                <label for="add-judul">Judul:</label>
                <input type="text" id="add-judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="add-gambar">Gambar:</label>
                <input type="file" id="add-gambar" name="gambar" accept="image/*">
            </div>
            <div class="form-group">
                <label for="add-isi-blog">Isi Blog:</label>
                <textarea id="add-isi-blog" name="isi_blog" required></textarea>
            </div>
            <button type="submit">Add Blog</button>
        </form>
    </div>
</div>

<!-- Modal for Edit Blog -->
<div id="editBlogModal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <form id="editBlogForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-judul">Judul:</label>
                <input type="text" id="edit-judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="edit-gambar">Gambar:</label>
                <input type="file" id="edit-gambar" name="gambar" accept="image/*">
                <img id="preview-gambar" src="" alt="Preview" style="max-width: 100px; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="edit-isi-blog">Isi Blog:</label>
                <textarea id="edit-isi-blog" name="isi_blog" required></textarea>
            </div>
            <input type="hidden" id="edit-blog-id" name="id">
            <button type="submit">Edit Blog</button>
        </form>
    </div>
</div>


<script>
   document.addEventListener("DOMContentLoaded", function () {
    const editBlogModal = document.getElementById("editBlogModal");
    const addBlogModal = document.getElementById("addBlogModal");

    const editButtons = document.querySelectorAll(".edit");
    const addProductBtn = document.getElementById("addProductBtn");
    const closeModalButtons = document.querySelectorAll(".close-btn");

    // Fungsi untuk membuka modal
    const openModal = (modal) => modal.style.display = "block";

    // Fungsi untuk menutup modal
    const closeModal = (modal) => modal.style.display = "none";

    // Buka modal tambah blog
    addProductBtn.addEventListener("click", () => openModal(addBlogModal));

    // Tutup modal
    closeModalButtons.forEach(button => {
        button.addEventListener("click", function () {
            const modal = button.closest(".modal");
            closeModal(modal);
        });
    });

    // Buka modal edit blog
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const blogId = button.getAttribute("data-id");
            const blogTitle = button.getAttribute("data-judul");
            const blogContent = button.getAttribute("data-isi-blog");
            const blogImage = button.getAttribute("data-gambar");

            // Isi data form modal
            document.getElementById("edit-judul").value = blogTitle;
            document.getElementById("edit-isi-blog").value = blogContent;
            document.getElementById("edit-blog-id").value = blogId;

            // Preview gambar jika ada
            const previewImage = document.getElementById("preview-gambar");
            if (blogImage) {
                previewImage.src = blogImage;
                previewImage.style.display = "block";
            } else {
                previewImage.style.display = "none";
            }

            // Update action form untuk update blog
            const editForm = document.getElementById("editBlogForm");
            editForm.action = `/blogs/${blogId}`;

            openModal(editBlogModal);
        });
    });

    // Tutup modal jika klik di luar modal
    window.addEventListener("click", function (event) {
        if (event.target.classList.contains("modal")) {
            closeModal(event.target);
        }
    });
});

</script>


</body>
</html>