$(document).ready(
    function () {

        $("#searchInput").on("keyup keypress input", function () {
            var value = this.value.toLowerCase().trim();

            $("table tr").each(function (index) {
                if (!index) return;
                $(this).find("td").each(function () {
                    var id = $(this).text().toLowerCase().trim();
                    var not_found = (id.indexOf(value) == -1);
                    $(this).closest('tr').toggle(!not_found);
                    return not_found;
                });
            });
        });
        datatTableDescription();

    });
function datatTableDescription() {

    var Servicetable1 = $("#service_table").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom": "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
    return Servicetable1;
}

setTimeout(function () {
    $('.alert').fadeOut('fast');
}, 5000);

function workFlowType(type) {
    if (type == "0") {
        $('.fullWorkflow').hide();
        $('.partialWorkflow').show();
        $('.fullWorkflow .designation ').removeAttr('required');


    } else {
        $('.partialWorkflow').hide();
        $('.fullWorkflow').show();
        $('.fullWorkflow .designation ').attr('required', true);
    }
}