<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sổ Bán Hàng - Trang chủ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}" />

</head>
<body>
{{-- Header --}}
  <header class="home-header">
    <div class="home-logo">
      <img src="{{ asset('images/logo-sobanhang.svg') }}" alt="SoBanHang Logo">
    </div>
    <nav class="home-nav">
      <a href="#">Sản phẩm</a>
      <a href="#">Giải pháp</a>
      <a href="#">Bảng giá</a>
      <a href="#">Blog</a>
      <a href="#">Về chúng tôi</a>
    </nav>
    <div class="home-actions">
      <a href="/admin/login" class="home-btn-login">Đăng nhập</a>
      <a href="/admin/register" class="home-btn-register">Đăng ký</a>
    </div>
  </header>
{{-- Home Hero --}}
  <section class="home-hero">
    <div class="home-hero-text">
      <h1 class="home-hero-title">Bán hàng thông minh,<br>doanh thu bứt phá</h1>
      <p class="home-hero-subtitle">
        Quản lý kinh doanh dễ dàng, tăng doanh thu qua kênh bán trực tuyến và tiếp cận dịch vụ tài chính toàn diện
      </p>
      <ul class="home-list">
        <li><i class="fas fa-check-circle"></i> 50+ tính năng trên 1 chiếc điện thoại</li>
        <li><i class="fas fa-check-circle"></i> Thành thạo sau 5 phút làm quen</li>
        <li><i class="fas fa-check-circle"></i> Không cần đầu tư thêm thiết bị</li>
      </ul>
      <div class="home-cta-buttons">
        <a href="#" class="home-btn-green">Đăng ký ngay</a>
        <div class="home-store-buttons">
          <img src="{{ asset('images/appstore.png') }}" alt="App Store">
          <img src="{{ asset('images/googleplay.png') }}" alt="Google Play">
        </div>
      </div>
    </div>
    <div class="home-hero-image">
      <img src="{{ asset('images/home-pic.png') }}" alt="Ứng dụng Sổ Bán Hàng">
    </div>
  </section>
{{-- Home FeatureFeature --}}
  <section class="home-feature">
  <div class="home-feature-left">
    <img src="{{ asset('images/multichannel.png') }}" alt="Multichannel Selling" class="home-feature-image">
  </div>
  <div class="home-feature-right">
    <span class="home-feature-label">TÍNH NĂNG</span>
    <h2 class="home-feature-title">Mở rộng <span class="highlight">đa kênh</span></h2>

    <div class="home-feature-item">
      <h3>Bán hàng online</h3>
      <p>Tạo website, catalog bán hàng chuyên nghiệp chỉ trong 2 phút trên di động</p>
    </div>

    <div class="home-feature-item">
      <h3>Kết nối sàn TMĐT</h3>
      <p>Cập nhật tồn kho, giá bán trên Shopee, TiktokShop, Lazada và xuất hóa đơn tự động</p>
    </div>

    <div class="home-feature-item">
      <h3>Kết nối Facebook, Zalo OA</h3>
      <p>Tiếp nhận chăm sóc khách hàng và tăng nhận diện thương hiệu</p>
    </div>

    <div class="home-feature-item">
      <h3>Tích hợp đa kênh</h3>
      <p>Đồng bộ thông tin và đơn hàng từ tất cả các kênh trên một nền tảng duy nhất</p>
    </div>

    <a href="#" class="home-btn-green">Đăng ký ngay</a>
  </div>
</section>
{{-- Home Debt --}}
<section class="home-debt">
  <div class="home-debt-left">
    <span class="home-feature-label">TÍNH NĂNG</span>
    <h2 class="home-feature-title">Quản lý <span class="highlight">lãi lỗ – công nợ</span></h2>

    <div class="home-feature-item">
      <h3>Nắm rõ doanh thu, chi phí bán hàng</h3>
      <p>Tạo website, catalog bán hàng chuyên nghiệp chỉ trong 2 phút trên di động</p>
    </div>

    <div class="home-feature-item">
      <h3>Trợ lý AI phân tích lãi lỗ thông minh</h3>
      <p>Theo dõi hiệu quả, chính xác, giúp tối ưu tài chính</p>
    </div>

    <div class="home-feature-item">
      <h3>Thu hồi công nợ</h3>
      <p>Theo dõi và tự động gửi nhắc nợ đến khách hàng, thu tiền về nhanh chóng</p>
    </div>

    <div class="home-feature-item">
      <h3>Đối soát tự động</h3>
      <p>Tích hợp đối soát với tài khoản cá nhân không cần tải sao kê ngân hàng</p>
    </div>

    <div class="home-feature-item">
      <h3>Thông báo tiền về qua loa tiện lợi</h3>
      <p>Kết nối dễ dàng, biết trạng thái thanh toán mà không cần kiểm tra điện thoại</p>
    </div>

    <a href="#" class="home-btn-green">Đăng ký ngay</a>
  </div>

  <div class="home-debt-right">
    <img src="{{ asset('images/debt-management.png') }}" alt="Debt Management" class="home-debt-image">
  </div>
