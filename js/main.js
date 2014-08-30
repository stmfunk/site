$(document).ready(function() {
  function getUrlVars() {
        var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                      vars[key] = value;
                          });
                return vars;
  }
  
  var setSection = function(section) { 
    section = section.charAt(0).toUpperCase() + section.slice(1);
    console.log('fish');
    var $liF = $("li.blog-nav:contains('"+section+"')");
    $(".blog-selected").removeClass("blog-selected");
    $liF.addClass("blog-selected");
    var content = $liF.text().toLowerCase();
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

  // Ajax Code
  $("li.blog-nav").click(function() {
    $(".blog-selected").removeClass("blog-selected");
    $(this).addClass("blog-selected");
    var content = $(this).text();
    $.ajax({url:"/core/dbRaw.php?section="+content,success:function(result) {
      $("section.blog-posts").html(result);
    }});
    history.pushState({},"fish","?section="+content.toLowerCase());
    $(document).attr("title",content);
  });

  $(document).on('click',"a.postTitle",function() {
    var id = $(this).data('id');
    var thisSection = $(this).data('section');

    setSection(thisSection)

    $.ajax({url:"/core/dbRaw.php?id="+id,success:function(result) {
      $("section.blog-posts").html(result);
    }});
    history.pushState({},"fish","?id="+id);
    $(document).attr("title",$(this).text());
  });
    

  var section = getUrlVars()["section"];
  if (!section) {
     if ($(".blog-selected").length == 0)
        setSection("all");
  } else {
     setSection(section);
  }


  // Stuff for sticking the navbar to the top of the page
  try {
    var stickyTop = $(".sticktop").offset().top;
    $(window).scroll(function() {
      var windowTop = $(window).scrollTop();
      if (stickyTop < windowTop+17) {
        $('.sticktop').css({'position':'fixed','top':'0px'});
      } else {
        $('.sticktop').css({'position':'static'});
      }
    });
  } catch (err) {
  }


  // This is all site search stuff
  var $searchBar = $(".large-search");
  var h = $searchBar.parent().height();
  var searchText =    $searchBar.find("span.search-text");
  $searchBar.keypress(function(e){
     var parent = $(this).parent();
     parent.animate({"height":h*2.15+"px"});
     $(this).css({"margin-bottom":"20px"});
     $.ajax({url:"/core/dbRaw.php?profile_username=stm",success:function(result) {
       if (parent.children().length < 6) parent.append(result);
     }});
     return e.which != 13;
  });
  $searchBar.focus(function() {
     searchText.remove();
  });

  $searchBar.focusout(function() {
     $(this).css({"margin-bottom":"80px"});
     var parent = $(this).parent();
     parent.animate({"height":h+"px"});
     parent.children(".profile-condense").remove();
     if ($(this).empty()) {
        $(this).append(searchText);
     }
  });
});
