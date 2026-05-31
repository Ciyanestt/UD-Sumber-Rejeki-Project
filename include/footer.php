<footer>
        <div class="footer-container">
            <div class="footer-brand">
                <img src="/project itik 2/pictures/logo.png" alt="UD. Sumber Rejeki">
                <span>UD. SUMBER REJEKI</span>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <?php if (
                        isset($_SESSION["role"]) &&
                        $_SESSION["role"] === "admin"
                    ): ?>
                        <li><a href="/project itik 2/product.php">PRODUCT</a></li>
                        <li><a href="/project itik 2/aksesAdmin/admin_ulasan.php">PESAN</a></li>
                        <li><a href="/project itik 2/profil.php">PROFIL SAYA</a></li>
                    <?php else: ?>
                        <li><a href="/project itik 2/index.php">HOME</a></li>
                        <li><a href="/project itik 2/aboutus.php">ABOUT US</a></li>
                        <li><a href="/project itik 2/product.php">PRODUCT</a></li>
                        <li><a href="/project itik 2/mitra.php">MITRA</a></li>
                        <li><a href="/project itik 2/PesanKesan.php">PESAN</a></li>
                        <li><a href="/project itik 2/contact.php">CONTACT US</a></li>
                        <li><a href="/project itik 2/profil.php">PROFIL SAYA</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-info">
                <h4>Informasi Lebih Lanjut</h4>
                <p>Kunjungi media sosial kami untuk update terbaru mengenai produk dan kemitraan.</p>
                <div class="footer-social">
                    <a href="https://www.youtube.com/@Peternakbebekbanyuwangi" target="_blank">  
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Youtube_logo.png" alt="YouTube"> 
                    </a>
                    <a href="https://wa.me/6282271026009" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
                    </a> 
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2026 UD. SUMBER REJEKI. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>