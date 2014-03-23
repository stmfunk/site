$(document).ready(function() {
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
  $(".owl-controls").remove()
});
