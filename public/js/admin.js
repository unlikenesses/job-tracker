$(function() {
    
    $('#editArticle').summernote({height: 200})

    $('.datepicker').datepicker({'dateFormat':'dd-mm-yy'});

    $('.jobs_checkboxes').change(function() {
        var amount = parseInt($(this).attr('id').replace('amount', ''));
        var total = $('input[name=amount]').val();
        if (total == '') { total = 0; } else { total = parseInt(total); }
        if (this.checked) {
            var new_total = total + amount;
        } else {
            var new_total = total - amount;
        }
        $('input[name=amount]').val(new_total);
    });

    $('a.invertJobs').on('click', function(e) {
        e.preventDefault();
        $('input[name="jobs[]"').trigger('click');
    });

});