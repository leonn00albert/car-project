window.addEventListener("scroll", function () {
  console.log("scroll");
  var sections = document.querySelectorAll(".section");

  sections.forEach(function (section) {
    var position = section.getBoundingClientRect();

    if (
      position.top >= 0 &&
      position.bottom <= window.innerHeight &&
      !section.querySelector(".section-container").classList.contains("active")
    ) {
      var activeSection = document.querySelector(".section-container.active");
      if (activeSection) {
        activeSection.classList.remove("active");
      }
      section.querySelector(".container").classList.add("active");
    }
  });
});
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = "block";
  setTimeout(showSlides, 7000); // Change image every 2 seconds
}
const modal = document.getElementById("myModal");
window.onload = function () {
  const params = new URLSearchParams(window.location.search);
  const date = params.get("date");
  const carId = params.get("carId");
  const car = params.get("car");
  const img = params.get("img");
  if (date) {
    openModal(car, carId, img);
    document.getElementById("calendar").value = date;
  }
};

function openModal(car, id, img) {
  let carId = document.getElementById("carId");
  const carInput = document.getElementById("car");
  const span = document.getElementById("carName");
  const modalImage = document.getElementById("modalImage");
  modalImage.src = img;
  carId.value = id;
  carInput.value = car;
  span.textContent = car;
  const params = new URLSearchParams(window.location.search);

  if (!params.get("date")) {
    const today = new Date();
    const month = String(today.getMonth() + 1).padStart(2, "0"); // January is 0
    const day = String(today.getDate()).padStart(2, "0");
    const year = today.getFullYear();
    const date = `${year}-${month}-${day}`;
    carId = id;

    const queryString = new URLSearchParams({
      date,
      carId,
      car,
      img,
    }).toString();

    window.location = "/?" + queryString;
  } else {
    modal.style.display = "block";
  }
}

function getSlots() {
  const date = document.getElementById("calendar").value;
  const carId = document.getElementById("carId").value;
  const car = document.getElementById("carName").innerText;
  const img = document.getElementById("modalImage").src;

  const queryString = new URLSearchParams({
    date,
    carId,
    car,
    img,
  }).toString();
  modal.style.display = "block";
  window.location = "/?" + queryString;
}
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

function redirectToLogin() {
  window.location.href = "/views/login.php";
}
