<?php
// index.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiffany & Co | Trang sức sang trọng</title>
    <link rel="stylesheet" href="../css/gioithiu.css">
</head>
<body>
<header>
    <h1>Tiffany & Co.</h1>
    <nav>
        <a href="../index.php">Trang chủ</a>
        <a href="gioithieu.php">Giới thiệu</a>
        <a href="sanpham.php">Sản phẩm</a>
        <a href="datlich.php">Liên hệ</a>
    </nav>
</header>



<section class="hero">
    <p>Biểu tượng của sự tinh tế và sang trọng từ 1837</p>
</section>

<section class="intro fade" id="intro">
    <?php
    echo "
    <h2>Giới thiệu Tiffany & Co.</h2>
    <p>
        Từ những viên kim cương lấp lánh đến những thiết kế thanh lịch, 
        <strong>Tiffany & Co.</strong> là biểu tượng của nghệ thuật chế tác trang sức cao cấp. 
        Mỗi sản phẩm đều mang trong mình câu chuyện về sự tỉ mỉ, tinh tế và phong cách vượt thời gian.
    </p>";
    ?>
</section>

<section class="origin fade" id="origin">
    <?php
    echo "
    <div class='origin-container'>
        <div class='origin-text'>
            <h2>Nguồn gốc & Giá trị thương hiệu</h2>
            <p>
                Được thành lập vào năm 1837 tại thành phố New York bởi <strong>Charles Lewis Tiffany</strong> và <strong>John B. Young</strong>, 
                Tiffany & Co. nhanh chóng trở thành biểu tượng của sự sang trọng và đẳng cấp trong ngành trang sức thế giới.
            </p>
            <p>
                Những thiết kế của Tiffany luôn được lấy cảm hứng từ <em>vẻ đẹp tự nhiên, sự thuần khiết và tinh thần tự do</em>. 
                Từng viên kim cương, từng đường cắt đều được chế tác tỉ mỉ bởi những nghệ nhân hàng đầu, thể hiện niềm đam mê hoàn mỹ và tình yêu nghệ thuật.
            </p>
            <p>
                Sắc xanh đặc trưng <span class='tiffany-blue'>Tiffany Blue</span> đã trở thành biểu tượng vượt thời gian – gợi nhắc đến hy vọng, sự thanh lịch và những khoảnh khắc vĩnh cửu. 
                Đó không chỉ là màu sắc, mà là cảm xúc, là dấu ấn của tình yêu được trân trọng qua nhiều thế hệ.
            </p>
        </div>
        <div class='origin-img'>
            <img src='../image/chude.jpg'>
        </div>
    </div>
    ";
    ?>
</section>
<h2>Sản phẩm nổi bật</h2>

<section class="products" id="products" style="display:flex;justify-content:center;gap:30px;margin:50px 66px;">
    <?php
    $products = [
        [
            "img" => "../image/dm1.jpg",
            "name" => "Dây chuyền kim cương",
            "desc" => "Thiết kế cổ điển sang trọng, tỏa sáng mọi ánh nhìn."
        ],
        [
            "img" => "../image/dm2.jpg",
            "name" => "Nhẫn Tiffany Blue",
            "desc" => "Sắc xanh biểu tượng – vĩnh cửu và thanh lịch."
        ],
        [
            "img" => "../image/dm3.jpg",
            "name" => "Bông tai bạc cao cấp",
            "desc" => "Vẻ đẹp tinh tế cho mọi dịp đặc biệt."
        ],
        [
            "img" => "../image/dm4.jpg",
            "name" => "Đồng hồ kim cương cao cấp",
            "desc" => "Vẻ đẹp sang trọng đẳng cấp."
        ]
    ];

    foreach ($products as $p) {
        echo "
        <div style='text-align:center;width:250px;background:#fff;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.1);overflow:hidden;'>
            <img src='{$p['img']}' alt='{$p['name']}' style='width:100%;height:250px;object-fit:cover;'>
            <h3 style='margin:10px 0;color:#2c3e50;font-family:serif;'>{$p['name']}</h3>
            <p style='padding:0 15px 15px;color:#555;font-size:14px;'>{$p['desc']}</p>
        </div>
        ";
    }
    ?>
</section>


<footer id="contact">
    <p>© 2025 Tiffany & Co. | Liên hệ: info@tiffany.com</p>
</footer>


<script src="script.js">

    // Nhạc nền
const music = document.getElementById('bg-music');
const toggle = document.getElementById('music-toggle');
let playing = false;
toggle.addEventListener('click', () => {
    if (!playing) {
        music.play();
        toggle.textContent = "🔇 Tắt nhạc";
        playing = true;
    } else {
        music.pause();
        toggle.textContent = "🎵 Bật nhạc";
        playing = false;
    }
});

// Hiệu ứng ánh sáng lấp lánh
const canvas = document.getElementById('sparkle-bg');
const ctx = canvas.getContext('2d');
let w, h, particles = [];

function resize() {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
}
window.addEventListener('resize', resize);
resize();

function createParticles() {
    particles = [];
    for (let i = 0; i < 120; i++) {
        particles.push({
            x: Math.random() * w,
            y: Math.random() * h,
            r: Math.random() * 1.5 + 0.5,
            dx: (Math.random() - 0.5) * 0.4,
            dy: (Math.random() - 0.5) * 0.4,
            alpha: Math.random(),
            da: (Math.random() - 0.5) * 0.02
        });
    }
}
function drawParticles() {
    ctx.clearRect(0, 0, w, h);
    particles.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255,255,255,${p.alpha})`;
        ctx.fill();

        p.x += p.dx;
        p.y += p.dy;
        p.alpha += p.da;
        if (p.alpha <= 0 || p.alpha >= 1) p.da *= -1;
        if (p.x < 0 || p.x > w) p.dx *= -1;
        if (p.y < 0 || p.y > h) p.dy *= -1;
    });
    requestAnimationFrame(drawParticles);
}
createParticles();
drawParticles();



</script>
</body>
</html>
