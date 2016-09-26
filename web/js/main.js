$(function() {
    //action new
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
    if((links = $('.linkYoutube')).length > 0) {
        links.each(function () {
            link = $(this).attr('linkinfo');
            $(this).html('<iframe width="900" height="450" src="http://www.youtube.com/embed/'+link.split('=')[1]+'"></iframe>');
        });
    }
    
    function commentForm(idActu) {
        
    }
});