@extends('layouts.app')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">User
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Users</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">List</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="card-header border-0 pt-6 add-button-datatable">

                        <div class="card-title">

                        </div>

                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->

                                <!--begin::Add user-->
                                @if (auth()->user()->is_super_admin == 1 ||
                                auth()->user()->can('user-create'))
                                <a href="{{ route('users.create') }}">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <button type="button" class="btn switchPrimaryBtn ">
                                        {{-- <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span> --}}
                                        <!--end::Svg Icon-->+ Add
                                    </button>

                                </a>
                                @endif
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->


                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body  p-3">
                        <div class="card-title">

                        </div>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered fs-6 gy-5" id="service_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">


                                    <th class="min-w-125px">Name</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
{{-- <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
</script> --}}
<script data-require="jquery@*" data-semver="3.0.0" src="https://code.jquery.com/jquery-3.7.1.js"></script>
{{-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script> --}}


<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function() {
        userList();
        // on form submit
        $(".initiator_id").select2({
            dropdownParent: $("#kt_modal_add_user")
        });



        $("#department_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
        $(".initiator_id").on('change', function() {
            var employeeId = $(this).val();

            $('.submit').prop('disabled', true);

            if (employeeId) {
                $.ajax({
                    url: "{{ route('getEmployeeDetailByParams') }}",
                    type: 'ajax',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        fieldname: 'EmpId',
                        fieldData: employeeId,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);

                        console.log(data);
                        $(".name,.mobile,.email").val("");
                        if (data) {
                            if (data.user) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'This Sap-Id already in Users!',
                                    footer: ''
                                });
                                $('.submit').prop('disabled', true);
                                $(".sapId,.name,.mobile,.email").val("");
                            } else {
                                $('.submit').prop('disabled', false);
                                var name = data.first_name + " " + data.middle_name + " " + data.last_name;
                                $(".name").val(name);

                                $(".mobile").val(data.mobile);
                                $(".email").val(data.email);
                            }
                        } // $(".designation").val(data[0].designation_name);
                    }
                });
            }
        });

        $(document).on('click', '.editPage', function() {
            var id = $(this).attr('id');
            var url = "{{route('userEdit')}}";
            var form = $('<form action="' + url + '" method="post">' +
                ' {{ csrf_field() }} <input type="hidden" name="id" value="' + id + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();

        });
        $('.search').on('input', function() {
            var searchData = $('.search').val();

            $.ajax({
                url: "{{ route('UserSearch') }}",
                type: 'ajax',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    searchData: searchData,
                },
                success: function(data) {
                    table.clear().draw();
                    $.each(data, function(key, val) {
                        var sNo = key + 1;
                        var id = val.id;
                        var name = val.name;
                        var editurl = '{{ route("users.edit", ":id") }}';
                        editurl = editurl.replace(':id', id);
                        var editBtn = (
                            '<a href="' + editurl +
                            '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" /><path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" /></svg> </span></span></a>'
                        );
                        var Action = (editBtn +
                            '<a class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" href="javascript:void(0);" class="menu-link px-3" onclick="delete_item(' +
                            id +
                            ')"><span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" /></svg></span></a>'
                        );
                        table.row.add([sNo, name, Action]).draw();
                    });
                },
                error: function() {
                    $("#otp_error").text("Update Error");
                }

            });


        });

    });


    $("#other").click(function() {
        $("#target").submit();
    });

    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5000);
    $(document).ready(function() {

        $('[name="all_permission"]').on('click', function() {

            if ($(this).is(':checked')) {
                $.each($('.permission'), function() {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($('.permission'), function() {
                    $(this).prop('checked', false);
                });
            }

        });


    });

    function userList() {
        // return false;
 var table = $('#service_table').DataTable();

    // Destroy the existing DataTable instance
    // if ($.fn.DataTable.isDataTable('#service_table')) {
    //     table.destroy();
    // }

    // // Reinitialize DataTable
    // table = $('#service_table').DataTable({
    //     "paging": true, // Change as needed
    //     "lengthChange": true,
    //     "searching": true,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    // });
        $.ajax({
            url: "{{ url('userIndex') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",

            },
            success: function(result) {
                var data = result;
                table.clear().draw();
                $.each(data, function(key, val) {


                    var sNo = key + 1;
                    var id = val.id;
                    var name = val.name;
                    var editurl = '{{ route("users.edit", ":id") }}';
                    editurl = editurl.replace(':id', id);
                    var editBtn = ('<a class="editPage" style="display:inline;cursor: pointer;" id="' + id + '" title="Edit User"><i class="fa-solid fa-pen" style="color:orange"></i></a>');
                    var deleteBtn = (
                        '<div id="' + id + '"  class="deleteEmployee"  style="display:inline;cursor: pointer;margin-left: 10px;" title="Delete User"><i class="fa-solid fa-trash" style="color:red"></i></div>'
                    );
                    var Action = (editBtn + deleteBtn);
                    table.row.add([name, Action]).draw();
                });
                // if (result) {
                //     window.location.reload();
                // }
            }
        });

    }
    $(document).on('click', '.deleteEmployee', function() {
        var id = $(this).attr('id');
        delete_item(id);
    });

    function delete_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3565ed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(isConfirmed => {
            if (isConfirmed.value) {
                $.ajax({
                    url: "{{ url('users') }}" + "/" + id,
                    type: 'ajax',
                    method: 'delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(result) {
                        if (result) {
                            window.location.reload();
                        }
                    }
                });
                if (isConfirmed.value) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    );

                }
            }
        });
    }
</script>
