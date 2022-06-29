$(function(){
    $('.button-view').click(function(){
        $('#modal').modal('show')
        .find('#modal-content')
        .load($(this).attr('value'));
    });
});