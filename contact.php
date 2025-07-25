<?php 
$pageTitle = "Kontak";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $product = $_POST['product'] ?? '';
    
    include 'includes/db_connect.php';
    
    $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, product, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $name, $email, $phone, $product, $message);
    
    if ($stmt->execute()) {
        $success = "Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.";
    } else {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

    <section class="contact-page">
        <div class="container">
            <h2>Hubungi Kami</h2>
            
            <?php if (isset($success)): ?>
                <div class="alert success">
                    <?php echo $success; ?>
                </div>
            <?php elseif (isset($error)): ?>
                <div class="alert error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Informasi Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Pertanian No. 123, Kabupaten Tani</p>
                    <p><i class="fas fa-phone"></i> +62 812 3456 7890</p>
                    <p><i class="fas fa-envelope"></i> info@tanimakmur.com</p>
                    <p><i class="fas fa-clock"></i> Buka: Senin - Sabtu, 08:00 - 17:00</p>
                </div>
                
                <div class="contact-form">
                    <h3>Kirim Pesan</h3>
                    <form action="contact.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Alamat Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Nomor Telepon" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="product" id="product-field" placeholder="Produk yang diminati (opsional)">
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Pesan Anda" required></textarea>
                        </div>
                        <button type="submit" class="btn">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>