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