<?php
$pageTitle = "Edit Produk";
include 'includes/header.php';

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

include 'includes/connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);
    
    // Handle image upload
    $image_update = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "logo/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $new_image = uniqid() . '.' . $imageFileType;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $new_image)) {
                $image_update = ", image = '$new_image'";
                
                // Delete old image (optional)
                $old_image = $conn->query("SELECT image FROM products WHERE id = $product_id")->fetch_assoc()['image'];
                if ($old_image != 'default-product.jpg') {
                    @unlink($target_dir . $old_image);
                }
            }
        }
    }
    
    $sql = "UPDATE products SET 
            name = '$name',
            description = '$description',
            price = '$price',
            category = '$category'
            $image_update
            WHERE id = $product_id";
    
    if ($conn->query($sql)) {
        $success = "Produk berhasil diperbarui!";
    } else {
        $error = "Gagal memperbarui produk: " . $conn->error;
    }
}

// Get product data
$product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();

if (!$product) {
    header("Location: products.php");
    exit();
}

$conn->close();
?>

<section class="edit-product-page">
    <div class="container">
        <h2>Edit Produk</h2>
        
        <a href="products.php" class="btn back-btn">Kembali ke Daftar Produk</a>
        
        <?php if (isset($success)): ?>
            <div class="alert success">
                <?php echo $success; ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="edit-product-form">
            <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nama Produk:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Harga (Rp):</label>
                    <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" min="0" step="100" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Kategori:</label>
                    <select id="category" name="category" required>
                        <option value="sayuran" <?php echo $product['category'] == 'sayuran' ? 'selected' : ''; ?>>Sayuran</option>
                        <option value="buah" <?php echo $product['category'] == 'buah' ? 'selected' : ''; ?>>Buah-buahan</option>
                        <option value="obat pertanian" <?php echo $product['category'] == 'obat pertanian' ? 'selected' : ''; ?>>obat pertanian</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar Produk:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small>Biarkan kosong jika tidak ingin mengubah gambar</small>
                    <?php if ($product['image']): ?>
                        <div class="current-image">
                            <p>Gambar Saat Ini:</p>
                            <img src="images/<?php echo $product['image']; ?>" alt="Current Product Image" style="max-width: 200px;">
                        </div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn update-btn">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>