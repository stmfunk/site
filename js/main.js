$(document).ready(function() {
  var tab = $('#'+tab_id);
  tab.addClass('sliding-select-under-white');
  tab.attr("href","javascript:void(0)");

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

  $("div.blog-nav").first().addClass("blog-selected");
});
