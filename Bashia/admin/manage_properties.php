<?php
include '../db_connection.php';

session_start();

// Fetch properties from database
$sql = "SELECT * FROM properties";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Manage Properties</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPropertyModal">Add Property</button>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Total Rooms</th>
                <th>Available Rooms</th>
                <th>Rental Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['total_rooms'] ?></td>
            <td><?= $row['available_rooms'] ?></td>
            <td>R<?= number_format($row['rental_price'], 2) ?></td>
            <td><?= $row ['description'] ?></td>
            <td><?= $row ['image'] ?></td>
            <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPropertyModal<?= $row['id'] ?>">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <a href="delete_property.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this property?');">
                    <i class="bi bi-trash"></i> Delete
                </a>
            </td>
        </tr>

        <!-- Edit Property Modal -->
        <div class="modal fade" id="editPropertyModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Property</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_property.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="mb-3">
                                <label>Property Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="<?= $row['location'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Total Rooms</label>
                                <input type="number" name="total_rooms" class="form-control" value="<?= $row['total_rooms'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Available Rooms</label>
                                <input type="number" name="available_rooms" class="form-control" value="<?= $row['available_rooms'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Rental Price (ZAR)</label>
                                <input type="text" name="rental_price" class="form-control" value="<?= $row['rental_price'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" required><?= $row['description'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Property Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Property</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</tbody>

    </table>
</div>

<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="add_property.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Total Rooms</label>
                        <input type="number" name="total_rooms" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Available Rooms</label>
                        <input type="number" name="available_rooms" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Rental Price</label>
                        <input type="number" step="0.01" name="rental_price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Property</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
