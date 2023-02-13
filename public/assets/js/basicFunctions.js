$(document).ready(
    function () {
        console.log('when');
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
    });
    function workFlowType(type){
        if (type == "0") {
            $('.fullWorkflow').hide();
            $('.partialWorkflow').show();


        } else {
            $('.partialWorkflow').hide();
            $('.fullWorkflow').show();

        }
    }