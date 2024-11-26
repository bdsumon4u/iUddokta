@extends('layouts.ready')

@section('styles')
<style>
    .nav-tabs {
        border: 2px solid #ddd;
    }
    .nav-tabs li:hover a,
    .nav-tabs li a.active {
        border-radius: 0;
        border-bottom-color: #ddd !important;
    }
    .nav-tabs li a.active {
        background-color: #f0f0f0 !important;
    }
    .nav-tabs li a:hover {
        border-bottom: 1px solid #ddd;
        background-color: #f7f7f7;
    }

    .is-invalid + .SumoSelect + .invalid-feedback {
        display: block;
    }
</style>
<style>
    .dropzone {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .previewer {
        display: inline-block;
        position: relative;
        margin-left: 3px;
        margin-right: 7px;
    }
    .previewer i {
        position: absolute;
        top: 0;
        color: red;
        right: 0;
        background: #ddd;
        padding: 2px;
        border-radius: 3px;
        cursor: pointer;
    }
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }
    th,
    td {
        vertical-align: middle !important;
    }
    table.dataTable tbody td.select-checkbox:before,
    table.dataTable tbody td.select-checkbox:after,
    table.dataTable tbody th.select-checkbox:before,
    table.dataTable tbody th.select-checkbox:after {
        top: 50%;
    }
    .select2 {
        width: 100% !important;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Add New <strong>Product</strong></div>
            <div class="card-body p-2">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <ul class="nav nav-tabs list-group" role="tablist">
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('name') || $errors->has('slug') || $errors->has('description')) text-danger @endif active" data-toggle="tab" href="#item-1">General</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('wholesale') || $errors->has('retail')) text-danger @endif" data-toggle="tab" href="#item-2">Price</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link" data-toggle="tab" href="#item-3">Inventory</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('base_image') || $errors->has('additional_images') || $errors->has('additional_images.*')) text-danger @enderror" data-toggle="tab" href="#item-4">Images</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-8 col-xl-9">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                                    <div class="tab-content">
                                        @csrf
                                        <div class="tab-pane active" id="item-1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">General</small></h4>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-name">Name</label><span class="text-danger">*</span>
                                                <input type="text" name="name" value="{{ old('name') }}" id="edit-name" data-target="#edit-slug" class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-slug">Slug</label><span class="text-danger">*</span>
                                                <input type="text" name="slug" value="{{ old('slug') }}" id="edit-slug" class="form-control @error('slug') is-invalid @enderror">
                                                @error('slug')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label><span class="text-danger">*</span>
                                                        <textarea editor name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                                        {!! $errors->first('description', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="categories" class="@error('categories') is-invalid @enderror">Categories</label><span class="text-danger">*</span>
                                                        <x-category-dropdown :categories="$categories" name="categories[]" placeholder="Select Category" id="categories" multiple="true" />
                                                        {!! $errors->first('categories', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Save Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Price</small></h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wholesale">Wholesale Price</label><span class="text-danger">*</span>
                                                        <input type="text" name="wholesale" value="{{ old('wholesale') }}" id="wholesale" class="form-control @error('wholesale') is-invalid @enderror">
                                                        {!! $errors->first('wholesale', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="retail">Retail Price</label><span class="text-danger">*</span>
                                                        <input type="text" name="retail" id="retail" value="{{ old('retail') }}" class="form-control @error('retail') is-invalid @enderror">
                                                        {!! $errors->first('retail', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Save Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Track Inventory</small></h4>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="should_track" value="1" @if(old('should_track')) checked @endif id="should-track" class="custom-control-input">
                                                            <label for="should-track" class="custom-control-label @error('stock') is-invalid @enderror">Track</label>
                                                            @error('stock')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group stock-count" @if(!old('should_track', 0)) style="display: none;" @endif>
                                                        <label for="stock">Stock Count</label>
                                                        <input type="text" name="stock" value="{{ old('stock') }}" id="stock" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Save Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Product Images</small></h4>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <!-- Button to Open the Modal -->
                                                                <label for="base_image" class="d-block"><strong>Base Image</strong></label>
                                                                <button type="button" class="btn single btn-primary" data-toggle="modal" data-target="#select-images-modal" style="height: 150px; width: 150px; background: transparent;">
                                                                    <i class="fa fa-image fa-4x text-primary"></i>
                                                                </button>
                                                                
                                                                <img src="" alt="Base Image" id="base_image-preview" class="img-thumbnail img-responsive" style="display: none; height: 150px; width: 150px; cursor: pointer;">
                                                                
                                                                <input type="hidden" name="base_image" value="{{ old('base_image') }}" class="@error('base_image') is-invalid @enderror" id="base-image" class="form-control">
                                                                @error('base_image')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="additional_images" class="d-block"><strong>Additional Images</strong></label>
                                                                <button type="button" class="btn multiple btn-primary" data-toggle="modal" data-target="#select-images-modal" style="height: 150px; width: 150px; background: transparent;">
                                                                    <i class="fa fa-image fa-4x text-primary"></i>
                                                                </button>

                                                                <input type="hidden" name="additional_images" value="{{ old('additional_images') }}" class="@error('additional_images') is-invalid @enderror" id="additional-images" class="form-control">

                                                                @error('additional_images')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Save Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="select-images-modal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Image Picker</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
            <div class="card rounded-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.images.store') }}" id="drop-imgs" class="dropzone" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable w-100" style="width: 100%;">
                            <thead>
                                <tr>
                                    <!-- <th></th> -->
                                    <th width="5">ID</th>
                                    <th width="150">Preview</th>
                                    <th>Filename</th>
                                    <th>Mime</th>
                                    <th>Size</th>
                                    <th width="10">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('[name="name"]').keyup(function () {
            $($(this).data('target')).val(slugify($(this).val()));
        });
    });
</script>
<script>
    $(document).ready(function(){

        $('#base_image-preview').click(function(){
            $(this).parent().find('[data-target="#select-images-modal"]').click();
        })
        var ID;
        var IDs = [];
        $('[data-target="#select-images-modal"]').click(function(){
            $(this).attr('opened', 'true');
        })
        $(document).on('click', '#select-images-modal .select-item', function(e){
            e.preventDefault();
            var btn = $('[data-target="#select-images-modal"][opened="true"]');
            if(btn.hasClass('single')) {
                ID = $(this).parents('tr').data('entry-id');
                // console.log('ID', ID)
                $('[name="base_image"]').val(ID);
                $(this).parents('#select-images-modal').modal('hide');
                btn.hide();

                src = $(this).parents('tr').find('.img-preview').attr('src');
                $('#base_image-preview').show().attr('src', src);
            } else {
                var theID = $(this).parents('tr').data('entry-id');
                if(jQuery.inArray(theID, IDs) != -1) {
                    // IDs.splice(IDs.indexOf(theID),1);
                } else {
                    src = $(this).parents('tr').find('.img-preview').attr('src');
                    btn.after('<div class="previewer"><img src="'+src+'" alt="Additional Image" id="additional_images-preview-'+theID+'" class="img-thumbnail img-responsive" style="height: 150px; width: 150px;"><i data-remove="'+theID+'" class="fa fa-close"></i></div>')
                    IDs.push(theID);
                }
                // console.log('IDs', IDs)
                $('[name="additional_images"]').val(IDs.join(','));
            }
        })
        $('#select-images-modal').on('hidden.bs.modal', function(e) {
            var btn = $('[data-target="#select-images-modal"][opened="true"]');
            // console.log('closing');
            btn.removeAttr('opened');
        })
        $(document).on('click', 'i[data-remove]', function(){
            var theID = $(this).data('remove');
            IDs.splice(IDs.indexOf(theID),1);
            // console.log(IDs);
            $('[name="additional_images"]').val(IDs.join(','));
            $(this).parents('.previewer').fadeOut(300, function(){
                $(this).remove();
            });
        })



        // $('[name="base_image"]').change(function(e){
        //     renderBaseImage(this);
        // });
        // $('[name="additional_images[]"]').change(function(e){
        //     renderAdditionalImages(this);
        // });

        // function renderBaseImage(input) {
        //     if(input.files.length) {
        //         var reader = new FileReader;
        //         reader.readAsDataURL(input.files[0]);
        //         reader.onload = function(e) {
        //             $('#base_image-preview').css('display', 'inline-block').attr('src', e.target.result);
        //         }
        //     }
        // }

        // function renderAdditionalImages(input) {
        //     if(input.files.length) {
        //         $.each(input.files, function (index, value) {
        //             var reader = new FileReader;
        //             reader.readAsDataURL(value);
        //             reader.onload = function(e) {
        //                 $('[name="additional_images[]"]').after(`
        //                     <img src="`+e.target.result+`" alt="Additional Image" id="additional_images-preview-`+index+`" class="mt-2 img-thumbnail img-responsive d-inline-block" style="height: 150px; width: 150px;">
        //                 `);
        //             }
        //         })
        //     }
        // }

        $('#should-track').change(function() {
            if($(this).is(':checked')) {
                $('.stock-count').show();
            } else {
                $('.stock-count').hide();
            }
        });

        $('[name="meta_keywords[]"]').select2({
            // tags: true,
        });
    });
</script>
<script>
    $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn btn-sm' });
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            paginate: {
                previous: '<i class="fa fa-angle-left"></i>',
                first: '<i class="fa fa-angle-double-left"></i>',
                last: '<i class="fa fa-angle-double-right"></i>',
                next: '<i class="fa fa-angle-right"></i>',
            },
        },
        columnDefs: [
            // {
            //     orderable: false,
            //     className: 'select-checkbox',
            //     searchable: false,
            //     targets: 0,
            // },
            {
                orderable: false,
                searchable: false,
                targets: -1
            },
        ],
        // select: {
        //     style:    'multi+shift',
        //     selector: 'td:first-child'
        // },
        order: [],
        scrollX: true,
        pagingType: 'numbers',
        pageLength: 10,
        dom: 'lBfrtip<"actions">',
        // buttons: [
        //     {
        //         extend: 'selectAll',
        //         className: 'btn-primary',
        //         text: 'Select All',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'selectNone',
        //         className: 'btn-primary',
        //         text: 'Deselect All',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        // ],
    });
    // var dt_buttons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    // var delete_button = {
    //     text: 'Bulk Delete',
    //     url: "{{ route('api.images.destroy') }}",
    //     className: 'btn-danger',
    //     action: function(e, dt, node, config) {
    //         var IDs = $.map(dt.rows({
    //             selected: true
    //         }).nodes(), function(entry) {
    //             return $(entry).data('entry-id')
    //         });

    //         if (IDs.length === 0) {
    //             alert('Select Rows First.')

    //             return;
    //         }

    //         if (confirm('Are You Sure To Delete?')) {
    //             $.ajax({
    //                 headers: {
    //                     'x-csrf-token': "{{ csrf_token() }}"
    //                 },
    //                 method: 'POST',
    //                 url: config.url,
    //                 data: {
    //                     IDs: IDs,
    //                     _method: 'DELETE'
    //                 }
    //             })
    //             .done(function() {
    //                 $('.datatable').DataTable().ajax.reload();
    //             })
    //         }
    //     }
    // }
    // dt_buttons.push(delete_button)

    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! route('api.images.index') !!}",
        // buttons: dt_buttons,
        columns: [
            // { data: 'empty', name: 'empty' },
            { data: 'id', name: 'id' },
            { data: 'preview', name: 'preview' },
            { data: 'filename', name: 'filename' },
            { data: 'mime', name: 'mime' },
            { data: 'size', name: 'size' },
            { data: 'action', name: 'action' },
        ],
        order: [
            [0, 'desc']
        ],
    })
</script>
@endsection