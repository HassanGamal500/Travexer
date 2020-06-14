<!-- BEGIN VENDOR JS-->
<script src="{{asset('theme-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/forms/toggle/switchery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/js/scripts/forms/switch.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
{{-- @if(Request::is('admin'))
<script src="{{asset('theme-assets/vendors/js/charts/chartist.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/charts/chartist-plugin-tooltip.min.js')}}" type="text/javascript"></script>
@endif --}}
<script src="{{asset('theme-assets/vendors/js/timeline/horizontal-timeline.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/extensions/dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/editors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
{{-- <script src="{{asset('theme-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script> --}}
{{-- <script src="{{asset('theme-assets/vendors/js/extensions/sweetalert2.all.js')}}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN CHAMELEON  JS-->
<!-- <script src="theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
<script src="theme-assets/js/core/app-lite.js" type="text/javascript"></script> -->
<script src="{{asset('theme-assets/js/core/app-menu.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/js/core/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/js/scripts/customizer.min.js')}}" type="text/javascript"></script>
<script src="{{asset('theme-assets/vendors/js/jquery.sharrre.js')}}" type="text/javascript"></script>
<!-- END CHAMELEON  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- <script src="theme-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script> -->
{{-- @if(Request::is('admin'))
<script src="{{asset('theme-assets/js/scripts/pages/dashboard-ecommerce.min.js')}}" type="text/javascript"></script>
@endif --}}
<script src="{{asset('theme-assets/js/scripts/forms/validation/form-validation.js')}}" type="text/javascript"></script>
{{-- <script src="{{asset('theme-assets/js/scripts/extensions/sweet-alerts.min.js')}}" type="text/javascript"></script> --}}
<script src="{{asset('theme-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
@if(Request::is('admin/edit/*'))
<script src="{{asset('theme-assets/js/scripts/editors/editor-ckeditor.min.js')}}" type="text/javascript"></script>
@endif
<script src="{{asset('theme-assets/js/scripts/forms/checkbox-radio.min.js')}}" type="text/javascript"></script>
{{-- <script src="{{asset('theme-assets/js/scripts/forms/select/form-select2.min.js')}}" type="text/javascript"></script> --}}
<!--Select 2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- END PAGE LEVEL JS-->


{{-- <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js"></script>

<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-messaging.js"></script> --}}


<noscript>
    <style type="text/css">
        .app-content {display:none;}
        .main-menu {display: none;}
        .header-navbar {display: none;}
        .footer {display: none;}
    </style>
    <div class="text-center">
        <h1>You don't have javascript enabled.  Good luck with that.</h1>
    </div>
    <script>
        const myNode = document.getElementsByClassName("app-content");
        myNode.innerHTML = '';
    </script>
</noscript>
<script>
    
    $('.zero-configuration').DataTable();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Activate
    $('.datatable').on('change', '.toggle-class', function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var id = $(this).data('id'); 
        var type = $(this).data('type'); 
         
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('admin/changeStatus')}}',
            data: {'status': status, 'id': id, 'type': type},
            success: function(data){
            //   console.log(data.success)
            }
        });
    })

    // Cities  
    $('.country_id').on('click', function() {
        var type = $(this).val(); 
        // var id = $(this).data('id'); 
        console.log(type);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url('admin/get_city')}}',
            data: {'country_id': type},
            success: function(data){
                var append = "<option value='' disabled selected>{{trans('admin.select city')}}</option>";
                for (i = 0; i < data.length; i++) {
                    append += "<option value='"+ data[i].id +"'>"+ data[i].name +"</option>"
                }
                $('.city_id').html(append);
            }
        });
    })

    //Alert Delete
    $(document).on('click', '.alerts', function(e){
        var url = $(this).data("url");
        var id = $(this).data("id");
        var table = '.' + $(this).data('table');
        var thisClick = $(this).parents('tr');
        e.preventDefault();
        console.log(url);
        swal({
            title: "{{trans('admin.sure')}}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })

        .then((willDelete) => {
            if (willDelete) {
                swal("{{trans('admin.will delete')}}", {
                    icon: "success",
                });
                $.ajax({
                    type: 'DELETE',
                    url: url+id,
                    data: {id: id},
                    success:function(data){
                        // location.reload();
                        var datatable = $(table).DataTable();
                        datatable.row(thisClick).remove().draw();
                    }
                });
            } else {
                swal("{{trans('admin.not delete')}}");
            }
        });
    });

    //Details Broadcast
    $(document).on('click', '.get_broadcast', function() {
        var id = $(this).attr("data-id");
        // console.log(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{url(route('get_broadcast'))}}',
            data: {'id': id},
            success: function(data){
                // console.log(data);
                $(".name").text(data.user_name);
                $(".email").text(data.email);
                $(".phone").text(data.phone);
                $(".date").text(data.date);
                $(".start").text(data.start);
                $(".end").text(data.end);
                $(".service").text(data.service_name);
                $(".country").text(data.country_name);
                $(".city").text(data.city_name);
                $(".note").text(data.note);
                $('.modal_broadcast').modal('show');
            }
        });
    });

    $(".searchOption2").select2( {
        placeholder: "Select Email",
        allowClear: true,
        width: 'resolve'
    });

    //Notification
    $('#selectOption').on('change', function(){
        if ($(this).val() == '5') {
            // $('#notEmail').removeAttr('disabled');
            $('#show_hide_2').hide(900);
            $('#show_hide_3').hide(900);
            $('.one').attr('name', 'email');
            $('.two').attr('name', '');
            $('.three').attr('name', '');
            $('#show_hide_1').show(1000);
        } else if($(this).val() == '6') {
            $('#show_hide_1').hide(900);
            $('#show_hide_3').hide(900);
            $('.one').attr('name', '');
            $('.two').attr('name', 'email');
            $('.three').attr('name', '');
            $('#show_hide_2').show(1000);
        } else if($(this).val() == '7') {
            $('#show_hide_1').hide(900);
            $('#show_hide_2').hide(900);
            $('.one').attr('name', '');
            $('.two').attr('name', '');
            $('.three').attr('name', 'email');
            $('#show_hide_3').show(1000);
        } else {
            // $('#notEmail').attr('disabled', 'disabled');
            $('#show_hide_1').hide(1000);
            $('#show_hide_2').hide(1000);
            $('#show_hide_3').hide(1000);
        }
    });

    //Print
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

        
</script>