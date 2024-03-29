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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Workflow > Edit</h1>
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
                        <li class="breadcrumb-item text-muted">Edit</li>
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
                    <div class="modal-body mt-10">

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
                                    <input type="hidden" class="form-control form-control-solid" name="workflow_id" value="{{$modelWorkflow->id}}">
                                    <!--end::Input-->
                                    <input type="hidden" class="form-control form-control-solid" placeholder="Enter Workflow Code" name="workflow_code" required autocomplete="off" value="{{$modelWorkflow->workflow_code}}">
                                    <input type="text" class="form-control form-control-solid" placeholder="Enter Workflow Code" name="workflow_code" required autocomplete="off" value="{{$modelWorkflow->workflow_code}}" disabled>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-3 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">Workflow Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" readonly name="workflow_name" autocomplete="off" placeholder="Enter Workflow Name" value="{{$modelWorkflow->workflow_name}}">

                                    <!--end::Input-->
                                </div>
                                <div class="col-md-3 fv-row">
                                    <label class="fs-6 fw-semibold">Workflow Type</label>
                                    <!--begin::Radio group-->
                                    <div class="nav-group nav-group-fluid">
                                        <!--begin::Option-->
                                        <label>
                                            <input type="radio" class="btn-check" name="workflow_type" value="1" <?php echo ($modelWorkflow->workflow_type == 1) ? "checked" : "" ?> />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Full</span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <label>
                                            <input type="radio" class="btn-check" name="workflow_type" value="0" <?php echo ($modelWorkflow->workflow_type == 0) ? "checked" : "" ?> />
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
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header d-inline-block m-auto">
                                            <div class="card-title">
                                                <h2>Level Selection</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="fullLevelFlow" data-kt-ecommerce-catalog-add-product="auto-options">
                                                <!--begin::Repeater-->
                                                <?php
                                                $arrayN=0;
                                                ?>
                                                @for($k=0;$k<11;$k++)

                                                        <div id="kt_ecommerce_add_product_options1">
                                                            <?php $a = 11;
                                                                $b = $a - 1; ?>
                                                            <!--begin::Form group-->
                                                            <div class="form-group">
                                                                <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3">
                                                                    <div data-repeater-item="" class="form-group d-flex flex-wrap align-items-center justify-content-center gap-5">
                                                                        <!--begin::Select2-->
                                                                        <div class="col-md-4">
                                                                            <select class="form-select product_option2" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option" disabled>
                                                                                <option value="">Select Level</option>
                                                                                @for($i=1;$i<12;$i++) <option value="{{$i}}" <?php echo ($k+1 >= $i) ? "selected" : ""; ?> >Level {{$i}}</option>
                                                                                    @endfor
                                                                            </select>
                                                                        </div>
                                                                        <!--end::Select2-->
                                                                        <!--begin::Input-->
                                                                        <div class="col-md-4 fv-row">
                                                                            <select class="form-select mb-2 designation" levelCheck="{{$k + 1}}" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="fapprover_designation{{$k+1}}[]">

                                                                                <?php
                                                                                // $arrayN=0;
                                                                                $designLoops=[];
                                                                                $arrayLength = count($entities);
                                                                                if ($k+1 == $entities[$arrayN]["levelId"] ) {


                                                                                   $designLoops=$entities[$arrayN]["designationId"];
                                                                                   $arrayN = $arrayN + 1;
                                                                                   if ($arrayN == $arrayLength) {
                                                                                       $arrayN=0;
                                                                                    }



                                                                                }
                                                                                // $option = ['designationId'];
                                                                                // $selectedAttribute = '';      ?>

                                                                                @foreach($employeeDatas as $employeeData)




                                                                                <option value="{{$employeeData['id']}}" <?php if (in_array($employeeData['id'], $designLoops)) {
                                                                                    echo "selected ";
                                                                                } ?>    >{{$employeeData['data']}}</option>
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
                                            </div>
                                            <!--end::Repeater-->

                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                            </center>
                            <div class="col-md-12 fv-row partialWorkflow" style="display:none;">
                                <!--begin::Variations-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header d-inline-block m-auto">
                                        <div class="card-title">
                                            <h2>Level Selection</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="partialLevelFlow" data-kt-ecommerce-catalog-add-product="auto-options">
                                            <!--begin::Repeater-->
                                            @for($k=0;$k<count($entities);$k++)

                                            <div id="kt_ecommerce_add_product_options1" class="Partial-input-container">
                                                <?php $a = count($entities);
                                                    $b = $a - 1; ?>
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3">
                                                        <div data-repeater-item="" class="form-group d-flex flex-wrap align-items-center justify-content-center gap-5">
                                                            <!--begin::Select2-->
                                                            <div class="col-md-4">
                                                                <select required class="form-select product_option1" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option">
                                                                    <option value="">Select Level</option>
                                                                    @for($i=1;$i<12;$i++) <option value="{{$i}}" <?php echo ($entities[$k]['levelId'] == $i) ? "selected" : ""; ?>>Level {{$i}}</option>
                                                                        @endfor
                                                                </select>
                                                            </div>
                                                            <!--end::Select2-->
                                                            <!--begin::Input-->
                                                            <div class="col-md-4 fv-row">
                                                                <select required class="form-select mb-2 designation"  onchange="DesChange(this)" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="approver_designation{{$entities[$k]['levelId']}}[]">
                                                                    @foreach($employeeDatas as $employeeData)

                                                                    <?php $option = $entities[$k]['designationId'];
                                                                    $selectedAttribute = '';
                                                                    if (in_array($employeeData['id'], $option)) {
                                                                        $selectedAttribute = 'selected';
                                                                    }

                                                                    $selectedAttribute1 = ($option == $employeeData['id'] )? 'selected' : 'no'; ?>
                                                                    <option value="{{$employeeData['id']}}" <?php echo $selectedAttribute; ?>>{{$employeeData['data']}}</option>
                                                                    @endforeach
                                                                </select>


                                                            </div>
                                                            <!--end::Input-->
                                                            @if($k !=$b)
                                                            <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger" style="visibility: hidden;" onclick="RemoveFunctionc(this)" disabled>
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-1">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
                                                            <button type="button" data-repeater-create="" class="btn btn-sm btn-light-danger removeBtn" onclick="RemoveFunction(this)">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" /></svg> </span>
                                                                <!--end::Svg Icon-->Remove</button>
                                                            @else
                                                            <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger" style="visibility: hidden;"  onclick="RemoveFunctionc(this)">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-1">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
                                                            <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                                        <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->Add Level</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->
                                                <!--begin::Form group-->

                                                <!--end::Form group-->
                                            </div>
                                                @endfor
                                        </div>
                                        <!--end::Repeater-->

                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card header-->
                            </div>

                            <!--end::Variations-->

                            <!--end::Col-->


                            {{-- FORM --}}
                            <div class="text-center">
                            <a href="{{route('workflow.index')}}" class=" ">
                                    <button type="button" class="btn btn-light-danger me-3  mt-5">Cancel</button></a>
                                <button type="submit" class="btn switchPrimaryBtn mt-5 " data-kt-users-modal-action="submit">
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
        $("form").on("reset", function() {
            // code to run when form is reset
            location.reload();
        });
        var checkOption = $(".product_option1");
        if ($(checkOption[checkOption.length - 1]).val() == 11) {
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
    </script>
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
    @endsection
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


    <!-- MultiSelect CSS & JS library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

    <!-- <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script> -->


<script data-require="jquery@*" data-semver="3.0.0" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script> --}}


