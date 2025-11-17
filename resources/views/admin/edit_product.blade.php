@extends('admin.body')

@section('title', 'Update Product')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-lg border-0 mx-auto" style="max-width: 900px; background: var(--card-bg);">
    <div class="card-body">

      <h2 class="text-gradient text-center mb-4">
        🛠 Update Product
      </h2>

      {{-- ✅ Show Validation Errors --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <strong>⚠️ សូមពិនិត្យមើលកំហុសខាងក្រោម៖</strong>
          <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- ✅ Update Product Form --}}
      <form action="{{ url('admin/products/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">ចំណងជើងផលិតផល</label>
          <input type="text" class="form-control bg-dark text-light border-0 @error('title') is-invalid @enderror"
                 name="title" value="{{ old('title', $data->title) }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">ពិពណ៌នា</label>
          <textarea class="form-control bg-dark text-light border-0 @error('description') is-invalid @enderror"
                    name="description" rows="3" required>{{ old('description', $data->description) }}</textarea>
        </div>

        {{-- Prices --}}
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-light fw-bold">តម្លៃ ($)</label>
            <input type="number" step="0.01" class="form-control bg-dark text-light border-0 @error('price') is-invalid @enderror"
                   name="price" value="{{ old('price', $data->price) }}" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-light fw-bold">តម្លៃបញ្ចុះ ($)</label>
            <input type="number" step="0.01" class="form-control bg-dark text-light border-0"
                   name="discount_price" value="{{ old('discount_price', $data->discount_price) }}">
          </div>
        </div>

        {{-- Quantity --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">ចំនួនស្តុក</label>
          <input type="number" min="1" class="form-control bg-dark text-light border-0 @error('quantity') is-invalid @enderror"
                 name="quantity" value="{{ old('quantity', $data->quantity) }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">ប្រភេទ</label>
          <select name="category" class="form-control bg-dark text-light border-0 @error('category') is-invalid @enderror" required>
            <option value="">-- ជ្រើសរើសប្រភេទ --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->category_name }}" 
                {{ old('category', $data->category) == $cat->category_name ? 'selected' : '' }}>
                {{ $cat->category_name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Current Main Image --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">រូបភាពបច្ចុប្បន្ន</label><br>
          @if($data->image)
            <img src="{{ asset('products/'.$data->image) }}" width="100" class="rounded shadow">
          @else
            <span class="text-muted">មិនមានរូបភាពទេ</span>
          @endif
        </div>

        {{-- Upload New Main Image --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">អាប់ឡូតរូបថ្មី</label>
          <input type="file" class="form-control bg-dark text-light border-0" name="image">
        </div>

        {{-- ✅ Current Gallery Images --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">រូបភាពបន្ថែម (Gallery)</label><br>
          @if(isset($galleryImages) && count($galleryImages) > 0)
            <div class="d-flex flex-wrap gap-2">
              @foreach($galleryImages as $img)
                <div class="position-relative gallery-card" id="gallery-{{ $img->id }}">
                  <img src="{{ asset('products/gallery/' . $img->image) }}" 
                       class="rounded border shadow-sm" width="90" height="90">
                  <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="{{ $img->id }}">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-muted">មិនទាន់មានរូបភាពបន្ថែមទេ</p>
          @endif
        </div>

        {{-- Upload New Gallery Images --}}
        <div class="mb-3">
          <label class="form-label text-light fw-bold">អាប់ឡូតរូបភាពបន្ថែមថ្មី</label>
          <input type="file" class="form-control bg-dark text-light border-0" name="gallery[]" multiple>
          <small class="text-secondary">អាចជ្រើសរើសរូបភាពច្រើន (JPEG, JPG, PNG)</small>
        </div>

        {{-- Submit Button --}}
        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fa fa-save"></i> កែរផលិតផល
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

{{-- ✅ Style + Script --}}
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
  $('.delete-btn').on('click', function () {
    let imageId = $(this).data('id');
    let card = $('#gallery-' + imageId);

    Swal.fire({
      title: 'តើអ្នកប្រាកដទេ?',
      text: "រូបភាពនេះនឹងត្រូវលុបចេញជាអចិន្ត្រៃយ៍!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'លុប!',
      cancelButtonText: 'បោះបង់'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/admin/products/delete-image/' + imageId,
          type: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            Swal.fire({
              title: 'លុបរួចរាល់!',
              text: 'រូបភាពត្រូវបានលុបដោយជោគជ័យ។',
              icon: 'success',
              timer: 1500,
              showConfirmButton: false
            });
            card.fadeOut(400, function () {
              $(this).remove();
            });
          },
          error: function () {
            Swal.fire('បរាជ័យ!', 'មានបញ្ហាក្នុងការលុបរូបភាព។', 'error');
          }
        });
      }
    });
  });
});
</script>

<style>
  .gallery-card {
    position: relative;
    display: inline-block;
    transition: all 0.3s ease;
  }
  .gallery-card img {
    border-radius: 10px;
    transition: 0.3s ease;
  }
  .gallery-card:hover img {
    opacity: 0.8;
    transform: scale(1.03);
  }
  .delete-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    border-radius: 50%;
    padding: 4px 6px;
    font-size: 12px;
    background-color: #dc3545;
    border: none;
    opacity: 0;
    transition: 0.2s ease;
  }
  .gallery-card:hover .delete-btn {
    opacity: 1;
  }
  .delete-btn:hover {
    background-color: #c82333;
  }
</style>
@endsection
