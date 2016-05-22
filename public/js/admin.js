$(function() {
    
    $('#editArticle').summernote()

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

});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var el = document.getElementById('sortable');
var sortable = Sortable.create(el,{
    animation: 500,
    store: {
        get: function(sortable) {return [];},
        set: function(sortable) {
            var order = sortable.toArray();
            var table = $('thead').attr('id');
            $.post('sort', { order: order, table: table });
        }
    }
});