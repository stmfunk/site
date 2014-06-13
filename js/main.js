$(document).ready(function() {
  function getUrlVars() {
        var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                      vars[key] = value;
                          });
                return vars;
  }
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

  $("li.blog-nav").click(function() {
    $(".blog-selected").removeClass("blog-selected");
    $(this).addClass("blog-selected");
    var content = $(this).text().toLowerCase();
    $.ajax({url:"/core/dbRaw.php?section="+content,success:function(result) {
      $("section.blog-posts").html(result);
    }});
    history.pushState({},"fish","?section="+content);
  });

  var section = getUrlVars()["section"];
  if (!section) {
    section = "All";
  } else {
    section = section.charAt(0).toUpperCase() + section.slice(1);
  }
  var $liF = $("li.blog-nav:contains('"+section+"')");
  $liF.addClass("blog-selected");
  var content = $liF.text().toLowerCase();


  // Stuff for sticking the navbar to the top of the page
  var stickyTop = $(".sticktop").offset().top;
  $(window).scroll(function() {
    var windowTop = $(window).scrollTop();
    if (stickyTop < windowTop+16) {
      $('.sticktop').css({'position':'fixed','top':'0px'});
    } else {
      $('.sticktop').css({'position':'static'});
    }
  });


});
