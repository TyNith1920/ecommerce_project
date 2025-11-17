<section class="info_section layout_padding2-top">
  <!-- Social Media -->
  <div class="social_container py-3">
    <div class="social_box d-flex justify-content-center gap-3">
      <a href="#" class="social-icon facebook"><i class="fa-brands fa-facebook-f"></i></a>
      <a href="#" class="social-icon twitter"><i class="fa-brands fa-twitter"></i></a>
      <a href="#" class="social-icon instagram"><i class="fa-brands fa-instagram"></i></a>
      <a href="#" class="social-icon youtube"><i class="fa-brands fa-youtube"></i></a>
    </div>
  </div>

  <!-- Info Container -->
  <div class="info_container py-5">
    <div class="container">
      <div class="row g-4">
        <!-- About Us -->
        <div class="col-md-6 col-lg-3">
          <h6 class="footer-title">ABOUT US</h6>
          <p class="footer-text">
            <strong>LFCShop</strong> ជាវេទិកាទិញទំនិញអនឡាញ ស្រួល សុវត្ថិភាព និងទាន់សម័យ។
            យើងផ្តល់ផលិតផលគុណភាពខ្ពស់ តម្លៃសមរម្យ ដឹកជញ្ជូនរហ័ស និងសេវាកម្មអតិថិជនដែលអាចទុកចិត្តបាន។
            បេសកកម្មរបស់យើងគឺធ្វើឲ្យបទពិសោធន៍ទិញទំនិញអនឡាញរបស់អ្នកក្លាយជារឿងសប្បាយនិងងាយស្រួល។
          </p>
        </div>

        <!-- Newsletter -->
        <div class="col-md-6 col-lg-3">
          <h6 class="footer-title">Newsletter</h6>
          <p>ចុះឈ្មោះដើម្បីទទួលព័ត៌មានថ្មីៗពីយើង។</p>
          <form class="newsletter-form mt-3">
            <div class="input-group">
              <input type="email" class="form-control" placeholder="Enter your email" required>
              <button class="btn btn-light text-dark fw-semibold" type="submit">Subscribe</button>
            </div>
          </form>
        </div>

        <!-- Need Help -->
        <div class="col-md-6 col-lg-3">
          <h6 class="footer-title">NEED HELP</h6>
          <p class="footer-text">
            យើងនៅទីនេះដើម្បីជួយអ្នក។ សូមទាក់ទងមកក្រុមការងាររបស់យើង ប្រសិនបើអ្នកមានសំណួរ ឬការលំបាកអំពីការទិញទំនិញ ឬការដឹកជញ្ជូន។
            យើងតែងតែត្រៀមខ្លួនដើម្បីជួយអ្នក។
          </p>
        </div>

        <!-- Contact Us -->
        <div class="col-md-6 col-lg-3">
          <h6 class="footer-title">CONTACT US</h6>
          <div class="info_link-box d-flex flex-column gap-2">
            <a href="#" class="footer-link">
              <i class="fa fa-map-marker text-warning me-2"></i> Cambodia, Sihanoukville
            </a>
            <a href="tel:+85561532124" class="footer-link">
              <i class="fa fa-phone text-warning me-2"></i> +855 61532124
            </a>
            <a href="mailto:admin@gmail.com" class="footer-link">
              <i class="fa fa-envelope text-warning me-2"></i> admin@gmail.com
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Bottom -->
  <footer class="footer_section text-center py-3">
    <div class="container">
      <p class="m-0">
        © <span id="displayYear"></span> All Rights Reserved | 
        Designed by <span class="text-warning fw-semibold">Web LU</span> & <span class="text-warning fw-semibold">Student</span>
      </p>
    </div>
  </footer>
</section>

<!-- JS Scripts -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Footer Styles -->
<style>
  /* 🌈 Gradient Background Footer */
  .info_section {
    background: linear-gradient(180deg, #0F6B63 0%, #4FA7A5 50%, #70B2B2 100%);
    font-family: 'Poppins', sans-serif;
    color: #f8f9fa;
    box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.2);
  }

  .footer-title {
    font-weight: 700;
    color: #FFD43B;
    margin-bottom: 15px;
  }

  .footer-text {
    font-size: 0.95rem;
    line-height: 1.8;
    color: #e6e6e6;
  }

  /* 🌐 Social Icons */
  .social_box a {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    transition: all 0.3s ease;
  }

  .social-icon.facebook { background: #1877f2; }
  .social-icon.twitter { background: #1da1f2; }
  .social-icon.instagram { background: #e1306c; }
  .social-icon.youtube { background: #ff0000; }

  .social_box a:hover {
    transform: translateY(-3px);
    opacity: 0.85;
  }

  /* Newsletter */
  .newsletter-form input {
    border: none;
    border-radius: 6px 0 0 6px;
  }

  .newsletter-form button {
    border-radius: 0 6px 6px 0;
  }

  /* Links */
  .footer-link {
    color: #f1f1f1;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .footer-link:hover {
    color: #FFD43B;
    transform: translateX(4px);
  }

  /* Bottom Bar */
  .footer_section {
    background: rgba(0, 0, 0, 0.3);
    color: #f8f9fa;
    font-size: 0.9rem;
  }
</style>