</section>
{{-- More Feature --}}
<section class="home-more-features">
  <h2 class="home-more-title">Nhiều tính năng khác để hỗ trợ <u>chủ kinh doanh</u></h2>

  <div class="home-more-grid">
    <div class="feature-box">
      <img src="{{ asset('images/icons/tich-diem.jpeg') }}" alt="Tích điểm khách hàng">
      <h3>Tích điểm khách hàng</h3>
      <p>Giữ chân khách hàng, tăng trưởng doanh thu</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/thiet-bi.jpeg') }}" alt="Kết nối thiết bị">
      <h3>Kết nối thiết bị</h3>
      <p>Hỗ trợ in hóa đơn, quét mã, in tem món, in bếp</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/quan-ly-ca.jpeg') }}" alt="Quản lý ca">
      <h3>Quản lý ca</h3>
      <p>Điều phối nhân viên, kiểm tra hiệu suất ca làm</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/tem-ma-vach.jpeg') }}" alt="In tem mã vạch">
      <h3>In tem mã vạch</h3>
      <p>Quản lý hàng hóa chính xác, tránh thất thoát</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/dat-ban.jpeg') }}" alt="Đặt bàn">
      <h3>Đặt bàn</h3>
      <p>Tăng doanh thu giờ cao điểm, tránh lãng phí chỗ</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/khuyen-mai.jpeg') }}" alt="Khuyến mãi">
      <h3>Khuyến mãi</h3>
      <p>Thu hút khách hàng mới, kích thích chi tiêu</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/quan-ly-kho.jpeg') }}" alt="Quản lý kho">
      <h3>Quản lý kho</h3>
      <p>Giảm tồn kho dư thừa, tiết kiệm chi phí lưu kho</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/icons/so-no.jpeg') }}" alt="Sổ nợ">
      <h3>Sổ nợ</h3>
      <p>Nhắc nợ tự động, thu hồi nhanh, tránh thất thoát</p>
    </div>
  </div>
</section>

{{-- Footer --}}
{{-- <footer class="home-footer">
  <div class="home-footer-top">
    <div class="home-company-info">
      <img src="{{ asset('images/logo-sobanhang.svg') }}" alt="SoBanHang" class="home-logo">
      <p>Ứng dụng quản lý bán hàng thông minh Số 1 Việt Nam</p>
      <p>VN: 173 Tran Nao Street, An Khanh Ward, Thu Duc City, HCMC, Vietnam</p>
      <p>SIN: 10 Anson Road, #33-06B International Plaza, 079903 Singapore</p>
    </div>

    <div class="home-footer-columns">
      <div class="home-footer-col">
        <h4>Số Bán Hàng</h4>
        <ul>
          <li>Về chúng tôi</li>
          <li>Tin tức & sự kiện</li>
          <li>Tuyển dụng</li>
          <li>Liên hệ</li>
          <li>Bắt đầu sử dụng</li>
        </ul>
      </div>
      <div class="home-footer-col">
        <h4>Sản phẩm</h4>
        <ul>
          <li>Quản lý bán hàng</li>
          <li>Cửa hàng ăn uống</li>
          <li>Bán lẻ hiện đại</li>
          <li>Bán hàng đa kênh</li>
          <li>Quản lý dòng tiền</li>
        </ul>
      </div>
      <div class="home-footer-col">
        <h4>Giải pháp</h4>
        <ul>
          <li>Quản lý toàn diện</li>
          <li>Chăm sóc khách hàng</li>
          <li>Kiểm soát tài chính</li>
          <li>Hướng dẫn sử dụng</li>
        </ul>
      </div>
      <div class="home-footer-col">
        <h4>Chính sách</h4>
        <ul>
          <li>Quy chế hoạt động</li>
          <li>Điều khoản dịch vụ</li>
          <li>Chính sách bảo mật</li>
        </ul>
      </div>
    </div>

    <div class="home-social-media">
      <p>Theo dõi chúng tôi</p>
      <div class="home-social-icons">
        <img src="{{ asset('images/icons/facebook.png') }}" alt="Facebook">
        <img src="{{ asset('images/icons/zalo.png') }}" alt="Zalo">
        <img src="{{ asset('images/icons/tiktok.png') }}" alt="TikTok">
        <img src="{{ asset('images/icons/linkedin.jpg') }}" alt="LinkedIn">
        <img src="{{ asset('images/icons/youtube.jpg') }}" alt="YouTube">
      </div>
    </div>
  </div>

  <div class="home-footer-bottom">
    <p>© 2023 – FINAN PTE. LTD.</p>
    <div class="home-gov-badges">
      <img src="thong-bao.png" alt="Đã thông báo">
      <img src="dang-ky.png" alt="Đã đăng ký">
    </div>
    <div class="home-back-to-top">
      <a href="#">↑</a>
    </div>
  </div>
</footer> --}}

