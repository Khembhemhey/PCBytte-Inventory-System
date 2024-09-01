<!DOCTYPE html>
<html>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "pcbyte_db_new";
    $unitTable = "unit";
    $shipperTable = "shippers";
    $supplierTable = "supplier";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getRowCount($tableName, $conn) {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT GetRowCount(?) as count");
        $stmt->bind_param("s", $tableName);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        $stmt->close();
    
        return $row['count'];
    }
    
    // Example usage
    $unitCount = getRowCount('unit', $conn);
    $shipperCount = getRowCount('shippers', $conn);
    $supplierCount = getRowCount('supplier', $conn);
    
?>
<head>
    <title>PCBYTE - Homepage</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="homepage_css.css?v=p<?php echo time(); ?>">   
</head>
<body>
    <div class="container">
        <?php include('partials/sidebar.php') ?>
        <div class="main-content">
            <h1>Welcome to the Inventory System</h1>
             <div class="menu">
                <div class="box">
                    <h3><i class="fas fa-cubes fa-2x"></i> Total Unit: <?php echo $unitCount; ?></h3>
                </div>
                <div class="box">
                    <h3><i class="fas fa-shipping-fast fa-2x"></i> Total Shipper: <?php echo $shipperCount; ?></h3>
                </div>
                <div class="box">
                    <h3><i class="fas fa-truck fa-2x"></i> Total Supplier: <?php echo $supplierCount; ?></h3>
                </div>
            </div>

            <div class="menu">
                <a href="units.php">Add Products</a> 
                <a href="manage_orders.php">Manage Products</a>
                <a href="customer_orders.php">Orders</a>
                <a href="shippers.php">Manage Shippers</a>
                <a href="suppliers.php">Manage Suppliers</a>
                <a href="transactions.php">View Sales</a>
            </div>
        </div>
    </div>
</body>
</html>
