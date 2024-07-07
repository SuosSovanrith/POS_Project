@extends('layouts.master')

@section('title', 'Products')

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
                                            @foreach ($category as $item)
                                                <option value="{{$item->category_id}}" >{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <label for="Supplier_Id" class="form-label">Supplier</label>
                                <div class="select-style-2">
                                    <div class="select-position select-sm">
                                        <select name="Supplier_Id" id="Supplier_Id">
                                            @foreach ($supplier as $item)
                                                <option value="{{$item->supplier_id}}" >{{$item->supplier_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" min="0" name="Quantity" id="Quantity" value="0" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <br/>
                                <div class="form-check form-switch toggle-switch">
                                    <label class="form-check-label" for="Barcode">Barcode</label>
                                    <input class="form-check-input" type="checkbox" name="Barcode" id="Barcode" value="1" checked required>
                                </div>
                            </div>
                            <!-- <div class="mb-3 col-md-6">
                                <label for="In_Stock" class="form-label">In Stock</label>
                                <div class="select-style-2">
                                    <div class="select-position select-sm">
                                        <select name="In_Stock" id="In_Stock">
                                            <option value="1">In Stock</option>
                                            <option value="0">Out of Stock</option>
                                        </select>     
                                    </div>
                                </div>                       
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="Price_In" class="form-label">Price In</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="Price_In" id="Price_In" value="0" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="Price_Out" class="form-label">Price Out</label>
                                <input type="number" class="form-control" step="0.01" min="0" name="Price_Out" id="Price_Out" value="0" required>
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

<!-- Product View Modal-->
<div class="modal fade" id="FormModalProduct" tabindex="-1" aria-labelledby="FormModalProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="FormModalProductLabel">Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row g-0" id="ProductViewCard">
                <!-- Content via JQuery -->
            </div>
        </div>
    </div>
</div>

<!-- Import Excel Modal-->
<div class="modal fade" id="FormModalImport" tabindex="-1" aria-labelledby="FormModalProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="FormModalProductLabel">Import</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/importexcel" method="POST" enctype="multipart/form-data">
                <div class="row g-0">
                    @csrf
                    <div class="mb-3 col-md-12 p-3">
                        <label for="Image" class="form-label">Excel File</label>
                        <input type="file" class="form-control" name="Excel_File" id="Excel_File" accept=".xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('assets/files/products_import_format.xlsx') }}" download class="btn btn-primary">Download Format</a>
                    <input type="submit" id="BtnImportProduct" class="btn btn-success" value="Import" />
                    <input type="submit" class="btn btn-danger" value="Export" formaction="/exportexcel" formmethod="GET"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== tables-wrapper start ========== -->
<div class="tables-wrapper shadow-sm">
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

                <div class="row mb-2 p-0">

                    <div class="col-md-6">
                        <h3>Products</h3>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="row">
                             <div class="col-7">
                                <div align="right"><a href="#" id="ImportPopup" class="main-btn success-btn-outline btn-hover btn-sm"><i class="fa fa-file-excel-o mr-5"></i><b>Import/Export</b></a></div>
                             </div>
                             <div class="col-5">
                                <div align="left"><a href="#" id="AddPopup" class="main-btn primary-btn-outline btn-hover btn-sm"><i class="lni lni-plus mr-5"></i><b>New Product</b></a></div>
                             </div>
                        </div>
                    </div>

                    <form action="/filterproduct" method="post" id="SearchForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-4 pt-1">
                                        <label for="Filter_Period">Period</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select name="Filter_Period" id="Filter_Period">
                                                    <option value=" " selected>All</option>
                                                    <option value="Today" <?php if(isset($filter_period)){ if($filter_period == "Today") echo("selected");}?>>Today</option>
                                                    <option value="Yesterday" <?php if(isset($filter_period)){ if($filter_period == "Yesterday") echo("selected");}?>>Yesterday</option>
                                                    <option value="This Week" <?php if(isset($filter_period)){ if($filter_period == "This Week") echo("selected");}?>>This Week</option>
                                                    <option value="Last Week" <?php if(isset($filter_period)){ if($filter_period == "Last Week") echo("selected");}?>>Last Week</option>
                                                    <option value="This Month" <?php if(isset($filter_period)){ if($filter_period == "This Month") echo("selected");}?>>This Month</option>
                                                    <option value="Last Month" <?php if(isset($filter_period)){ if($filter_period == "Last Month") echo("selected");}?>>Last Month</option>
                                                    <option value="This Year" <?php if(isset($filter_period)){ if($filter_period == "This Year") echo("selected");}?>>This Year</option>
                                                    <option value="Last Year" <?php if(isset($filter_period)){ if($filter_period == "Last Year") echo("selected");}?>>Last Year</option>
                                                </select>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                        
                            </div>  
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-4 pt-1">
                                        <label for="Filter_Category">Category</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select name="Filter_Category" id="Filter_Category">
                                                    <option value=" " selected>All</option>
                                                    @foreach ($category as $item)
                                                    <option value="{{$item->category_id}}" <?php if(isset($filter_category)){ if($filter_category == $item->category_id) echo("selected");}?>>{{$item->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                        
                            </div>  
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-4 pt-1">
                                        <label for="Filter_Supplier">Supplier</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select name="Filter_Supplier" id="Filter_Supplier">
                                                    <option value=" " selected>All</option>
                                                    @foreach ($supplier as $item)
                                                    <option value="{{$item->supplier_id}}" <?php if(isset($filter_supplier)){ if($filter_supplier == $item->supplier_id) echo("selected");}?>>{{$item->supplier_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                        
                            </div>  
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-4 pt-1">
                                        <label for="Filter_Stock">Stock</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select name="Filter_Stock" id="Filter_Stock">
                                                    <option value=" " selected>All</option>
                                                    <option value="Low Stock" <?php if(isset($filter_stock)){ if($filter_stock == "Low Stock") echo("selected");}?>>Low Stock</option>
                                                    <option value="Out of Stock" <?php if(isset($filter_stock)){ if($filter_stock == "Out of Stock") echo("selected");}?>>Out of Stock</option>
                                                    <option value="In Stock" <?php if(isset($filter_stock)){ if($filter_stock == "In Stock") echo("selected");}?>>In Stock</option>
                                                    <option value="Descending" <?php if(isset($filter_stock)){ if($filter_stock == "Descending") echo("selected");}?>>Descending</option>
                                                    <option value="Ascending" <?php if(isset($filter_stock)){ if($filter_stock == "Ascending") echo("selected");}?>>Ascending</option>
                                                </select>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                        
                            </div>  
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-primary" id="SearchSubmit" value="Filter">
                                <input type="submit" class="btn btn-danger" id="SearchClear" value="Clear" formaction="/admin/products" formmethod="get">
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <div class="input-style-2">
                                <form action="/searchproductlist" method="post" id="SearchForm">  
                                    @csrf
                                    <input type="text" class="form-control" name="Product_Search" id="Product_Search" placeholder="Search Product...">
                                    <input type="submit" class="form-control" id="BtnSearchProduct" style="display: none;">
                                </form>
                                <span class="icon"> <i class="lni lni-magnifier"></i> </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-wrapper table-responsive">
                    <table class="table table-sm table-hover" id="TblMain">
                        <thead>
                            <tr>
                                <th class="p-2">Image</th>
                                <th class="p-2">ID</th>
                                <th class="p-2">Name</th>
                                <th class="p-2">Barcode</th>
                                <th class="p-2">Quantity</th>
                                <th class="p-2">Price In</th>
                                <th class="p-2">Price Out</th>
                                <th class="p-2">In Stock</th>
                                <th class="p-2">Action</th>
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="min-width p-3" style="width:69px;">
                                    <img src="{{asset($product->image)}}" alt="Image" width="69"/>
                                    <p style="display:none;">{{$product->image}}</p>
                                </td>
                                <td class="min-width p-3">
                                    <p>{{$product->product_id}}</p>
                                </td>
                                <td class="min-width p-3"  style="width: 150px;">
                                    <p>{{$product->product_name}}</p>
                                </td>
                                <td align="center" class="min-width p-3">
                                    <?php echo($product->barcode_image) ?>
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
                                    @if ($product->quantity < 1)
                                    <span class="status-btn close-btn text-center" style="width: 100px;">Out of Stock</span>
                                    @elseif ($product->quantity <= 5)
                                    <span class="status-btn warning-btn text-center" style="width: 100px;">Low Stock</span>    
                                    @else
                                    <span class="status-btn success-btn text-center" style="width: 100px;">In Stock</span>    
                                    @endif
                                </td>
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->category_id}}</p>
                                </td>
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->supplier_id}}</p>
                                </td> 
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->category_name}}</p>
                                </td>
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->supplier_name}}</p>
                                </td> 
                                <td class="min-width p-3" style="display: none;">
                                    <?php echo($product->barcode_image) ?>
                                </td>
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->created_at}}</p>
                                </td>
                                <td class="min-width p-3" style="display: none;">
                                    <p>{{$product->updated_at}}</p>
                                </td> 
                                <td class="p-3">
                                    <a href="#" class="BtnEditProduct text-primary" style="width: 20px;"><i class="lni lni-pencil-alt"></i></a>
                                    <a href="#" class="BtnViewProduct text-success" style="width: 20px;"><i class="lni lni-eye"></i></a>
                                    <a href="#" class="BtnDeleteProduct text-danger" style="width: 20px;"><i class="lni lni-trash-can"></i></a>
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

