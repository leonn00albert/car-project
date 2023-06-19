    <?php require_once "../../app/Controller.php";
    session_start();
    if (

        (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
        (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
    ) {


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
                                        <h2>Most Popular Car</h2>

                                        <canvas id="myChart" style="width:100%;max-width:700px"></canvas>


                                    </div>
                                </div>
                            </div>

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
            const xyValues = [{
                    x: 50,
                    y: 7
                },
                {
                    x: 60,
                    y: 8
                },
                {
                    x: 70,
                    y: 8
                },
                {
                    x: 80,
                    y: 9
                },
                {
                    x: 90,
                    y: 9
                },
                {
                    x: 100,
                    y: 9
                },
                {
                    x: 110,
                    y: 10
                },
                {
                    x: 120,
                    y: 11
                },
                {
                    x: 130,
                    y: 14
                },
                {
                    x: 140,
                    y: 14
                },
                {
                    x: 150,
                    y: 15
                }
            ];

            new Chart("myChart", {
                type: "scatter",
                data: {
                    datasets: [{
                        pointRadius: 4,
                        pointBackgroundColor: "rgba(0,0,255,1)",
                        data: xyValues
                    }]
                },
                options: {

                }
            });
            const xValues = [50,60,70,80,90,100,110,120,130,140,150];
const yValues = [7,8,8,9,9,9,10,11,14,14,15];

new Chart("myChart2", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor:"rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },

});
let x = ["Italy", "France", "Spain", "USA", "Argentina"];
 let y = [55, 49, 44, 24, 15];
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
 
});
        </script>

    <?php } else {
        header("location: /views/login.php");
    } ?>