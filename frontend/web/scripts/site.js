$(document).ready(function () {

   $('.words').on('click', function () {
      var text = $(this).text();
      var number = $(this).data('number');
      var word = $(this).data('word');
      var html = '<div class="col-xs-2">' +
                   '<div class="sentence-parts btn-default" data-number="' + number + '" data-word="' + word + '">' +
                     text +
                   '</div>' +
                '</div>';
      $(this).closest('div').hide();
      $('#sentence').append(html);
   });

    $('#sentence').on('click', '.sentence-parts', function() {
        var number = $(this).data('number');
        $('.words[data-number="' + number + '"]').show();
        $(this).parent().closest('div').remove();
    });

    $('#check').on('click', function (event) {
        event.preventDefault();

        var id = $('#sentence').data('id');
        var sentence = '';

        $('.sentence-parts').each(function() {
            sentence += $(this).data('word') + ' ';
        });

        $.ajax({
            method: 'GET',
            url: 'is-correct-sentence',
            data: {
                id: id,
                sentence: sentence
            },
            dataType: 'json'
        }).done(function(data) {
            var html;

            html = '</div>' +
                        '<div class="alert alert-info alert-dismissible" role="alert">' +
                        '<button type="button" class="close close-info" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong>Result!</strong> You win: ' + data.win + ' You lose: ' + data.lose + ' Total games: ' + data.total +
                    '</div>';

            if (data.success === false) {
                html += '<div class="alert alert-warning alert-dismissible" role="alert">' +
                    '<button type="button" class="close close-warning" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong>Warning!</strong> Увы, но автор думал иначе.' +
                    '</div>';
            } else {
                html += '<div class="alert alert-success alert-dismissible" role="alert">' +
                    '<button type="button" class="close close-success" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong>Congratulations!</strong> Вы распознали замысел автор.' +
                    '</div>';

                $('#check').closest('div').remove();
                $('#next').show();
            }
            $('#alert-container').prepend(html);
        }).fail(function(msg) {
            var html = '<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close close-warning" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong>Warning!</strong> Увы, но автор думал иначе.' +
                        '</div>';

            $('#alert-container').prepend(html);
        });
    });
});