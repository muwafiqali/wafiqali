<?php 
$pageTitle = "Produk";
include 'includes/header.php'; 
?>

    <section class="products-page">
        <div class="container">
            <h2>Produk Kami</h2>
            <a href="adproduct.php" class="btn" >Tambah Produk</a>
            <div class="product-filters">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="obat pertanian">obat pertanian</button>
                <button class="filter-btn" data-filter="buah">Buah-buahan</button>
                <button class="filter-btn" data-filter="obat pertanian">obat pertanian</button>
            </div>
    
            <div class="products-grid">
                <?php
                include 'includes/connect.php';
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-card" data-category="' . $row['category'] . '" id="product-' . $row['id'] . '">';
                        echo '<img src="logo/' . $row['image'] . '" alt="' . $row['name'] . '">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p class="product-category">' . ucfirst($row['category']) . '</p>';
                        echo '<p class="product-price">Rp ' . number_format($row['price'], 0, ',', '.') . ' /buah</p>';
                        echo '<p class="product-desc">' . $row['description'] . '</p>';
                       echo '<a href="edit_product.php?id=' . $row['id'] . '" class="btn edit-btn">Ubah Produk</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada produk saat ini.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>