// Script tương tác cơ bản cho website trang sức

document.addEventListener("DOMContentLoaded", () => {
  // Lấy dữ liệu sản phẩm ẩn trong template
  const scripts = document.querySelectorAll('#product-data script[type="application/json"]');
  const products = {};
  scripts.forEach(s => {
    products[s.dataset.id] = JSON.parse(s.textContent);
  });
  // script.js - minimal JS: smooth scroll for anchor links (optional)
document.addEventListener('click', function(e){
  if(e.target.matches('.shop-btn')){
    // example: smooth scroll to top or to product section
    // if links are internal anchors, let browser handle them.
    // Here we just prevent default and do a gentle highlight (demo)
    // REMOVE this block if you use real product links.
    e.preventDefault();
    window.scrollTo({top:0, behavior:'smooth'});
    e.target.style.opacity = 0.6;
    setTimeout(()=> e.target.style.opacity = '', 300);
  }
});

});