<footer class="home-footer">
  <div class="home-footer-top ">
    <div class="home-company-info">
      <img src="{{ asset('images/logo-sobanhang.svg') }}" alt="SoBanHang" class="home-logo">
      <h4>Ứng dụng quản lý bán hàng thông minh Số 1 Việt Nam</h4>
      <p>VN: 173 Tran Nao Street, An Khanh Ward, Thu Duc City, HCMC, Vietnam</p>
      <p>SIN: 10 Anson Road, #33-06B International Plaza, 079903 Singapore</p>
    </div>
    <div class="home-social-media">
      <p>Theo dõi chúng tôi</p>
      <div class="home-social-icons">
        <img src="{{ asset('images/icons/facebook.png') }}" alt="Facebook">
        <img src="{{ asset('images/icons/zalo.png') }}" alt="Zalo">
        <img src="{{ asset('images/icons/tiktok.png') }}" alt="TikTok">
        <img src="{{ asset('images/icons/linkedin.jpg') }}" alt="LinkedIn">
        <img src="{{ asset('images/icons/youtube.jpg') }}" alt="YouTube">
      </div>
    </div>
    
    
  </div>
  <div class="home-footer-columns">
    <div class="home-footer-col">
      <h4>Số Bán Hàng</h4>
      <ul>
        <li>Về chúng tôi</li>
        <li>Tin tức & sự kiện</li>
        <li>Tuyển dụng</li>
        <li>Liên hệ</li>
        <li>Bắt đầu sử dụng</li>
      </ul>
    </div>
    <div class="home-footer-col">
      <h4>Sản phẩm</h4>
      <ul>
        <li>Quản lý bán hàng</li>
        <li>Cửa hàng ăn uống</li>
        <li>Bán lẻ hiện đại</li>
        <li>Bán hàng đa kênh</li>
        <li>Quản lý dòng tiền</li>
      </ul>
      <h4>Blog</h4>
      <ul>
        <li>Quản lý bán hàng</li>
        <li>Câu chuyện thành công</li>
        <li>Kinh nghiệm kinh doanh</li>
        <li>Kênh bán hàng</li>
      </ul>
    </div>
    <div class="home-footer-col">
      <h4>Giải pháp</h4>
      <ul>
        <li>Tính năng</li>
        <li>Quản lý toàn diện</li>
        <li>Chăm sóc khách hàng</li>
        <li>Kiểm soát tài chính</li>
        <li>Hướng dẫn sử dụng</li>
      </ul>
      <h4>Chính sách</h4>
      <ul>
        <li>Quy chế hoạt động</li>
        <li>Điều khoản dịch vụ</li>
        <li>Chính sách bảo mật</li>
      </ul>
    </div>
    {{-- <div class="home-footer-col">
    </div> --}}
  </div>

  <div class="home-footer-bottom">
    <p>© 2023 – FINAN PTE. LTD.</p>
    <div class="home-gov-badges">
      <img src="thong-bao.png" alt="Đã thông báo">
      <img src="dang-ky.png" alt="Đã đăng ký">
    </div>
    <div class="home-back-to-top">
      <a href="#">↑</a>
    </div>
  </div>
</footer>
</body>
</html>
