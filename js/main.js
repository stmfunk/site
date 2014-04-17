$(document).ready(function() {
   console.log('#'+tab_id);
  $('#'+tab_id).addClass('sliding-select-under-white');

  // All carousel stuff
  var owl = $("#sliderDiv");
  owl.owlCarousel({
    singleItem:true,
    autoPlay:3000,
    stopOnHover:true,
    slideSpeed:900,
    autoHeight: false
  });

  $('#slide-prev').click(function() {
    owl.trigger('owl.prev');
  });

  $('#slide-next').click(function() {
    owl.trigger('owl.next');
  });
  $(".owl-controls").remove();


  // Stuff for sliding navunderline
  $('.sliding-select').hover(function() {
     $(this).toggleClass('sliding-select-hover');
     if ($(this).attr('id').indexOf(tab_id) >= 0)  $(this).toggleClass('sliding-select-under-white');
     $(this).toggleClass('sliding-select-under-black');
  });
});


