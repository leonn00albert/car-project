INSERT INTO cars (id, name, description, image) VALUES
    ('1', '1936 Stout Scarab', 'The 1936 Stout Scarab was an upscale proto-mini van. It kept passengers comfortable and their flatware in place with a cushy four-wheel independent suspension.', 'https://media.wired.com/photos/59325c2952d99d6b984dde64/master/w_1600,c_limit/1936-Stout-Scarab-front-3q.jpg'),
    ('2', 'Chrysler (Ghia) Streamline X', 'Designers originally intended to fit the 1955 Chrysler (Ghia) Streamline X "Gilda" with a gas turbine engine, but gave it a conventional motor instead.', 'https://media.wired.com/photos/59325c2a58b0d64bb35d11e9/master/w_1600,c_limit/1955-Ghia-Gilda-r3q.jpg'),
    ('3', '1948 Tasco', 'If the 1948 Tasco looks familiar, it’s because the lines on this car came from Gordon Buehrig, a design alumnus of Duesenberg.', 'https://media.wired.com/photos/59325c2da312645844994480/master/w_1600,c_limit/1948-Tasco-profile.jpg'),
    ('4', 'GM Le Sabre', 'The 1951 GM Le Sabre was the first car to sport fins and a wraparound windshield, design elements that became standard in American cars thereafter.', 'https://media.wired.com/photos/59325c2e26780e6c04d2b2c2/master/w_1600,c_limit/1951-GM-Le-Sabre-side.jpg'),
    ('5', '1941 Chrysler Thunderbolt', 'The curves on the 1941 Chrysler Thunderbolt were inspired by streamliner trains.', 'https://media.wired.com/photos/59325c2e44db296121d6a89a/master/w_1600,c_limit/1941-Chrysler-Thunderbolt-side-open.psd_.jpg'),
    ('6', 'Buick Centurion', 'The 1956 Buick Centurion had a back-up camera decades before they appeared in consumer vehicles.', 'https://media.wired.com/photos/59325c2e5c4fbd732b5520bb/master/w_1600,c_limit/1956-Buick-Centurion-front-3q.jpg'),
    ('7', 'Cadillac Cyclone', 'The 1959 Cadillac Cyclone could drive itself using a sensor that guided it along a wire embedded in the road.', 'https://media.wired.com/photos/59325c2f5c4fbd732b5520bd/master/w_1600,c_limit/1959-Cadillac-Cyclone-front-3-4crop-.jpg'),
    ('8', 'Voisin C-25 Aerodyne', 'The 1934 Voisin C-25 Aerodyne was a French saloon than ran on a 3.0-liter inline-6 engine that produced just over 100 horsepower.', 'https://media.wired.com/photos/59325c2d9be5e55af6c24630/master/w_1600,c_limit/1934-Voisin-C-25-Aerodyne-f3q-restored.jpg');
    ALTER TABLE cars
ADD COLUMN longitude DECIMAL(9,6),
ADD COLUMN latitude DECIMAL(8,6);

UPDATE cars
SET longitude = CASE
    WHEN id = '1' THEN 13.404954  -- Coordinates of Berlin, Germany
    WHEN id = '2' THEN 12.496365  -- Coordinates of Munich, Germany
    WHEN id = '3' THEN 2.352222   -- Coordinates of Paris, France
    WHEN id = '4' THEN 4.351710   -- Coordinates of Brussels, Belgium
    WHEN id = '5' THEN -0.127758  -- Coordinates of London, United Kingdom
    WHEN id = '6' THEN 41.902784  -- Coordinates of Barcelona, Spain
    WHEN id = '7' THEN 41.008237  -- Coordinates of Madrid, Spain
    WHEN id = '8' THEN 48.856613  -- Coordinates of Paris, France
    ELSE NULL
    END,
    latitude = CASE
    WHEN id = '1' THEN 52.520008  -- Coordinates of Berlin, Germany
    WHEN id = '2' THEN 48.137154  -- Coordinates of Munich, Germany
    WHEN id = '3' THEN 48.856614  -- Coordinates of Paris, France
    WHEN id = '4' THEN 50.850340  -- Coordinates of Brussels, Belgium
    WHEN id = '5' THEN 51.507351  -- Coordinates of London, United Kingdom
    WHEN id = '6' THEN 2.348600   -- Coordinates of Barcelona, Spain
    WHEN id = '7' THEN -4.355150  -- Coordinates of Madrid, Spain
    WHEN id = '8' THEN 2.352222   -- Coordinates of Paris, France
    ELSE NULL
    END;