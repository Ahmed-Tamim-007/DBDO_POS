<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Stock In List</title>
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
                <h2 class="h5 no-margin-bottom">Stock / Stock List</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="text-right">
                                <a href="{{ url('add_stock') }}">
                                    <button type="button" class="btn btn-primary">Add Stock</button>
                                </a>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Invoive No</th>
                                        <th scope="col">Stock In Date</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Stock In Note</th>
                                        <th scope="col">Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_details as $stock_detail)
                                    <tr>
                                        <td><a href="{{ url('invoice_details', $stock_detail->id) }}" style="text-decoration: none;">{{$stock_detail->stock_invoice}}</a></td>
                                        <td>{{$stock_detail->stock_date}}</td>
                                        <td>{{$stock_detail->user}}</td>
                                        <td>{{$stock_detail->stock_note}}</td>
                                        <td>{{$stock_detail->image_path}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="pagination-container">
                                <div class="pagination-info">
                                    @if ($stock_details->total() > 0)
                                        Showing
                                        {{ $stock_details->firstItem() }}
                                        to
                                        {{ $stock_details->lastItem() }}
                                        of
                                        {{ $stock_details->total() }}
                                        results
                                    @else
                                        No stock-ins available.
                                    @endif
                                </div>

                                <div class="pagination-wrapper">

                                    <ul class="pagination">
                                        <!-- First Page Button -->
                                        <li class="{{ $stock_details->onFirstPage() ? 'disabled' : '' }}">
                                            <a href="{{ $stock_details->url(1) }}"><i class="fas fa-backward"></i></a>
                                        </li>

                                        <!-- Previous Page Button -->
                                        <li class="{{ $stock_details->previousPageUrl() ? '' : 'disabled' }}">
                                            <a href="{{ $stock_details->previousPageUrl() }}"><i class="fas fa-backward-step"></i></a>
                                        </li>

                                        <!-- Page Number Links -->
                                        @php
                                            $currentPage = $stock_details->currentPage();
                                            $lastPage = $stock_details->lastPage();
                                        @endphp

                                        @for ($page = 1; $page <= $lastPage; $page++)
                                            @if ($page == 1 || $page == $lastPage || ($page >= $currentPage - 2 && $page <= $currentPage + 2))
                                                <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                                    <a href="{{ $stock_details->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @elseif ($page == 2 && $currentPage > 4)
                                                <li class="disabled"><span>...</span></li>
                                            @elseif ($page == $lastPage - 1 && $currentPage < $lastPage - 3)
                                                <li class="disabled"><span>...</span></li>
                                            @endif
                                        @endfor

                                        <!-- Next Page Button -->
                                        <li class="{{ $stock_details->nextPageUrl() ? '' : 'disabled' }}">
                                            <a href="{{ $stock_details->nextPageUrl() }}"><i class="fas fa-forward-step"></i></a>
                                        </li>

                                        <!-- Last Page Button -->
                                        <li class="{{ $stock_details->hasMorePages() ? '' : 'disabled' }}">
                                            <a href="{{ $stock_details->url($lastPage) }}"><i class="fas fa-forward"></i></a>
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
    @include('admin.dash_script')
  </body>
</html>
