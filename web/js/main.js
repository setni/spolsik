$(function() {
    
    MainClass = {
        var: {},
        function: {

            init: function () {
                
                //get new
                $.post('/new', function (html) {
                    $('div[data-type="new"]').html(html);
                }, 'HTML');
                
                //actions new
                $('#get_youtube_API').on('click', function () {
                    $.post('/youtube', 
                    {
                        query: $('#actuality_titre').val()+" "+$('#actuality_artiste').val()
                    }, function(r) {
                        MainClass.var.templateYoutube = "";
                        $.each(JSON.parse(r).result, function () {
                            MainClass.var.templateYoutube += "<div class='col-sm-6 col-md-2' >"
                                + "<iframe width=120 height=120 src='http://www.youtube.com/embed/"+this.id+"'/>"
                                + "<div class='caption' >"
                                + "<h4>"+this.title+"</h4>"
                                + "<p>"+this.description+"</p>"
                                + "<span>"+this.channelTitle+"</span>"
                                + "<p><a onclick='MainClass.function.choixVideo(this)' data-url='https://www.youtube.com/watch?v="+this.id+"' class='btn btn-primary' role='button'>Choisir</a>"
                                + "</div>"
                                + "</div>";  
                        });
                        $('#choix_video').html(MainClass.var.templateYoutube);
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
                if((MainClass.var.links = $('.linkYoutube')).length > 0) {
                    MainClass.var.links.each(function () {
                        MainClass.var.link = $(this).attr('linkinfo');
                        //$(this).html('<iframe width="900" height="450" src="http://www.youtube.com/embed/'+MainClass.link.split('=')[1]+'"></iframe>');
                    });
                }
            },
            choixVideo: function (jObj) {//put video url on the youtube input
                $('#actuality_youtube').val($(jObj).attr('data-url'));
            },
            commentForm: function (idActu) {
                if(!/\b/.test(MainClass.var.comment = $('textarea[data-actu="'+idActu+'"]').val())) {
                    alert("Vous n'avez pas écrit de commentaire");
                } else {
                    $.post('/comment',
                    {
                        comment: MainClass.var.comment,
                        idActu: idActu,
                        token: window.token
                    }, function() {
                        MainClass.var.templateCom = "<div class='media'>"
                            + "<div class='media-body'>"
                            + "<h4 class='media-heading'>De "+window.username
                                + "<small>Maintenant </small>"
                            + "</h4>"
                                + MainClass.var.comment
                            + "</div>"
                        + "</div>";
                        $(MainClass.var.templateCom).prependTo('div[data-id="comment'+idActu+'"]');
                    }).fail(function() {
                        alert( "Token invalide" );
                    });
                }
            },
            getHome : function () {
                $('div[data-type="new"]').css('display','none');
                $('div[data-type="actus"]').css('display','block');
            },
            getFavorite: function () {
                //ajax favorite.twig
            },
            getProfile: function () {
                //ajax profil.twig
            },
            getNew: function () {
                $('div[data-type="new"]').css('display','block');
                $('div[data-type="actus"]').css('display','none');
            }
        }
    }
     MainClass.function.init();
});