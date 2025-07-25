<?php 
$pageTitle = "Beranda";
include 'includes/header.php'; 
?>

    <section class="hero">
        <div class="hero-content">
            <h2>Produk Pertanian Berkualitas</h2>
            <p>Kami menyediakan berbagai macam produk pertanian organik yang sehat dan segar</p>
            <a href="products.php" class="btn">Lihat Produk</a>
        </div>
    </section>

    <section class="featured-products">
        <div class="container">
            <h2>Produk Unggulan</h2>
            <div class="products-grid">
                <?php
                include 'includes/connect.php';
                $sql = "SELECT * FROM products WHERE featured=1 LIMIT 4";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<img src="logo/' . $row['image'] . '" alt="' . $row['name'] . '">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p>Rp ' . number_format($row['price'], 0, ',', '.') . ' /buah</p>';
                        echo '<a href="products.php#product-' . $row['id'] . '" class="btn">Detail</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada produk unggulan saat ini.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <h2>Tentang Kami</h2>
                <p>Tani Makmur adalah usaha pertanian keluarga yang berkomitmen untuk menyediakan produk pertanian berkualitas tinggi dengan metode organik dan ramah lingkungan.</p>
                <p>Kami telah beroperasi sejak 2010 dan terus berinovasi untuk memberikan yang terbaik bagi pelanggan kami.</p>
                <a href="about.php" class="btn">Selengkapnya</a>
            </div>
            <div class="about-image">
                <img src="images/farm.jpg" alt="Ladang Pertanian">
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>