<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            color: #000;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #306EE8;
            width: 200px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .sidebar h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            margin: 5px 0;
            display: block;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: white;
            color: #306EE8;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .header {
            font-size: 28px;
            margin-bottom: 20px;
            color: #306EE8;
        }

        .content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#dashboard">Dashboard</a>
        <a href="#users">Users</a>
        <a href="#products">Products</a>
        <a href="#transactions">Transactions</a>
        <a href="#logout">Log Out</a>
    </div>

    <div class="main-content">
        <div class="header">Dashboard</div>
        <div class="content">
            <p>Welcome to the admin panel! Use the menu on the left to navigate through the sections.</p>
        </div>
    </div>

    <script>
        // Basic JavaScript for interactions (if needed)
        const links = document.querySelectorAll('.sidebar a');

        links.forEach(link => {
            link.addEventListener('click', () => {
                alert(`Navigating to ${link.textContent} section.`);
            });
        });
    </script>
</body>
</html>