<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // for update Product
    $(function() {

        // auto fill form of Product from edit id
        $("#TblMain").on('click', '.BtnEditProduct', function() {
            $("#FormModal").modal("show");

            var current_row = $(this).closest('tr');
            var Image = current_row.find('td').eq(0).text().trim();
            var Id = current_row.find('td').eq(1).text().trim();
            var Product_Name = current_row.find('td').eq(2).text().trim();
            // var Barcode = current_row.find('td').eq(3).text().trim();
            var Quantity = current_row.find('td').eq(4).text().trim();
            var Price_In = current_row.find('td').eq(5).text().trim().slice(1);
            var Price_Out = current_row.find('td').eq(6).text().trim().slice(1);
            var Category_Id = current_row.find('td').eq(8).text().trim();
            var Supplier_Id = current_row.find('td').eq(9).text().trim();

            $('#CurrentImage').val(Image);
            $("#Id").val(Id);
            $("#Product_Name").val(Product_Name);
            $("#Category_Id option[value='" + Category_Id + "']").attr("selected","selected");
            $("#Supplier_Id option[value='" + Supplier_Id + "']").attr("selected","selected");
            $("#Barcode").prop('required', false);
            $("#Barcode").prop("checked", false );
            $("#Quantity").val(Quantity);
            $("#Price_In").val(Price_In);
            $("#Price_Out").val(Price_Out);
        });

    });

    // for delete Product
    $(function() {

        $("#TblMain").on('click', '.BtnDeleteProduct', function() {
            var current_row = $(this).closest('tr');
            var Id = current_row.find('td').eq(1).text();

            if (confirm("Are you sure you want to delete?")) {
                $.post('/deleteproduct', {
                    id: Id
                }, function(data) {
                    window.location.href = "/admin/products";
                });
            }
        });
    });

    // open popup form
    $("#AddPopup").click(function() {
        $("#FormModal").modal("show");
    });

    // open import modal form
    $("#ImportPopup").click(function() {
        $("#FormModalImport").modal("show");
    });
    
    // clear form
    $(".btn-close").click(function() {
        $('#CurrentImage').val("");
        $("#Id").val("");
        $("#Product_Name").val("");
        $("#Category_Id option:selected").each(function () {
               $(this).removeAttr('selected'); 
            });
        $("#Supplier_Id option:selected").each(function () {
               $(this).removeAttr('selected'); 
            });
        $("#Barcode").prop('required', true);
        $("#Barcode").prop("checked", true );
        $("#Quantity").val("");
        $("#Price_In").val("");
        $("#Price_Out").val("");
    });
    
    
    // open product view form
    $(".BtnViewProduct").click(function() {
        $("#FormModalProduct").modal("show");

        var current_row = $(this).closest('tr');
        var Image = current_row.find('td').eq(0).text().trim();
        var Id = current_row.find('td').eq(1).text().trim();
        var Product_Name = current_row.find('td').eq(2).text().trim();
        var Barcode = current_row.find('td').eq(3).text().trim();
        var Quantity = current_row.find('td').eq(4).text().trim();
        var Price_In = current_row.find('td').eq(5).text().trim().slice(1);
        var Price_Out = current_row.find('td').eq(6).text().trim().slice(1);
        var Category_Name = current_row.find('td').eq(10).text().trim();
        var Supplier_Name = current_row.find('td').eq(11).text().trim();
        var BarcodeImage = current_row.find('td').eq(12).html();
        var CreatedAt = current_row.find('td').eq(13).text().trim();
        var UpdatedAt = current_row.find('td').eq(14).text().trim();

        if(Quantity < 1){
            In_Stock = "<span class='status-btn close-btn text-center'>Out of Stock</span>";
        }else if(Quantity <= 5){
            In_Stock = " <span class='status-btn warning-btn text-center'>Low Stock</span>";
        }else{
            In_Stock = " <span class='status-btn success-btn text-center'>In Stock</span>";
        }

        $("#ProductViewCard").html(
        '<div class="col-md-6 justify-content-center p-3">' +
        '<img src="http://127.0.0.1:8000/'+  Image + '" class="img-fluid rounded-start" alt="Product Image" width="100%">' +
        '</div>' +
        '<div class="col-md-6 p-2 pt-2 ">' +
        '<h2>' +  Id + '. ' + Product_Name + '</h2> <br/>' +
        '<p>' +
        '<b>Category: </b> ' + Category_Name + ' <br/>' +
        '<b>Supplier: </b> ' + Supplier_Name + ' <br/>' +
        '<b>Barcode: </b> ' + Barcode + 
        BarcodeImage +
        ' <br/>' +'<b>Quantity: </b> ' + Quantity + ' <br/>' +
        '<b>Price In: </b> $' + Price_In + ' <br/>' +
        '<b>Price Out: </b> $' + Price_Out + ' <br/><br/>' +
        '<b>In Stock: </b> ' + In_Stock + ' <br/><br/>' +
        '<b>Created At: </b>' + CreatedAt + ' <br/>' +
        '<b>Updated At: </b>' + UpdatedAt +
        '</p>' +
        '</div>' +
        '<div class="d-print-none p-3">' +
        '<div class="float-end">' +
        '<a href="#" class="btn btn-success" id="Print" onclick="printBarcode('+ Barcode +')"><i class="lni lni-printer"> Print Barcode</i></a>' +
        '</div>' +
        '</div>'
        );

    });

    function printBarcode(barcode){
        $.ajax({
            url: '/getbarcodeimage/'+barcode,
            type: 'POST',
            dataType: 'json', 
            success: function(response) {
                var data = response.barcode_image;
                var a = window.open('', 'myWin', 'height=800, width=800');
                a.document.write('<html>');  
                a.document.write('<head><style> div{display:inline-block;}</style></head>');  
                a.document.write('<body >'); 
                    for(var i=0; i<36; i++){
                        a.document.write("<div style='border: 1px dashed black; padding-left: 20px;'>"); 
                        a.document.write('<p style="font-size: 10px;">' + response.product_id + '. ' + response.product_name + ' [' + response.barcode + ']' + '</p>'); 
                        a.document.write(data + "&emsp;&emsp;"); 
                        a.document.write("</div>"); 
                    }
                a.document.write('</body></html>'); 
                a.document.title = 'Print Barcode'; 
                a.focus(); 
                setTimeout(() => {
                    a.stop();     
                }, 1000);
                setTimeout(() => {
                    a.print(); 
                }, 1200);
                },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error here
            }
        });
    }


    // Category Search Select
    var category_search = document.querySelector("#Filter_Category");

    dselect(category_search, {
        search: true,
        maxHeight: '700px'
    });

    // Supplier Search Select
    var supplier_search = document.querySelector("#Filter_Supplier");

    dselect(supplier_search, {
        search: true,
        maxHeight: '700px'
    });

        
    // for search product
    $('#Product_Search').keypress(function (e) {
        if (e.which == 13) {
            $('#BtnSearchProduct').click();
        }
    });

</script>

@endsection