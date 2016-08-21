$(function() {

    $('#editArticle').summernote({height: 200})

    $('.datepicker').datepicker({'dateFormat':'dd-mm-yy'});

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

    $('a.invertJobs').on('click', function(e) {
        e.preventDefault();
        $('input[name="jobs[]"]:visible').trigger('click');
    });

    $('#invoiceClientSelect').change(function() {
        var clientId = $(this).val();
        $('.invoiceJob').show();
        $('.invoiceJob:not([data-client=' + clientId + '])').hide();
    });

    function showJobEditLink(job) {
        return '<a href="jobs/' + job.id + '/edit">';
    }

    function showInvoiceEditLink(invoice) {
        return '<a href="invoices/' + invoice.id + '/edit">';
    }

    function showJobButtons(job) {
        var str = '<a href="jobs/' + job.id + '/edit" class="btn btn-default">';
        str += '<i class="fa fa-plus"></i> Edit';
        str += '</a> '
        str += '<a href="jobs/' + job.id + '/delete" class="btn btn-default">';
        str += '<i class="fa fa-trash"></i> Delete';
        str += '</a>';
        return str;
    }

    function showInvoiceButtons(invoice) {
        var str = '<a href="invoices/' + invoice.id + '/edit" class="btn btn-default">';
        str += '<i class="fa fa-plus"></i> Edit';
        str += '</a> '
        str += '<a href="invoices/' + invoice.id + '/delete" class="btn btn-default">';
        str += '<i class="fa fa-trash"></i> Delete';
        str += '</a> ';
        str += '<a href="invoices/' + invoice.id + '/export" class="btn btn-default">';
        str += '<i class="fa fa-file-pdf-o"></i> Export to PDF';
        str += '</a>';
        return str;
    }

    function jobRow(job) {
        var str = '<tr>';
        str += '<td>' + showJobEditLink(job) + job.client + '</a></td>';
        str += '<td>' + showJobEditLink(job) + job.project + '</a></td>';
        str += '<td>' + showJobEditLink(job) + job.name + '</a></td>';
        str += '<td>' + showJobEditLink(job) + job.started + '</a></td>';
        str += '<td>' + showJobEditLink(job) + job.completed + '</a></td>';
        str += '<td>' + showJobEditLink(job) + job.currencySymbol + job.amount + '</a></td>';
        str += '<td>' + showJobButtons(job) + '</td>';
        str += '</tr>';
        return str;
    }

    function invoiceRow(invoice) {
        var str = '<tr>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.client + '</a></td>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.name + '</a></td>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.invoiced + '</a></td>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.due + '</a></td>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.paid + '</a></td>';
        str += '<td>' + showInvoiceEditLink(invoice) + invoice.currencySymbol + invoice.amount + '</a></td>';
        str += '<td>' + showInvoiceButtons(invoice) + '</td>';
        str += '</tr>';
        return str;
    }

    $('select[name="jobsClientFilter"]').change(function() {
        var clientId = $(this).val();
        var token = $('meta[name="csrf-token"').attr('content');
        $.post('/jobs/filter', {_token: token, clientId: clientId}, function(data) {
            $('#jobsTable tbody tr').remove();
            $.each(data, function(index, job) {
                $('#jobsTable tbody').append(jobRow(job));
            });
        }).fail(function() {
            console.log('Failed to fetch data.');
        });
    });

    $('select[name="invoicesClientFilter"]').change(function() {
        var clientId = $(this).val();
        var token = $('meta[name="csrf-token"').attr('content');
        $.post('/invoices/filter', {_token: token, clientId: clientId}, function(data) {
            $('#invoicesTable tbody tr').remove();
            $.each(data, function(index, invoice) {
                $('#invoicesTable tbody').append(invoiceRow(invoice));
            });
        }).fail(function() {
            console.log('Failed to fetch data.');
        });
    });

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
