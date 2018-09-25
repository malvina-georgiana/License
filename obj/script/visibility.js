$("#button_visibility").click( function() {
 $.post( $("#button_visibility").attr("action"),
         $("#button_visibility :input").serializeArray(),
         function(info){ $("#result").html(info);
		 setTimeout(function() {
 location.reload()
  },1500);
   });
});