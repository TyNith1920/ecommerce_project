<!-- Sidebar Navigation -->
<nav id="sidebar">
  <!-- Sidebar Header -->
  <div class="sidebar-header text-center">
    <div class="avatar mb-2">
      <img src="{{ asset('admincss/img/avatar-6.jpg') }}" alt="Avatar" class="img-fluid rounded-circle shadow">
    </div>
    <h5 class="fw-bold text-white mb-0">Touch Phanit</h5>
    <small class="text-muted">Web Designer</small>
  </div>

  <!-- Sidebar Menu -->
  <ul class="list-unstyled mt-3 px-2">
    <!-- Dashboard -->
    <li class="mb-1 {{ request()->is('admin/dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center py-2 px-3 rounded">
        <i class="fa fa-home me-2"></i> Dashboard
      </a>
    </li>

    <!-- Category -->
    <li class="mb-1 {{ request()->is('admin/categories*') ? 'active' : '' }}">
      <a href="{{ route('admin.categories.index') }}" class="d-flex align-items-center py-2 px-3 rounded">
        <i class="fa fa-list-alt me-2"></i> Categories
      </a>
    </li>

    <!-- Products -->
    <li class="mb-1">
      <a class="d-flex align-items-center py-2 px-3 rounded dropdown-toggle"
         data-bs-toggle="collapse"
         data-bs-target="#productMenu"
         role="button"
         aria-expanded="{{ request()->is('admin/products*') ? 'true' : 'false' }}"
         aria-controls="productMenu">
        <i class="fa fa-cubes me-2"></i> Products
      </a>

      <ul class="collapse list-unstyled ps-4 {{ request()->is('admin/products*') ? 'show' : '' }}" id="productMenu">
        <li class="{{ request()->is('admin/products/add') ? 'active' : '' }}">
          <a href="{{ route('admin.products.add') }}" class="d-block py-2 px-2">Add Product</a>
        </li>
        <li class="{{ request()->is('admin/products') ? 'active' : '' }}">
          <a href="{{ route('admin.products.index') }}" class="d-block py-2 px-2">View Products</a>
        </li>
      </ul>
    </li>

    <!-- Orders -->
    <li class="mb-1 {{ request()->is('admin/orders*') ? 'active' : '' }}">
      <a href="{{ route('admin.orders.index') }}" class="d-flex align-items-center py-2 px-3 rounded">
        <i class="fa fa-shopping-cart me-2"></i> Orders
      </a>
    </li>

    <!-- Cart -->
    <li class="mb-1 {{ request()->is('admin/cart*') ? 'active' : '' }}">
      <a href="{{ route('admin.cart.index') }}" class="d-flex align-items-center py-2 px-3 rounded">
        <i class="fa fa-shopping-basket me-2"></i> Carts
      </a>
    </li>
  </ul>
</nav>

<!-- Sidebar CSS -->
<style>
  /* Sidebar basic link style */
  #sidebar ul li a {
    color: var(--sidebar-text);
    transition: 0.3s;
    text-decoration: none;
  }
  #sidebar ul li a:hover {
    background: rgba(108, 99, 255, 0.3);
    color: #fff;
  }
  /* Active parent link */
  #sidebar ul li.active > a {
    background: linear-gradient(90deg, #6c63ff, #8b5cf6);
    color: #fff;
    box-shadow: 0 0 10px rgba(108, 99, 255, 0.5);
  }

  /* Submenu basic */
  #sidebar .collapse a {
    font-size: 14px;
  }

  #sidebar ul li .collapse li.active > a {
    background: rgba(108, 99, 255, 0.25);
    color: #fff;
    border-radius: 6px;
  }

  /* 🧭 Sidebar Dropdown Styles */
  #sidebar ul li ul.collapse {
    background: rgba(108, 99, 255, 0.05);
    border-left: 2px solid rgba(108, 99, 255, 0.3);
    margin-left: 10px;
    border-radius: 6px;
    transition: all 0.35s ease;
  }

  #sidebar ul li ul.collapse li a {
    color: #ccc;
    font-size: 14px;
    padding: 8px 20px;
    display: block;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  #sidebar ul li ul.collapse li a:hover {
    background: linear-gradient(90deg, #6c63ff, #8b5cf6);
    color: #fff;
    box-shadow: 0 0 10px rgba(108, 99, 255, 0.4);
  }

  #sidebar ul li ul.collapse li.active > a {
    background: rgba(108, 99, 255, 0.3);
    color: #fff;
  }

  /* Avatar glow */
  .sidebar-header img {
    border: 2px solid rgba(108,99,255,0.8);
    box-shadow: 0 0 15px rgba(108,99,255,0.6);
  }

  /* Make dropdown visible if it overflows */
  #sidebar {
    overflow-y: auto;
  }
</style>
