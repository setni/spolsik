$(function() {
    "use strict";
    
    //actions new
    function varProvider () {}
    $('#get_youtube_API').on('click', function () {
        $.post('/youtube', 
        {
            query: $('#actuality_titre').val()+" "+$('#actuality_artiste').val()
        }, function(r) {
            varProvider.template = "";
            $.each(JSON.parse(r).result, function () {
                varProvider.template += "<div class='col-sm-6 col-md-2' >"
                    + "<iframe width=120 height=120 src='http://www.youtube.com/embed/"+this.id+"'/>"
                    + "<div class='caption' >"
                    + "<h4>"+this.title+"</h4>"
                    + "<p>"+this.description+"</p>"
                    + "<span>"+this.channelTitle+"</span>"
                    + "<p><a onclick='choixVideo(this)' data-url='https://www.youtube.com/watch?v="+this.id+"' class='btn btn-primary' role='button'>Choisir</a>"
                    + "</div>"
                    + "</div>";  
            });
            $('#choix_video').html(varProvider.template);
        },
        'JSON');
    });
    
    window.choixVideo = function (jObj) {
        $('#actuality_youtube').val($(jObj).attr('data-url'));
    }
    
    $("#newForm").validate({
        rules: {
            artiste: "required",
            titre: "required",
            description: "required",
            youtube: {
                required: true,
                url: true
            }
        },
        messages: {
            artiste: "Merci d'entrer un artiste",
            titre: "Merci d'entrer un titre",
            description : "Merci d'entrer une description",
            youtube: "Merci d'entrer un adresse youtube correcte"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    //youtube link creation
    if((varProvider.links = $('.linkYoutube')).length > 0) {
        varProvider.links.each(function () {
            varProvider.link = $(this).attr('linkinfo');
            //$(this).html('<iframe width="900" height="450" src="http://www.youtube.com/embed/'+varProvider.link.split('=')[1]+'"></iframe>');
        });
    }
    
    window.commentForm = function (idActu) {
        if(!/\b/.test(varProvider.comment = $('textarea[data-actu="'+idActu+'"]').val())) {
            alert("Vous n'avez pas écrit de commentaire");
        } else {
            $.post('/comment',
            {
                comment: varProvider.comment,
                idActu: idActu,
                token: $('#_token').val()
            }, function(r) {
                
            }).fail(function() {
                alert( "Token invalide" );
            })
        }
    }
});