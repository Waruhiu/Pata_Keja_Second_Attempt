document.addEventListener("DOMContentLoaded", function () {
  // Function to display image preview for Image 1
  document.getElementById("image1Upload").addEventListener("change", function (event) {
    var imagePreview1 = document.querySelector("#carouselExampleIndicators .carousel-item:nth-child(1) img");
    imagePreview1.src = URL.createObjectURL(event.target.files[0]);
  });

  // Function to display image preview for Image 2
  document.getElementById("image2Upload").addEventListener("change", function (event) {
    var imagePreview2 = document.querySelector("#carouselExampleIndicators .carousel-item:nth-child(2) img");
    imagePreview2.src = URL.createObjectURL(event.target.files[0]);
  });

  // Function to display image preview for Image 3
  document.getElementById("image3Upload").addEventListener("change", function (event) {
    var imagePreview3 = document.querySelector("#carouselExampleIndicators .carousel-item:nth-child(3) img");
    imagePreview3.src = URL.createObjectURL(event.target.files[0]);
  });
});
