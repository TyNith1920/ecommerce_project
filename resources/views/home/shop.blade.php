<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.css')
  <!-- {{-- (optional) Bootstrap 5 CSS/Icons ដែលបងកំពុងប្រើ --}} -->
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>

  @include('home.product')

  @include('home.footer')

  <!-- {{-- Bootstrap JS bundle (dropdown/collapse work) --}} -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>