<div class="sidebar">
    <h2>Inventory System</h2>
    <ul>
        <li class="active" id="dashboard">
            <i class="fa-solid fa-house"></i>
            <a href="homepage.php">Home</a>
        </li>
        <li id="add-units">
            <i class="fas fa-plus"></i>
            <a href="units.php">Add Products</a>
        </li>
    <!--    <li id="view-inventory">
            <i class="fas fa-list"></i>
            <a href="view_inventory.php">View Inventory</a>
        </li> -->
        <li id="manage-orders">
                <i class="fa-solid fa-pen-to-square"></i>
            <a href="manage_orders.php">Manage Inventory</a>
        </li>
        <li id="customer-orders">
            <i class="fa-solid fa-cart-shopping"></i>
            <a href="customer_orders.php">Customer Orders</a>
        </li> 
        <li id="suppliers">
            <i class="fa-solid fa-boxes-stacked"></i>
            <a href="suppliers.php">Suppliers</a>
        </li>
        <li id="shippers">
            <i class="fa-solid fa-truck-moving"></i>
            <a href="shippers.php">Shippers</a>
        </li>
        <li id="transactions">
        <i class="fa-solid fa-file-invoice"></i>
            <a href="transactions.php">Sales</a>
        </li>
    <!--    <li id="users">
            <i class="fa-solid fa-user"></i>
            <a href="users.php">Users</a>
        </li> -->
        <li id="logout">
            <i class="fas fa-sign-out-alt"></i>
            <a href="includes/logout.php">Logout</a>
        </li>
    </ul>
</div>

<style>
  .sidebar {
    background-color: #7393B3;
    transition: background-color 0.3s;
  }

  .menu a {
    transition: color 0.3s;
  }

  .menu a:hover {
    color: #6567F6;
  }
</style>

