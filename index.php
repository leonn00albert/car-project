<?php
session_start();
require_once __DIR__ . "/app/Controller.php";
include "./views/header.php";
?>

<body>
  <div class="grid page-container">
    <?php include "views/nav.php"; ?>
    <?php include "views/components/indexFeatured.php"; ?>
    <main class=" grid primary">
      <h1 class="page-title">Our Cars</h1>
      <div class="grid home-content">
        <?php
        $cars = $controller->Get("cars");
        foreach ($cars as $car) {
          $id = $car["id"];
          $name = $car["name"];
          $img = $car["image"];
          echo '<article class="post">';
          echo '<img src="' . $car['image'] . '" alt="' . $car['name'] . '">';
          echo '<h2>' . $car['name'] . '</h2>';
          echo '<p>' . $car['description'] . '</p>';

          if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
            echo '<button onclick="openModal(' . "'$name', '$id', '$img')" . '">Book Now</button>';
          } else {
            echo '<button onclick="redirectToLogin()">Book Now</button>';
          }

          echo '</article>';
        }
        ?>

      </div>


      <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">

          <p>
          <div class="container">
            <img class="modal-image" id="modalImage" />
            <h2> Book <span id="carName"></span></h2>
            <form method="POST" action="/app/Controller.php" id="myForm">
              <input type="hidden" name="action" value="create" />
              <input type="hidden" name="type" value="bookings" />
              <input type="hidden" name="carId" id="carId" />
              <input type="hidden" name="car" id="car" />
              <input type="hidden" id="name" name="name" value='<?php echo $userName ?>' />
              <input type="hidden" id="email" name="email" value='<?php echo $userEmail ?>' />
              <input type="hidden" id="userId" name="userId" value='<?php echo $userId ?>' />
              <input onchange="getSlots()" type="date" id="calendar" name="date" required>

              <?php
              $slots = $controller->slots($_GET["date"], $_GET["carId"]);
              if (!isset($slots[0]["name"])) {
                echo "<p class=\"not-available\" >No Slots Available For This Day</p>";
              } else {
                echo "<select name=\"time\">";
                foreach ($slots as $slot) :
                  echo "<option>{$slot["name"]}</option>";
                endforeach;
                echo "</select>";
                echo "<button style=\"width: 100px\" type=\"submit\"> Book </button>";
              }

              ?>
            </form>

          </div>
          </p>
        </div>
      </div>
    </main>
  </div>
  <script>
    window.addEventListener("scroll", function() {
      console.log("scroll");
      var sections = document.querySelectorAll(".section");

      sections.forEach(function(section) {
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
    window.onload = function() {
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
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };

    function redirectToLogin() {
      window.location.href = "/views/login.php";
    }
  </script>
</body>

</html>