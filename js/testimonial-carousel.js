const multipleItemCarousel = document.querySelector("#testimonialCarousel");

if (window.matchMedia("(min-width:576px)").matches) {
  const carousel = new bootstrap.Carousel(multipleItemCarousel, {
    interval: false,
  });

  var carouselWidth = $("#testimonialCarousel .carousel-inner")[0].scrollWidth;
  var cardWidth = $("#testimonialCarousel .carousel-item").width();

  var scrollPosition = 0;

  $("#testimonialCarousel .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 3) {
      console.log("next");
      scrollPosition = scrollPosition + cardWidth;
      $("#testimonialCarousel .carousel-inner").animate({ scrollLeft: scrollPosition }, 800);
    }
  });
  $("#testimonialCarousel .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition = scrollPosition - cardWidth;
      $("#testimonialCarousel .carousel-inner").animate({ scrollLeft: scrollPosition }, 800);
    }
  });
} else {
  $(multipleItemCarousel).addClass("slide");
}