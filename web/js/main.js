$(function() {
    
    MainController = {
        'var': {},
        'function': {

            'init': function () {
                //actions new
                $('#get_youtube_API').on('click', function () {
                    $.post('/youtube', 
                    {
                        query: $('#actuality_titre').val()+" "+$('#actuality_artiste').val()
                    }, function(r) {
                        MainController.var.templateYoutube = "";
                        $.each(JSON.parse(r).result, function () {
                            MainController.var.templateYoutube += "<div class='col-sm-6 col-md-2' >"
                                + "<iframe width=120 height=120 src='http://www.youtube.com/embed/"+this.id+"'/>"
                                + "<div class='caption' >"
                                + "<h4>"+this.title+"</h4>"
                                + "<p>"+this.description+"</p>"
                                + "<span>"+this.channelTitle+"</span>"
                                + "<p><a onclick='MainController.function.choixVideo(this)' data-url='https://www.youtube.com/watch?v="+this.id+"' class='btn btn-primary' role='button'>Choisir</a>"
                                + "</div>"
                                + "</div>";  
                        });
                        $('#choix_video').html(MainController.var.templateYoutube);
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
                if((MainController.var.links = $('.linkYoutube')).length > 0) {
                    MainController.var.links.each(function () {
                        MainController.var.link = $(this).attr('linkinfo');
                        //$(this).html('<iframe width="900" height="450" src="http://www.youtube.com/embed/'+MainController.link.split('=')[1]+'"></iframe>');
                    });
                }
            },
            'choixVideo': function (jObj) {//put video url on the youtube input
                $('#actuality_youtube').val($(jObj).attr('data-url'));
            },
            'commentForm': function (idActu) {
                if(!/\b/.test(MainController.var.comment = $('textarea[data-actu="'+idActu+'"]').val())) {
                    alert("Vous n'avez pas écrit de commentaire");
                } else {
                    $.post('/comment',
                    {
                        comment: MainController.var.comment,
                        idActu: idActu,
                        token: $('#_token').val()
                    }, function(r) {
                        MainController.templateCom = "<div class='media'>"
                            + "<div class='media-body'>"
                            + "<h4 class='media-heading'>De "+window.username
                                + "<small>Maintenant </small>"
                            + "</h4>"
                                + MainController.var.comment
                            + "</div>"
                        + "</div>";
                        // TODO checker la présence d'un commentaire avant insert
                        $(MainController.var.templateCom).insertBefore('.media:eq(0)');

                    }).fail(function() {
                        alert( "Token invalide" );
                    })
                }
            },
            'getHome' : function () {

            },
            'getFavorite': function () {

            },
            'getProfile': function () {

            }
        }
    }
     MainController.function.init;
    
    
    /*MainController.commentForm = function (idActu) {
        if(!/\b/.test(MainController.comment = $('textarea[data-actu="'+idActu+'"]').val())) {
            alert("Vous n'avez pas écrit de commentaire");
        } else {
            $.post('/comment',
            {
                comment: MainController.comment,
                idActu: idActu,
                token: $('#_token').val()
            }, function(r) {
                MainController.templateCom = "<div class='media'>"
                    + "<div class='media-body'>"
                    + "<h4 class='media-heading'>De "+window.username
                        + "<small>Maintenant </small>"
                    + "</h4>"
                        + MainController.comment
                    + "</div>"
                + "</div>";
                
                $(MainController.templateCom).insertBefore('.media:eq(0)');
                
            }).fail(function() {
                alert( "Token invalide" );
            })
        }
    }
    
    MainController.link = function () {
        
    }
    MainController.getFavorite = function () {
        
    }
    MainController.getProfile = function () {
        
    }
    */
});