$(document).ready(function() {
  var owl = $("#sliderDiv");
  owl.owlCarousel({
    singleItem:true,
    slideSpeed:900,
    autoHeight: true
  });

  $('#slide-prev').click(function() {
    owl.trigger('owl.prev');
  });

  $('#slide-next').click(function() {
    owl.trigger('owl.next');
  });
});
