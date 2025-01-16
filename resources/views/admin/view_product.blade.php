<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Products</title>
  </head>
  <body>
    <!-- Header -->
    @include('admin.dash_header')

    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      @include('admin.dash_sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Product / Product List</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <form action="{{ route('search.product') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label>Product Name/Code</label>
                                        <input type="text" name="product" class="form-control form-control-sm" placeholder="Product Name/Code">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-3">
                                        <label class="form-label">Product Category</label>
                                        <select class="form-control form-control-sm form-select" name="category" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($categories as $category)
                                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">Sub Category</label>
                                        <select class="form-control form-control-sm form-select" name="subcategory" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{$subcategory->sub_category}}">{{$subcategory->sub_category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-3">
                                        <label class="form-label">Brand</label>
                                        <select class="form-control form-control-sm form-select" name="brand" aria-label="Default select example">
                                            <option value="" selected>Select One</option>

                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4 my-2">
                                        <button type="submit" class="btn btn-primary mt-md-3 px-5"><i class="icon-magnifying-glass-browser"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="block table-responsive">
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#addProduct" class="btn btn-primary ms-auto">Add Product</button>
                            </div>
                            <table class="table table-hover" id="product_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">No.</th>
                                        <th scope="col">Product Code</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Sub Category</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Price(&#2547;)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$product->barcode}}</td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->category}}</td>
                                            <td>{{$product->sub_category}}</td>
                                            <td>{{$product->brand}}</td>
                                            <td>
                                                <a href="javascript:void(0);" id="quantity{{$product->id}}" class="clickable-quantity" data-id="{{$product->id}}" style="text-decoration: none;">
                                                    {{$product->total_quantity}}
                                                </a>
                                            </td>
                                            <td>&#2547; {{$product->s_price}}</td>
                                            <td class="action_td">
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#viewModal{{$product->id}}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#editModal{{$product->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{url('delete_product', $product->id)}}" class="btn btn-outline-danger btn-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                            <p style="display: none;">
                                                <span class="unit">{{$product->unit}}</span>
                                                <span class="b_price">{{$product->b_price}}</span>
                                                <span class="min_s">{{$product->min_s}}</span>
                                                <span class="max_s">{{$product->max_s}}</span>
                                                <span class="supplier">{{$product->supplier}}</span>
                                                <span class="image">{{$product->image}}</span>
                                            </p>
                                        </tr>
                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{$product->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('edit_products', $product->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><span class="text-primary">{{$product->title}}</span> Details:</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Product Code: &nbsp;</strong>{{$product->barcode}} <br>

                                                                    <strong>Category: &nbsp;</strong>{{$product->category}} <br>

                                                                    <strong>Sub Category: &nbsp;</strong>{{$product->sub_category}} <br>

                                                                    <strong>Brand: &nbsp;</strong>{{$product->brand}} <br>

                                                                    <strong>Unit: &nbsp;</strong>{{$product->unit}} <br>

                                                                    <strong>Buying Price: &nbsp;</strong>{{$product->b_price}} <br>

                                                                    <strong>Selling Price: &nbsp;</strong>{{$product->s_price}} <br>

                                                                    <strong>Min. Stock: &nbsp;</strong>{{$product->min_s}} <br>

                                                                    <strong>Max. Stock: &nbsp;</strong>{{$product->max_s}} <br>

                                                                    <strong>Supplier: &nbsp;</strong>{{$product->supplier}} <br>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <img src="{{ asset('products/' . $product->image) }}" alt="Product Image" style="height: auto; width: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$product->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('edit_products', $product->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Product</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required-label">Product Code</label>
                                                                    <div class="d-flex">
                                                                        <input type="number" class="form-control form-control-sm me-2" id="barcode2" name="barcode" value="{{$product->barcode}}" required>
                                                                        <button class="btn btn-outline-info btn-sm code_generate2"><i class="fas fa-sync-alt me-2"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required-label">Product Name</label>
                                                                    <input type="text" class="form-control form-control-sm" name="title" value="{{$product->title}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required-label">Category</label>
                                                                    <select class="form-control form-control-sm form-select" name="edit_category" aria-label="Default select example" required>
                                                                        <option value="{{$product->category}}" selected>{{$product->category}}</option>
                                                                        @foreach ($categories as $category)
                                                                            <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label>Sub Category</label>
                                                                    <select class="form-control form-control-sm form-select" name="edit_sub_category" aria-label="Default select example">
                                                                        <!-- Initially show only the selected subcategory as an option -->
                                                                        <option value="{{$product->sub_category}}" selected>{{$product->sub_category}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="required-label">Brand</label>
                                                                    <select class="form-control form-control-sm form-select" name="brand" aria-label="Default select example" required>
                                                                        <option value="{{$product->brand}}" selected>{{$product->brand}}</option>

                                                                        @foreach ($brands as $brand)
                                                                        <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="required-label">Unit</label>
                                                                    <select class="form-control form-control-sm form-select" name="unit" aria-label="Default select example" required>
                                                                        <option value="{{$product->unit}}" selected>{{$product->unit}}</option>

                                                                        @foreach ($units as $unit)
                                                                        <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="required-label">Buying Price</label>
                                                                    <input type="number" step="0.01" class="form-control form-control-sm" name="b_price" value="{{$product->b_price}}" required>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="">Selling Price</label>
                                                                    <input type="number" step="0.01" class="form-control form-control-sm" name="s_price" value="{{$product->s_price}}">
                                                                </div>
                                                                <div class="i-checks col-md-3 my-4">
                                                                    <input id="vatable" name="vatable" type="checkbox" value="yes" class="checkbox-template" {{ isset($product->vatable) && $product->vatable == 'yes' ? 'checked' : '' }}>
                                                                    <label for="vatable">Is Vatable?</label>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="">Min. Stock</label>
                                                                    <input type="number" class="form-control form-control-sm" name="min_s" value="{{$product->min_s}}">
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="">Max. Stock</label>
                                                                    <input type="number" class="form-control form-control-sm" name="max_s" value="{{$product->max_s}}">
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="">Supplier</label>
                                                                    <input type="text" class="form-control form-control-sm" name="supplier" value="{{$product->supplier}}">
                                                                </div>
                                                                <div class="col-md-6 mb-2">
                                                                    <label>Photo/Logo</label>
                                                                    <input type="file" class="form-control form-control-sm" name="image" value="{{$product->image}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="pagination-container">
                                <div class="pagination-info">
                                    @if ($products->total() > 0)
                                        Showing
                                        {{ $products->firstItem() }}
                                        to
                                        {{ $products->lastItem() }}
                                        of
                                        {{ $products->total() }}
                                        products
                                    @else
                                        No products available.
                                    @endif
                                </div>

                                <div class="pagination-wrapper">
                                    <ul class="pagination">
                                        <!-- First Page Button -->
                                        <li class="{{ $products->onFirstPage() ? 'disabled' : '' }}">
                                            <a href="{{ $products->url(1) }}"><i class="fas fa-backward"></i></a>
                                        </li>

                                        <!-- Previous Page Button -->
                                        <li class="{{ $products->previousPageUrl() ? '' : 'disabled' }}">
                                            <a href="{{ $products->previousPageUrl() }}"><i class="fas fa-backward-step"></i></a>
                                        </li>

                                        <!-- Page Number Links -->
                                        @php
                                            $currentPage = $products->currentPage();
                                            $lastPage = $products->lastPage();
                                        @endphp

                                        @for ($page = 1; $page <= $lastPage; $page++)
                                            @if ($page == 1 || $page == $lastPage || ($page >= $currentPage - 2 && $page <= $currentPage + 2))
                                                <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                                    <a href="{{ $products->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @elseif ($page == 2 && $currentPage > 4)
                                                <li class="disabled"><span>...</span></li>
                                            @elseif ($page == $lastPage - 1 && $currentPage < $lastPage - 3)
                                                <li class="disabled"><span>...</span></li>
                                            @endif
                                        @endfor

                                        <!-- Next Page Button -->
                                        <li class="{{ $products->nextPageUrl() ? '' : 'disabled' }}">
                                            <a href="{{ $products->nextPageUrl() }}"><i class="fas fa-forward-step"></i></a>
                                        </li>

                                        <!-- Last Page Button -->
                                        <li class="{{ $products->hasMorePages() ? '' : 'disabled' }}">
                                            <a href="{{ $products->url($lastPage) }}"><i class="fas fa-forward"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{url('upload_product')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add new Product</strong>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Product Code</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm me-2" id="barcode1" name="barcode" required>
                                    <button class="btn btn-outline-info btn-sm code_generate1"><i class="fas fa-sync-alt me-2"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Product Name</label>
                                <input type="text" class="form-control form-control-sm" name="title" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Category</label>
                                <select class="form-control form-control-sm form-select" name="category" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>

                                    @foreach ($categories as $category)
                                    <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Sub Category</label>
                                <select class="form-control form-control-sm form-select" name="sub_category" aria-label="Default select example">
                                    <option value="" selected>Select One</option>

                                    @foreach ($subcategories as $sub_ctg)
                                    <option value="{{$sub_ctg->sub_category}}">{{$sub_ctg->sub_category}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="required-label">Brand</label>
                                <select class="form-control form-control-sm form-select" name="brand" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>

                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="required-label">Unit</label>
                                <select class="form-control form-control-sm form-select" name="unit" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>

                                    @foreach ($units as $unit)
                                    <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="required-label">Buying Price</label>
                                <input type="number" step="0.01" class="form-control form-control-sm" name="b_price" required>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="">Selling Price</label>
                                <input type="number" step="0.01" class="form-control form-control-sm" name="s_price">
                            </div>
                            <div class="i-checks col-md-3 my-4">
                                <input id="vatable" name="vatable" type="checkbox" value="yes" class="checkbox-template" checked>
                                <label for="vatable">Is Vatable?</label>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="">Min. Stock</label>
                                <input type="number" class="form-control form-control-sm" name="min_s">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="">Max. Stock</label>
                                <input type="number" class="form-control form-control-sm" name="max_s">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="">Supplier</label>
                                <input type="text" class="form-control form-control-sm" name="supplier">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Photo/Logo</label>
                                <input type="file" class="form-control form-control-sm" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Batch Modal -->
    @foreach ($products as $product)
        <div class="modal fade" id="batchModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel{{$product->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Batch Details of <span class="text-primary">{{$product->title}}</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-primary">
                                    <th scope="col">Stock Date</th>
                                    <th scope="col">Batch Number</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Selling Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Expire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_batches->where('product_id', $product->id) as $product_batch)
                                    <tr>
                                        <td>{{$product_batch->stock_date}}</td>
                                        <td>{{$product_batch->batch_no}}</td>
                                        <td>{{$product_batch->supplier}}</td>
                                        <td>&#2547; {{$product_batch->sale_price}}</td>
                                        <td>{{$product_batch->quantity}}</td>
                                        <td>{{$product_batch->expiration_date}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- JavaScript files-->
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();

            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);

            swal({
                title: "Are you sure to delete this?",
                text: "This delete will be permanent!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willCancel) => {
                if (willCancel) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
    <!-- Sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- All JS Files -->
    @include('admin.dash_script')
    <!-- JS for generating barcode -->
    <script>
        $(document).ready(function() {
            $('.code_generate1').click(function(e) {
                e.preventDefault(); // Prevent the form from submitting
                // Generate a unique code based on the current timestamp
                let barcode = Date.now();
                // Set the generated barcode in the input field
                $('input[id="barcode1"]').val(barcode);
            });
            $('.code_generate2').click(function(e) {
                e.preventDefault(); // Prevent the form from submitting
                // Generate a unique code based on the current timestamp
                let barcode = Date.now();
                // Set the generated barcode in the input field
                $('input[id="barcode2"]').val(barcode);
            });
        });
    </script>
    <!-- JS for Sub category -->
    <script>
        $(document).ready(function() {
            // Initially disable the Sub Category dropdown
            $('select[name="sub_category"]').prop('disabled', true);

            // On change of the Category dropdown
            $('select[name="category"]').on('change', function() {
                const selectedCategory = $(this).val();

                if (selectedCategory) {
                    // Enable the Sub Category dropdown if a Category is selected
                    $('select[name="sub_category"]').prop('disabled', false);

                    // Clear existing options in Sub Category dropdown
                    $('select[name="sub_category"]').empty();

                    // Append a default option
                    $('select[name="sub_category"]').append('<option value="">Select One</option>');

                    // Fetch and filter subcategories based on the selected category
                    const filteredSubcategories = @json($subcategories).filter(sub => sub.category === selectedCategory);

                    // Append filtered subcategories to the dropdown
                    filteredSubcategories.forEach(subCategory => {
                        $('select[name="sub_category"]').append(
                            `<option value="${subCategory.sub_category}">${subCategory.sub_category}</option>`
                        );
                    });
                } else {
                    // If no Category is selected, disable Sub Category again
                    $('select[name="sub_category"]').prop('disabled', true);
                }
            });
        });
        // Edit modal Sub Category
        $(document).ready(function() {
            // Initially disable the Sub Category dropdown
            const selectedCategory = $('select[name="edit_category"]').val();

            if (selectedCategory) {
                // Enable the Sub Category dropdown if a Category is selected
                $('select[name="edit_sub_category"]').prop('disabled', false);
            }

            // On change of the Category dropdown
            $('select[name="edit_category"]').on('change', function() {
                const selectedCategory = $(this).val();

                if (selectedCategory) {
                    // Enable the Sub Category dropdown if a Category is selected
                    $('select[name="edit_sub_category"]').prop('disabled', false);

                    // Clear existing options in Sub Category dropdown
                    $('select[name="edit_sub_category"]').empty();

                    // Append a default option
                    $('select[name="edit_sub_category"]').append('<option value="">Select One</option>');

                    // Fetch and filter subcategories based on the selected category
                    const filteredSubcategories = @json($subcategories).filter(sub => sub.category === selectedCategory);

                    // Append filtered subcategories to the dropdown
                    filteredSubcategories.forEach(subCategory => {
                        $('select[name="edit_sub_category"]').append(
                            `<option value="${subCategory.sub_category}" ${subCategory.sub_category === '{{$product->sub_category}}' ? 'selected' : ''}>${subCategory.sub_category}</option>`
                        );
                    });
                } else {
                    // If no Category is selected, disable Sub Category again
                    $('select[name="edit_sub_category"]').prop('disabled', true);
                }
            });
        });
    </script>
    <!-- JS for Showing Batch modal -->
    <script>
        $(document).ready(function() {
            // When the total_quantity td is clicked
            $('.clickable-quantity').on('click', function() {
                var productId = $(this).attr('id').replace('quantity', ''); // Get the product ID from the element's ID
                var modalId = '#batchModal' + productId; // Build the modal ID

                // Trigger the modal to show
                $(modalId).modal('show');
            });
        });
    </script>
  </body>
</html>
