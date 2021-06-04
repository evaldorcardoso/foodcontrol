$( document ).ready(function() {
    $(".tile").height($("#tile1").width());
    $(".carousel").height($("#tile1").width());
     $(".item").height($("#tile1").width());
     
    $(window).resize(function() {
    if(this.resizeTO) clearTimeout(this.resizeTO);
	this.resizeTO = setTimeout(function() {
		$(this).trigger('resizeEnd');
	}, 10);
    });
    
    $(window).bind('resizeEnd', function() {
    	$(".tile").height($("#tile1").width());
        $(".carousel").height($("#tile1").width());
        $(".item").height($("#tile1").width());
    });

    document.getElementById("modos").style.display = "none";
    document.getElementById("cadastros").style.display = "none";
    document.getElementById("sair").style.display = "none";

    $('#tile-modos').click(function (e) {
        e.preventDefault();
        if(document.getElementById("modos").style.display=="none"){
            document.getElementById("cadastros").style.display = "none";
            document.getElementById("modos").style.display = "initial";
        }
        else{
            document.getElementById("modos").style.display = "none";
            document.getElementById("cadastros").style.display = "none";
        }
    });
    $('#tile-cadastros').click(function (e) {
        e.preventDefault();
        if(document.getElementById("cadastros").style.display=="none"){
            document.getElementById("modos").style.display = "none";
            document.getElementById("cadastros").style.display = "initial";
        }
        else{
            document.getElementById("cadastros").style.display = "none";
            document.getElementById("modos").style.display = "none";
        }
    });

    $('#a_perfil').click(function (e) {
        e.preventDefault();
        if(document.getElementById("sair").style.display=="none"){
            document.getElementById("sair").style.display = "inline";
        }
        else{
            document.getElementById("sair").style.display = "none";
        }
    });
});

