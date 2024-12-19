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
        <div class="shadow-sm card rounded-0">
            <div class="card-header">Edit <strong>Product</strong></div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        @csrf
                        @method("PATCH")
                        @include('admin.products.form')
                    </div>
                </form>
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
        var ID = {{ $product->baseImage()->id ?? 0 }};
        var IDs = {!! json_encode($product->additional_images->pluck('id')->toArray()) !!};
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

        $('[name="meta_keywords[]"]').select2();
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