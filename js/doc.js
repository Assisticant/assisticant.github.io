$(function() {
    var toc = $('h2').map(function (i,e) {
        var element = $(e);
        var text = element.text();
        var id = element.attr('id');
        return $('<li>').append($('<a>').attr('href', '#'+id).text(text));
    }).get();
    $('#affixedNav ul').html(toc);
})