        <header class="page-header">
            <div class="slideshow-container">

                <div class="hero-image-2 mySlides fade">
                    <div class="hero-text">
                        <h1>Lancia (Bertone) Stratos HF Zero</h1>
                        <p>The 1970 Lancia (Bertone) Stratos HF Zero, the predecessor to the legendary Stratos, was so small that the driver had to climb in through the windshield.</p>
                        <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
                            echo '<button onclick="openModal(\'Lancia (Bertone) Stratos HF Zero\', \'32134dada2\', \'https://media.wired.com/photos/59325c2b52d99d6b984dde66/master/w_1600,c_limit/1970-Lancia-Stratos-Zero.jpg\')">Book Now</button>';
                        } else {
                            echo '<button onclick="redirectToLogin()">Book Now</button>';
                        }
                        ?>


                    </div>
                </div>
                <div class="hero-image mySlides fade">
                    <div class="hero-text">
                        <h1>General Motors Firebird I XP-21</h1>
                        <p>A jet fighter on wheels, the 1953 General Motors Firebird I XP-21 could top 200 mph.</p>
                        <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
                            echo '<button onclick="openModal(\'General Motors Firebird I XP-21\', \'7821s283d8\', \'https://media.wired.com/photos/59325c2aedfced5820d0fd7c/master/w_1600,c_limit/1954-Firebird-I-front-3qx.jpg\')">Book Now</button>';
                        } else {
                            echo '<button onclick="redirectToLogin()">Book Now</button>';
                        }
                        ?>
                    </div>

                </div>
            </div>
        </header>