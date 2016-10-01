$(function() {
    //actions new
    function varProvider () {}
    $('#get_youtube_API').on('click', function () {
        $.post('/youtube', 
        {
            titre: $('#actuality_titre').val(),
            artiste: $('#actuality_artiste').val()
        }, function(r) {
            JSON_parse(r).result.each(function () {
                $this = $(this);
                varProvider.template += "<p>"
                    + $this.id
                    + " / "
                    + $this.artiste
                    + " / "
                    + $this.titre
                    + " / "
                    + $this.channelTitle
                    + "</p>";
                
            });
            $('#choix_video').html(varProvider.template);
        },
        'JSON');
    });
    
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
            artiste: "Merce d'entrer un artiste",
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
            link = $(this).attr('linkinfo');
            $(this).html('<iframe width="900" height="450" src="http://www.youtube.com/embed/'+link.split('=')[1]+'"></iframe>');
        });
    }
    
    function commentForm(idActu) {
        
    }
});