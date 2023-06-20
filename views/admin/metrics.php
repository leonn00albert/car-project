    <?php require_once "../../app/Controller.php";
    session_start();
    if (

        (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
        (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
    ) {

        $metricsBookingCar =$controller->get("bookings/cars/metrics");
        $metricsCar =$controller->get("cars");
    ?>

        <?php include "../../views/admin/header.php"; ?>
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <?php include "../../views/admin/navbar.php"; ?>
                <div class="col py-3 right-side-container">
                    <div class="container">
                        <div class="row">
                 
                            <div class="col">
                            <div class="card m-3 card-shadow">
                                    <div class="card-body">
                                        <h2>Most Reviewed Car</h2>

                                        <canvas id="myChart2" style="width:100%;max-width:700px"></canvas>


                                    </div>
                                </div>
                            </div>
                            <div class="col">
                            <div class="card m-3 card-shadow">
                                    <div class="card-body">
                                        <h2>Bookings</h2>

                                        <canvas id="myChart3" style="width:100%;max-width:700px"></canvas>


                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>

        <script>

let xValues = [
    <?php foreach($metricsCar as $car ) :?>
        <?php echo "'{$car["name"]}',"; ?>
    <?php endforeach; ?>
];

let yValues = [
    <?php foreach($metricsCar as $car) :?>
        <?php echo "'{$car["average_rating"]}',"; ?>
    <?php endforeach; ?>
];
new Chart("myChart2", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor:"rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },

});
let x = [
    <?php foreach($metricsBookingCar as $car => $count) :?>
        <?php echo "'$car',"; ?>
    <?php endforeach; ?>
];

let y = [
    <?php foreach($metricsBookingCar as $car => $count) :?>
        <?php echo "$count,"; ?>
    <?php endforeach; ?>
];


var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart3", {
  type: "bar",
  data: {
    labels: x,
    datasets: [{
      backgroundColor: barColors,
      data: y
    }]
  },
  options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
}
 
});
        </script>

    <?php } else {
        header("location: /views/login.php");
    } ?>