<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // on form submit
            $("#department_form1").on('submit', function() {
                // to each unchecked checkbox
                $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
            });
            $('select[multiple]').multiselect();

        });

        $(document).on('change', '.btn-check', function() {
            workFlowType($(this).val());
            console.log($(this).val());
            if ($(this).val() == 0) {
$(".fullWorkflow select").removeAttr("required");
$(".partialWorkflow select").attr("required");
            }
            else{
                $(".partialWorkflow select").removeAttr("required");
                $(".fullWorkflow select").attr("required");
            }
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

            let evt=$(this).parent().next().find('.designation');
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

             checkOption = $(".product_option1");
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
            $(".partialLevelFlow").last().append('<div id="kt_ecommerce_add_product_options1" class="Partial-input-container append-elements"> <!--begin::Form group--> <div class="form-group"> <div data-repeater-list="kt_ecommerce_add_product_options" class="d-flex flex-column gap-3"> <div data-repeater-item="" class="form-group d-flex flex-wrap align-items-center justify-content-center gap-5"> <!--begin::Select2--> <div class="col-md-4"> <select class="form-select product_option1" name="levels[]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option" required> <option value="" selected disabled>Select Level</option> @for($i=1;$i<12;$i++) <option value="{{$i}}">Level {{$i}}</option> @endfor </select> </div> <!--end::Select2--> <!--begin::Input--> <div class="col-md-4 fv-row"> <select class="form-select mb-2 designation" disabled onchange="DesChange(this)"  id="' + uniqueId + '" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple"  name="approver_designation[]" required> @foreach($employeeDatas as $employeeData) <option value="{{$employeeData['id']}}">{{$employeeData['data']}}</option> @endforeach </select> </div> <!--end::Input--> <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger removeBtnsm" onclick="RemoveFunctionc(this)" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg--> <span class="svg-icon svg-icon-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" /> <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" /> </svg> </span> <!--end::Svg Icon--> </button> <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" disabled> <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button> </div> </div> </div> <!--end::Form group--> <!--begin::Form group--> <!--end::Form group--> </div>');
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

                var t = "{{$modelWorkflow->workflow_type}}";
                workFlowType(t);
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
            Swal.fire({
            title: 'Confirm Deletion',
            text: 'Are you sure you want to Remove this Level?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {
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
        }});
    }

        function RemoveFunctionb(e) {
            $(".removeBtn").last().after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button>`);
            $(".removeBtn").last().prev().css("visibility","visible");
            $(".removeBtn").last().prev().prop("disabled",false);
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
            $(".removeBtn").last().after(`<button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary addLevel" > <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg--> <span class="svg-icon svg-icon-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" /> <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" /> </svg> </span> <!--end::Svg Icon-->Add Level</button>`);
            $(".removeBtn").last().prev().css("visibility", "visible").prop("disabled", false);
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

    </script>
