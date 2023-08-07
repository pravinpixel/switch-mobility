@extends('layouts.app')

@section('content')
<style>
    table.table-bordered {
        border: 1px solid black;
        margin-top: 20px;
    }

    table.table-bordered>thead>tr>th {
        border: 1px solid black;
    }

    table.table-bordered>tbody>tr>td {
        border: 1px solid black;
    }

    .Partial-input-container .select2-selection__choice__remove {
        /* display: none !important; */

    }

    .Partial-input-container:not(:last-child) .select2 {
        /* pointer-events: none; */
    }

    .addEvents {
        pointer-events: unset !important;
    }

    .Partial-input-container:last-child .select2-selection__choice__remove {
        display: block !important;

    }

    .Partial-input-container:not(:last-child) .select2-selection__clear {
        /* display: none !important; */
    }

    .select2-selection__choice__remove.addBlock,
    .Partial-input-container button.select2-selection__clear.addBlock {
        display: block !important;
    }
</style>
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Workflow > Add</h1>
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
                        <li class="breadcrumb-item text-muted">Workflow</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Add</li>
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

                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="modal-body  mt-10">

                        <form id="department_form" class="form" method="post" action="{{url('workflow')}}">
                            @csrf


                            <!--end::Input group-->

                            <div class="row g-9 mb-7 justify-content-around">
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Workflow Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid wfCode" placeholder=" Workflow Code" name="workflow_code" required autocomplete="off" disabled />
                                    <input type="hidden" class="form-control form-control-solid wfCode" placeholder="Workflow Code" name="workflow_code" required autocomplete="off" /> <!--end::Input-->
                                    <p id="wfCodeAlert" class="notifyAlert"></p>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Workflow Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid workflow_name" name="workflow_name" autocomplete="off" placeholder="Enter Workflow Name" required>
                                    <p id="wfNameAlert" class="notifyAlert"></p>
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-3 fv-row">
                                    <label class="fs-6 fw-semibold">Workflow Type</label>
                                    <!--begin::Radio group-->
                                    <div class="nav-group nav-group-fluid">
                                        <!--begin::Option-->
                                        <label>
                                            <input type="radio" class="btn-check" name="workflow_type" value="1" checked="checked" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Full</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label>
                                            <input type="radio" class="btn-check" name="workflow_type" value="0" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-success px-4">Partial</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->


                                    </div>
                                    <!--end::Radio group-->
                                </div>
                            </div>
                            <center>
                                <div class="col-md-12 fv-row fullWorkflow">
                                    <!--begin::Variations-->
                                    <div class="card card-flush ">
                                        <!--begin::Card header-->
                                        <div class="card-header d-inline-block m-auto">
                                            <div class="card-title">
                                                <h2>Level Selection</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 col-md-8 m-auto">
                                            <!--begin::Input group-->
                                            <div class="fullLevelFlow" data-kt-ecommerce-catalog-add-product="auto-options">
                                                <!--begin::Repeater-->
                                                @for($a=0;$a<11;$a++) <div id="kt_ecommerce_add_product_options">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3">
                                                            <div data-repeater-item="" class="form-group row">
                                                                <!--begin::Select2-->
                                                                <div class="col-md-6 ">
                                                                    <select class="form-select product_option2" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option" disabled>
                                                                        <option value="">Select Level</option>
                                                                        @for($i=1;$i<12;$i++) <option value="{{$i}}" <?php echo ($i == $a + 1) ? "selected" : "" ?>>Level {{$i}}</option>
                                                                            @endfor
                                                                    </select>
                                                                </div>
                                                                <!--end::Select2-->
                                                                <!--begin::Input-->
                                                                <div class="col-md-6 fv-row">
                                                                    <select class="form-select mb-2 designation" levelCheck="{{$a + 1}}" required data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="fapprover_designation{{$a+1}}[]">
                                                                        @foreach($employeeDatas as $employeeData)

                                                                        <option value="{{$employeeData['id']}}">{{$employeeData['data']}}</option>
                                                                        @endforeach
                                                                    </select>


                                                                </div>
                                                                <!--end::Input-->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->
                                                    <!--begin::Form group-->

                                                    <!--end::Form group-->
                                            </div>
                                            @endfor
                                            <!--end::Repeater-->

                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>

                                <!--end::Variations-->
                    </div>
                    </center>
                    <div class="col-md-12 fv-row partialWorkflow" style="display:none;">
                        <!--begin::Variations-->
                        <div class="card card-flush ">
                            <!--begin::Card header-->
                            <div class="card-header d-inline-block m-auto">
                                <div class="card-title">
                                    <h2>Level Selection</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0  ">
                                <!--begin::Input group-->
                                <div class="partialLevelFlow " data-kt-ecommerce-catalog-add-product="auto-options">
                                    <!--begin::Repeater-->
                                    <div id="kt_ecommerce_add_product_options" class="Partial-input-container">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3">
                                                <div data-repeater-item="" class="form-group d-flex flex-wrap align-items-center justify-content-center gap-5">
                                                    <!--begin::Select2-->
                                                    <div class="col-md-4">
                                                        <select class="form-select product_option1" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option">
                                                            <option value="" disabled selected>Select Level</option>
                                                            @for($i=1;$i<12;$i++) <option value="{{$i}}">Level {{$i}}</option>
                                                                @endfor
                                                        </select>
                                                    </div>
                                                    <!--end::Select2-->
                                                    <!--begin::Input-->
                                                    <div class="col-md-4 fv-row">
                                                        <select class="form-select mb-2 designation" required onchange="DesChange(this)" disabled data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="approver_designation[]">
                                                            @foreach($employeeDatas as $employeeData)
                                                            <option value="{{$employeeData['id']}}">{{$employeeData['data']}}</option>
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                    <!--end::Input-->
                                                    <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger" style="visibility: hidden;" disabled>
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                        <span class="svg-icon svg-icon-1">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                    <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" disabled>
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                                <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->Add Level</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Form group-->
                                        <!--begin::Form group-->

                                        <!--end::Form group-->
                                    </div>
                                    <!--end::Repeater-->

                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>

                        <!--end::Variations-->
                    </div>
                    <!--end::Col-->
                </div>

                {{-- FORM --}}
                <div class="text-center my-5">
                    <button type="button" class="btn btn-light me-3" onclick="resetForm()">Reset</button>
                    <a href="{{route('workflow.index')}}">
                        <button type="button" class="btn btn-light-danger me-3">Cancel</button></a>
                    <button type="submit" class="btn switchPrimaryBtn  " id="submitBtn" data-kt-users-modal-action="submit">
                        <span class="indicator-label">Save and Exit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

                </form>

            </div>
        </div>
    </div>
