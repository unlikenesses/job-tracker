$(function() {

    /* Apply summernote plugin to selected textarea fields */
    $('#editArticle').summernote({height: 200})

    /* Apply datepicker plugin to selected date fields */
    $('.datepicker').datepicker({'dateFormat':'dd-mm-yy'});

    /* Handle ticking job checkboxes in invoice view                 */
    /* Add or subtract the amount of that job from the invoice total */
    $('.jobs_checkboxes').change(function() {
        var amount = parseInt($(this).attr('id').replace('amount', ''));
        var total = $('input[name=amount]').val();
        if (total == '') { total = 0; } else { total = parseInt(total); }
        if (this.checked) {
            var newTotal = total + amount;
        } else {
            var newTotal = total - amount;
        }
        $('input[name=amount]').val(newTotal);
    });

    /* Check or uncheck all jobs in the invoice view */
    $('a.invertJobs').on('click', function(e) {
        e.preventDefault();
        if ($('span', this).html() == 'Check All') {
            $('span', this).html('Uncheck All');
        } else {
            $('span', this).html('Check All');
        }
        $('input[name="jobs[]"]:visible').trigger('click');
    });

    /* In the invoice view only show jobs for selected client */
    /* when the client dropdown is changed                    */
    $('#invoiceClientSelect').change(function() {
        var clientId = $(this).val();
        $('.invoiceJob').show();
        $('.invoiceJob:not([data-client=' + clientId + '])').hide();
    });

    /* Autosubmit form when client filter dropdown is changed */
    $('select[name="clientId"]').change(function() {
        this.form.submit();
    });

    /* When creating a job autopopulate project dropdown when changing client dropdown */
    $('select[name="client_id"]').change(function() {
        var clientId = $(this).val();
        var token = $('meta[name="csrf-token"').attr('content');
        $.post('/projects/byClient', {_token: token, clientId: clientId}, function(data) {
            $('select[name="project_id"]').empty();
            $.each(data, function(index, project) {
                var str = '<option value="' + project.id + '">' + project.name + '</option>';
                $('select[name="project_id"]').append(str);
            });
        }).fail(function() {
            console.log('Failed to fetch data.');
        });
    });

});
