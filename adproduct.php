<?php 
$pageTitle = "Tambah Produk";
include 'includes/header.php'; 
include 'includes/connect.php';

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Handle file upload
    $target_dir = "logo/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File bukan gambar.');</script>";
        $uploadOk = 0;
    }
    
    // Check file size (max 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar (max 2MB).');</script>";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<script>alert('Hanya format JPG, JPEG, PNG & GIF yang diizinkan.');</script>";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Maaf, file Anda tidak terupload.');</script>";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert into database
            $image_name = basename($_FILES["image"]["name"]);
            
            $sql = "INSERT INTO products (name, category, price, description, image) 
                    VALUES ('$name', '$category', '$price', '$description', '$image_name')";
            
            if ($conn->query($sql)) {
                echo "<script>alert('Produk berhasil ditambahkan.'); window.location.href = 'products.php';</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Maaf, terjadi error saat mengupload file.');</script>";
        }
    }
}
?>

<section class="add-product-page">
    <div class="container">
        <h2>Tambah Produk Baru</h2>
        <a href="products.php" class="btn">Kembali ke Daftar Produk</a>
        
        <form action="adproduct.php" method="POST" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="category">Kategori</label>
                <select id="category" name="category" required>
                    <option value="">Pilih Kategori</option>
                    <option value="sayuran">Sayuran</option>
                    <option value="buah">Buah-buahan</option>
                    <option value="obat">obat pertanian</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="description">Deskripsi Produk</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="image">Gambar Produk</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <small>Format: JPG, PNG, JPEG, GIF (max 2MB)</small>
            </div>
            
            <button type="submit" class="btn">Simpan Produk</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>