</div>
</div>
<script>
    function DesChange(evt) {
        let nameAttr = $(evt).attr("name").match(/\d+/)[0]; //get numbers only here
        let evtValue = $(evt).find('option:selected');
        let evtValueAll = evtValue.map(function() {
            return $(this).val();
        }).get();

        let Options = $(`select[levelCheck=${nameAttr}]`).find('option');

        $.each(Options, function(i, option) {
            let optionValue = $(option).val();

            if (evtValueAll.includes(optionValue)) {
                $(option).attr('selected', true);

            } else {
                $(option).removeAttr('selected');
            }
        });
        $(`select[levelCheck=${nameAttr}]`).select2();
    }
</script>
<script>
    function resetForm() {

        console.log("wrt");
        console.log($(".product_option1 option:disabled"));
        // $("#department_form")[0].reset();
        $('.wfCode').val('');
        $('.workflow_name').val('');

        let remo = $('.partial-input-container').not(':first');
        $.each(remo, function(indexInArray, reo) {
            $(reo).remove();
            console.log($(reo));
        });

        $(".partialWorkflow select option").removeAttr('selected');

        $(".partialWorkflow select option:first-child").attr('selected', 'true');
        $(".partialWorkflow select option").show();
        $(".removeBtn").last().after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button>`);
        $(".removeBtn").last().remove();
        $('.partialWorkflow .designation').attr("disabled", true);
        $('.designation').select2();
        $('.designation').val('').trigger('change');



    }
    $(document).ready(function() {
        // on form submit

        $("#department_form1").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        });
        $('select[multiple]').multiselect();
    });
    $(document).on('blur', '.wfCode', function() {
        console.log($(this).val());
        $.ajax({
            url: "{{ route('workflowValidation') }}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                code: $(this).val(),
                id: "",
            },
            success: function(data) {
                var alertName = 'wfCodeAlert';
                console.log(data.response);
                console.log(alertName);

                if (data.response == false) {
                    $('#submitBtn').attr('disabled', true);

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Code Is Exists*';
                    return false;
                }
                document.getElementById(alertName).style.display = "none";
                $('#submitBtn').attr('disabled', false);
                return true;


            },
            error: function() {
                $("#otp_error").text("Update Error");
            }

        });

    });
    $(document).on('change', '.btn-check', function() {
        console.log($(this).val());
        if ($(this).val() == 0) {
            $(".fullWorkflow select").removeAttr("required");
            $(".partialWorkflow select").attr("required", true);

            console.log($(".partialWorkflow select"));
        } else {
            $(".partialWorkflow select").removeAttr("required");
            $(".fullWorkflow select").attr("required", true);

        }
        workFlowType($(this).val());

    });

    $(document).on('click', '.removeLevelRow', function() {
        // $(".addLevel").attr("disabled", true);
        console.log("removeLevelRow");
        if ($(this).val()) {
            $('.addLevel').removeAttr('disabled');
        }

    });

    var partialLevelSelect;
    var selectedOptions;

    $(document).on('change', '.product_option1', function() {
        $(".addLevel").attr("disabled", true);
        // console.log($(this).val());
        if ($(this).val()) {

            $('.addLevel').removeAttr('disabled');
            $(this).parent().next().find('.designation').removeAttr('disabled');
            let designationElem = $(this).parent().next().find('.designation');
            let evtSetName = designationElem.attr("name");
            let evtSetNum = parseInt(evtSetName.match(/\d+/));
            if (isNaN(evtSetNum)) {
                evtSetNum = false;
            }

            if (evtSetNum != false) {
                let emptySelects = $(`select[levelCheck=${evtSetNum}]`).find('option');

                $.each(emptySelects, function(i, option) {

                    $(option).removeAttr('selected');

                });
                $(`select[levelCheck=${evtSetNum}]`).select2();
            }
            $(this).parent().next().find('.designation').attr("name", "approver_designation" + this.value + "[]").end();
        }


        let evt = $(this).parent().next().find('.designation');
        let nameAttr = $(evt).attr("name").match(/\d+/)[0]; //get numbers only here
        let evtValue = $(evt).find('option:selected');
        let evtValueAll = evtValue.map(function() {
            return $(this).val();

        }).get();

        let Options = $(`select[levelCheck=${nameAttr}]`).find('option');

        $.each(Options, function(i, option) {
            let optionValue = $(option).val();

            if (evtValueAll.includes(optionValue)) {
                $(option).attr('selected', true);

            } else {
                $(option).removeAttr('selected');
            }
        });
        $(`select[levelCheck=${nameAttr}]`).select2();

        partialLevelSelect = $(".product_option1");
        selectedOptions = partialLevelSelect.map(function() {
            return $(this).val();
        }).get();
        if (selectedOptions[selectedOptions.length - 1] === "") {
            selectedOptions.pop();
        }

        for (let i = 0; i < partialLevelSelect.length; i++) {
            if (i == 0) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                let newArray = [];
                for (let i = 1; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {


                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }


            } else if (i == partialLevelSelect.length - 1) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                // let nextArray = parseInt(selectedOptions[ya]) - 1 ;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= 11; i++) {
                    newArray.push(i.toString());
                }



                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            } else {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                if (isNaN(nextArray)) {
                    nextArray = 11;
                }
                let prevArray = parseInt(selectedOptions[xa]) + 1;
                console.log(nextArray);
                console.log(prevArray);
                let newArray = [];
                for (let i = prevArray; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            }
        }

        var checkOption = $(".product_option1");
        if ($(this).val() == 11) {




            if (checkOption.length != 1) {


                $(".addLevel").hide();
                $(".addLevel").prev(".removeBtnsm").css("visibility", "hidden").css("pointer-events", "none");
                $(".addLevel").after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-danger  " onclick="RemoveFunctionb(this)" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" /><rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" /></svg> </span> <!--end::Svg Icon-->Remove</button>`);
            } else {
                $(".addLevel").hide();
            }

        } else if ($(checkOption[checkOption.length - 1]).val() != "11") {


            if (checkOption.length != 1) {
                $(".addLevel").prev(".removeBtnsm").css("visibility", "visible").css("pointer-events", "all");
                $(".addLevel").show();
                $(".addLevel").next().remove();
            } else {
                $(".addLevel").show();
            }

        }
    });

    $(document).on('click', '.addLevel', function() {

        if ($(this).prev().prev().children("select").val() == "") {
            return false;
        }


        $(this).after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-danger removeBtn" onclick="RemoveFunction(this)" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" /><rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" /></svg> </span> <!--end::Svg Icon-->Remove</button>`);

        $(this).prev().css("visibility", "hidden");



        var uniqueId = Date.now();
        $(".partialLevelFlow").last().append('<div id="kt_ecommerce_add_product_options" class="Partial-input-container append-elements"> <!--begin::Form group--> <div class="form-group"> <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3"> <div data-repeater-item="" class="form-group d-flex flex-wrap align-items-center justify-content-center gap-5"> <!--begin::Select2--> <div class="col-md-4"> <select class="form-select product_option1" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option" required> <option value=""  selected disabled>Select Level</option> @for($i=1;$i<12;$i++) <option value="{{$i}}">Level {{$i}}</option> @endfor </select> </div> <!--end::Select2--> <!--begin::Input--> <div class="col-md-4 fv-row"> <select class="form-select mb-2 designation" onchange="DesChange(this)"  disabled id="' + uniqueId + '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple"  name="approver_designation[]" required> @foreach($employeeDatas as $employeeData) <option value="{{$employeeData['id']}}">{{$employeeData['data']}}</option> @endforeach </select> </div> <!--end::Input--> <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger removeBtnsm" onclick="RemoveFunctionc(this)" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg--> <span class="svg-icon svg-icon-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" /> <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" /> </svg> </span> <!--end::Svg Icon--> </button> <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" disabled> <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button> </div> </div> </div> <!--end::Form group--> <!--begin::Form group--> <!--end::Form group--> </div>');
        $("#" + uniqueId).select2();
        $(this).remove();
        $(".addBlock").toggleClass("addBlock");
        $(".addEvents").toggleClass("addEvents");

        partialLevelSelect = $(".product_option1");
        selectedOptions = partialLevelSelect.map(function() {
            return $(this).val();
        }).get();
        if (selectedOptions[selectedOptions.length - 1] === "") {
            selectedOptions.pop();
        }

        for (let i = 0; i < partialLevelSelect.length; i++) {
            if (i == 0) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                let newArray = [];
                for (let i = 1; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {


                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }


            } else if (i == partialLevelSelect.length - 1) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                // let nextArray = parseInt(selectedOptions[ya]) - 1 ;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= 11; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");

                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            } else {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");

                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            }
        }

    });

    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5000);

    $(document).ready(
        function() {
            $('#service_table').DataTable({
                filter: true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "searching": true,
            });

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
                    url: "{{url('department')}}" + "/" + id,
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
                        'Department has been deleted.',
                        'success'
                    );

                }
            }
        });
    }

    function RemoveFunction(e) {
        $(e).parent().parent().parent().parent().find('.designation').val('').trigger('change');
        $(e).parent().parent().parent().parent().remove();

        $(".Partial-input-container").first().find(".removeBtnsm").css("visibility", "hidden").css("pointer-events", "none");
        partialLevelSelect = $(".product_option1");
        selectedOptions = partialLevelSelect.map(function() {
            return $(this).val();
        }).get();
        if (selectedOptions[selectedOptions.length - 1] === "") {
            selectedOptions.pop();
        }

        for (let i = 0; i < partialLevelSelect.length; i++) {
            if (i == 0) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                if (isNaN(nextArray)) {
                    nextArray = 11;
                }
                let newArray = [];
                for (let i = 1; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {


                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }


            } else if (i == partialLevelSelect.length - 1) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                // let nextArray = parseInt(selectedOptions[ya]) - 1 ;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= 11; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            } else {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            }
        }
    }

    function RemoveFunctionb(e) {
        if ($(e).parent().parent().parent().parent().length > 0) {
            var $designation = $(e).parent().parent().parent().parent().find('.designation');
            if ($designation.length > 0) {
                $designation.val('').trigger('change');
            }
        }
        $(".removeBtn").last().after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button>`);
        $(".removeBtn").last().remove();
        $(e).parent().parent().parent().parent().remove();
        $(".Partial-input-container").first().find(".removeBtnsm").css("visibility", "hidden").css("pointer-events", "none");


        partialLevelSelect = $(".product_option1");
        selectedOptions = partialLevelSelect.map(function() {
            return $(this).val();
        }).get();
        if (selectedOptions[selectedOptions.length - 1] === "") {
            selectedOptions.pop();
        }

        for (let i = 0; i < partialLevelSelect.length; i++) {
            if (i == 0) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                if (isNaN(nextArray)) {
                    nextArray = 11;
                }
                let newArray = [];
                for (let i = 1; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {


                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }


            } else if (i == partialLevelSelect.length - 1) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                // let nextArray = parseInt(selectedOptions[ya]) - 1 ;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= 11; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            } else {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            }
        }


    }


    function RemoveFunctionc(e) {
        if ($(e).parent().parent().parent().parent().length > 0) {
            var $designation = $(e).parent().parent().parent().parent().find('.designation').not(':disabled');

            if ($designation.length > 0) {

                $designation.val('').trigger('change');
            }
        }
        $(".removeBtn").last().after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button>`);
        $(".removeBtn").last().prev(".removeBtnsm").css("visibility", "visible").prop("disabled", false);
        $(".removeBtn").last().remove();
        $(e).parent().parent().parent().parent().remove();
        $(".Partial-input-container").first().find(".removeBtnsm").css("visibility", "hidden").css("pointer-events", "none");

        //  let lastContainer=$(".Partial-input-container").last();
        $(".select2").last().addClass("addEvents");

        $(" .select2-selection__choice__remove").last().addClass("addBlock");

        $(" .select2-selection__clear").last().addClass("addBlock");



        partialLevelSelect = $(".product_option1");
        selectedOptions = partialLevelSelect.map(function() {
            return $(this).val();
        }).get();
        if (selectedOptions[selectedOptions.length - 1] === "") {
            selectedOptions.pop();
        }

        for (let i = 0; i < partialLevelSelect.length; i++) {
            if (i == 0) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;
                if (isNaN(nextArray)) {
                    nextArray = 11;
                }
                let newArray = [];
                for (let i = 1; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {


                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }


            } else if (i == partialLevelSelect.length - 1) {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                // let nextArray = parseInt(selectedOptions[ya]) - 1 ;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= 11; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            } else {
                let element = partialLevelSelect[i];
                // let selectedValue = selectedOptions[i];
                let selectedValue = selectedOptions[i];
                let ya = i + 1;
                let xa = i - 1;
                let nextArray = parseInt(selectedOptions[ya]) - 1;

                let prevArray = parseInt(selectedOptions[xa]) + 1;

                let newArray = [];
                for (let i = prevArray; i <= nextArray; i++) {
                    newArray.push(i.toString());
                }


                if (newArray.length != 0) {
                    $(partialLevelSelect[i]).find("option").each(function() {
                        let Value = $(this).val().toString();

                        if (Value != "") {
                            if (newArray.includes(Value)) {
                                $(this).prop("disabled", false);
                                $(this).css("display", "block");
                            } else {
                                $(this).prop("disabled", true);
                                $(this).css("display", "none");
                            }
                        }


                    });
                }

            }
        }
    }
    $(document).on('input', '.workflow_name', function() {
        var wfname = $('.workflow_name').val();
       if(wfname){
        $.ajax({
            url: "{{url('getWorkflowCodeFormat')}}",
            type: 'ajax',
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                wfname: wfname,
            },
            success: function(result) {
                $('.wfCode').val("");
                var alertName = "wfNameAlert";
                if (result.status == "success") {

                    $('.wfCode').val(result.data);
                    document.getElementById(alertName).style.display = "none";
                    $('#submitBtn').attr('disabled', false);
                    return true;
                } else {
                    $('#submitBtn').attr('disabled', true);

                    document.getElementById(alertName).style.display = "block";
                    document.getElementById(alertName).style.color = "red";
                    document.getElementById(alertName).innerHTML = 'Name Is Exists*';
                    return false;
                }

                $('.wfCode').val(result);
            }
        });
    }
    });
</script>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


<!-- MultiSelect CSS & JS library -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

<script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>