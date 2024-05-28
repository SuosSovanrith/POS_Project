@extends('layouts.master')

@section('title', 'Products')

@section('sidebar_products', 'active')
@section('sidebar_product', 'active')

@section('content')

<!-- Modal -->
<div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="FormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="FormModalLabel">Products Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addproduct" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <section class="container">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="Id" class="form-label">Id</label>
                                <input type="text" class="form-control" name="Id" id="Id">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="Product_Name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="Product_Name" id="Product_Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                                <label for="Category_Id" class="form-label">Category</label>
                                <div class="select-style-2">
                                    <div class="select-position select-sm">
                                        <select name="Category_Id" id="Category_Id">
                                            <option value="">None</option>
                                        {{--    @foreach ($category as $item)
                                                <option value="{{$item->id}}" >{{$item->category_name}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <label for="Supplier_Id" class="form-label">Supplier</label>
                                <div class="select-style-2">
                                    <div class="select-position select-sm">
                                        <select name="Supplier_Id" id="Supplier_Id">
                                            <option value="">None</option>
                                        {{--    @foreach ($supplier as $item)
                                                <option value="{{$item->id}}" >{{$item->supplier_name}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" min="0" name="Quantity" id="Quantity" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="Price_In" class="form-label">Price In</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="Price_In" id="Price_In" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="Price_Out" class="form-label">Price Out</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="Price_Out" id="Price_Out" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="Barcode" class="form-label">Barcode</label>
                                <input type="text" class="form-control" min="0" name="Barcode" id="Barcode" placeholder="Eg. 12345">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="In_Stock" class="form-label">In Stock</label>
                                <div class="select-style-2">
                                    <div class="select-position select-sm">
                                        <select name="In_Stock" id="In_Stock">
                                            <option value="1">In Stock</option>
                                            <option value="0">Out of Stock</option>
                                        </select>     
                                    </div>
                                </div>                       
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="Image" class="form-label">Image</label>
                                <input type="file" class="form-control" name="Image" id="Image">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="CurrentImage" class="form-label">Current Image</label> <br>
                                <input type="text" class="form-control" name="CurrentImage" id="CurrentImage" value="None" disabled>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="BtnAddProduct" class="btn btn-primary" value="Add" />
                    <input type="submit" id="BtnUpdateProduct" class="btn btn-success" value="Update" formaction="/updateproduct"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== tables-wrapper start ========== -->
<div class="tables-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-style mb-30">

                <!-- Alert Message -->
                @if (session('message'))
                  <div class="alert-box {{session('type')}}-alert">
                      <div class="alert">
                        <p class="text-medium">
                          {{session('message')}}
                          {{session()->forget(['message','type']);}}
                        </p>
                      </div>
                    </div>        
                    @endif

                <div class="row">
                    <div class="col-md-6">
                        <h3>Products</h3>
                    </div>
                    <div class="col-md-6">
                        <div align="right"><a href="#" id="AddPopup" class="main-btn primary-btn-outline btn-hover btn-sm"><i class="lni lni-plus mr-5"></i><b>New Product</b></a></div>
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table table-sm table-hover table-striped" id="TblMain">
                        <thead>
                            <tr>
                                <th class="p-3">Image</th>
                                <th class="p-3">ID</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Supplier</th>
                                <th class="p-3">Barcode</th>
                                <th class="p-3">Quantity</th>
                                <th class="p-3">Price In</th>
                                <th class="p-3">Price Out</th>
                                <th class="p-3">In Stock</th>
                                <th class="p-3">Action</th>
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="min-width p-3" style="width:96px;">
                                    <img src="{{ asset($product->image) }}" alt="Image" width="96"/>
                                    <p style="display:none;">{{$product->image}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->id}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->product_name}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->category_id}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->supplier_id}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->barcode}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->quantity}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>${{$product->price_in}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>${{$product->price_out}}</p>
                                </td>
                                <td class="min-width p-3">
                                    @if ($product->in_stock == 0)
                                        <span class="status-btn close-btn text-center">Out of Stock</span>
                                    @else
                                        <span class="status-btn success-btn text-center">In Stock</span>    
                                    @endif
                                </td>
                                <td class="p-3">
                                    <a href="#" class="BtnEditProduct btn text-primary"><i class="lni lni-pencil-alt"></i></a>
                                    <a href="#" class="BtnDeleteProduct btn text-danger"><i class="lni lni-trash-can"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            <!-- end table row -->
                        </tbody>
                    </table>
                    <!-- end table -->
                    {{$products->render()}}
                    
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- ========== tables-wrapper end ========== -->

@endsection

@section('script')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // for update user
    $(function() {

        // auto fill form of user from edit id
        $("#TblMain").on('click', '.BtnEditUser', function() {
            $("#FormModal").modal("show");
            $("#Password").removeAttr('required')

            var current_row = $(this).closest('tr');
            var Photo = current_row.find('td').eq(0).text().trim();
            var Id = current_row.find('td').eq(1).text().trim();
            var Name = current_row.find('td').eq(2).text().trim();
            var Email = current_row.find('td').eq(3).text().trim();
            var Position = current_row.find('td').eq(4).text().trim();
            var Phone = current_row.find('td').eq(5).text().trim();
            var Address = current_row.find('td').eq(6).text().trim();

            $('#CurrentPhoto').val(Photo);
            $("#Id").val(Id);
            $("#Name").val(Name);
            $("#Email").val(Email);
            $("#Position_Id option[value='" + Position + "']").attr("selected","selected");
            $("#Phone").val(Phone);
            $("#Address").val(Address);
        });

    });

    // for delete user
    $(function() {

        $("#TblMain").on('click', '.BtnDeleteUser', function() {
            var current_row = $(this).closest('tr');
            var Id = current_row.find('td').eq(1).text();

            if (confirm("Are you sure you want to delete?")) {
                $.post('/deleteuser', {
                    id: Id
                }, function(data) {
                    window.location.href = "/admin/users";
                });
            }
        });
    });

    // open popup form
    $("#AddPopup").click(function() {
        $("#FormModal").modal("show");
    });

    // clear form
    $(".btn-close").click(function() {
            $('#CurrentPhoto').val("");
            $("#Id").val("");
            $("#Name").val("");
            $("#Email").val("");
            $("#Phone").val("");
            $("#Address").val("");
            $("#Position_Id option[value='N/A']").attr("selected","selected");
    });
    
</script>

@endsection