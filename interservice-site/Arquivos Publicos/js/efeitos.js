jQuery(document).ready(function($) {
 $(".scroll").click(function(event){
  event.preventDefault();
  $('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);
 });
});

$(document).ready(function() {
  $(window).on("scroll", function() {
    if ($(window).scrollTop() >= 100) {
      $(".navbar").slideDown(200).addClass("compressed");
    } else {
      $(".navbar").removeClass("compressed");
    }
  });
});
