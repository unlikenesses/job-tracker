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
        $('input[name="jobs[]"').trigger('click');
    });

    function showEditLink(job) {
        return '<a href="jobs/' + job.id + '/edit">';
    }

    function showButtons(job) {
        var str = '<a href="jobs/' + job.id + '/edit" class="btn btn-default">';
        str += '<i class="fa fa-plus"></i> Edit';
        str += '</a> '
        str += '<a href="jobs/' + job.id + '/delete" class="btn btn-default">';
        str += '<i class="fa fa-trash"></i> Delete';
        str += '</a>';
        return str;
    }

    function jobRow(job) {
        var str = '<tr>';
        str += '<td>' + showEditLink(job) + job.client + '</a></td>';
        str += '<td>' + showEditLink(job) + job.project + '</a></td>';
        str += '<td>' + showEditLink(job) + job.name + '</a></td>';
        str += '<td>' + showEditLink(job) + job.started + '</a></td>';
        str += '<td>' + showEditLink(job) + job.completed + '</a></td>';
        str += '<td>' + showEditLink(job) + job.currencySymbol + job.amount + '</a></td>';
        str += '<td>' + showButtons(job) + '</td>';
        str += '</tr>';
        return str;
    }

    $('select[name="clientFilter"]').change(function() {
        var clientId = $(this).val();
        var token = $('meta[name="csrf-token"').attr('content');
        $.post('jobs/filter', {_token: token, clientId: clientId}, function(data) {
            $('#jobsTable tbody tr').remove();
            $.each(data, function(index, job) {
                $('#jobsTable tbody').append(jobRow(job));
            });
        }).fail(function() {
            console.log('Failed to fetch data.');
        });
    });

});
