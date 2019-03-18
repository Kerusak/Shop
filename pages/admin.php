<div class="row">
    <div class="col-md-6">
        <?php
        connect();
        $selectCountry = "select * from countries ORDER BY id";
        $resourseCountry = mysql_query($selectCountry);

        $selectCity = "select ci.id, ci.city, co.country from cities as ci, countries as co WHERE co.id = ci.country_id";
        $resourseCity = mysql_query($selectCity);

        $selectHotels = "select ci.id, ci.city, ho.id, ho.hotel, ho.city_id, ho.country_id, ho.stars, ho.info, co.id, co.country 
                          from cities as ci, countries as co, hotels as ho WHERE co.id = ci.country_id and ho.city_id = ci.id";
        $selectCityCountry = "select ci.id, ci.city, co.country, co.id from cities as ci, countries as co WHERE co.id = ci.country_id";
        $resourseCityCountry = mysql_query($selectCityCountry);
        $resourseHotels = mysql_query($selectHotels);

        $selectImages = "select ho.id, co.country, ci.city, ho.hotel from countries as co, cities as ci, hotels as ho
                         where co.id = ho.country_id AND ci.id = ho.city_id order by co.country";
        $resourseImages = mysql_query($selectImages);
        ?>
        <form action="index.php?page=4" method="post">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <h3>Form for Countries</h3>
                </div>
                <div class="panel panel-body">
                    <div class="form-group">
                        <table class="table table-stripped">
                            <?php while ($row = mysql_fetch_array($resourseCountry)): ?>
                                <tr>
                                    <td><?= $row[0] ?></td>
                                    <td><?= $row[1] ?></td>
                                    <td><input type="checkbox" name="cb<?= $row[0] ?>"></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                        <?php mysql_free_result($resourseCountry); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" name="country" placeholder="Country" class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addcountry" value="Add" class="btn btn-info">
                        <input type="submit" name="delcountry" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['addcountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if ($country == '') {
                return false;
            }
            $insert = "insert into countries(country)VALUES ('$country')";
            mysql_query($insert);
            log_db(mysql_errno());
            reload();
        }
        if (isset($_POST['delcountry'])) {
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 2) == "cb") {
                    $idc = substr($key, 2);
                    $delete = "delete from countries where id = '$idc'";
                    mysql_query($delete);
                    log_db(mysql_errno());
                }
            }
            reload();
        }
        ?>
    </div>
    <div class="col-md-6">
        <form action="index.php?page=4" method="post">
            <div class="panel panel-info">
                <div class="panel panel-heading">
                    <h3>Form for Cities</h3>
                </div>
                <div class="panel panel-body">
                    <div class="form-group">
                        <table class="table table-stripped">
                            <?php while ($row = mysql_fetch_array($resourseCity)): ?>
                                <tr>
                                    <td><?= $row[0] ?></td>
                                    <td><?= $row[1] ?></td>
                                    <td><?= $row[2] ?></td>
                                    <td><input type="checkbox" name="cb<?= $row[0] ?>"></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                        <?php mysql_free_result($resourseCity); ?>
                    </div>
                    <div class="form-group">
                        <select name="countryname" class="form-control">
                            <?php $res = mysql_query($selectCountry); ?>
                            <?php while ($row = mysql_fetch_array($res)): ?>
                                <option value="<?= $row[0] ?>"><?= $row[1] ?></option>
                            <?php endwhile; ?>
                            <?php mysql_free_result($res); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="city" placeholder="City" class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addcity" value="Add" class="btn btn-info">
                        <input type="submit" name="delcity" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            if ($city == '') {
                return false;
            }
            $countryid = $_POST['countryname'];
            $insert = "insert into cities(city, country_id)VALUES ('$city', $countryid)";
            mysql_query($insert);
            log_db(mysql_errno());
            reload();
        }
        if (isset($_POST['delcity'])) {
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 2) == "cb") {
                    $idc = substr($key, 2);
                    $delete = "delete from cities where id = '$idc'";
                    mysql_query($delete);
                    log_db(mysql_errno());
                }
            }
            reload();
        }
        ?>
    </div>
    <div class="col-md-6">
        <form action="index.php?page=4" method="post">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <h3>Form for Countries</h3>
                </div>
                <div class="panel panel-body">
                    <div class="form-group">
                        <table class="table table-stripped">
                            <?php while ($row = mysql_fetch_array($resourseHotels)): ?>
                                <tr>
                                    <td><?= $row[2] ?></td>
                                    <td><?= "$row[9], $row[1]" ?></td>
                                    <td><?= $row[3] ?></td>
                                    <td><?= $row[6] ?></td>
                                    <td><input type="checkbox" name="hb<?= $row[2] ?>"></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                    </div>
                    <div class="form-group">
                        <select name="hcity" class="form-control">
                            <?php $hackStyleArray = [] ?>
                            <?php while ($row = mysql_fetch_array($resourseCityCountry)): ?>
                                <option value="<?= $row[0] ?>"><?= "$row[1] : $row[2]" ?></option>
                                <?php $hackStyleArray[$row[0]] = $row[3]; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="hotel" placeholder="Hotel" class="form-control">
                    </div>
                    <div class="form-inline">
                        <label>
                            Cost: <input type="text" name="cost" placeholder="Cost" class="form-control">
                        </label>
                        <label>
                            Stars: <input type="number" name="stars" max="5" min="1" placeholder="Cost"
                                          class="form-control" value="3">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="info">Info about</label>
                        <textarea name="info" cols="70" rows="10" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addhotel" value="Add" class="btn btn-info">
                        <input type="submit" name="delhotel" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php mysql_free_result($resourseHotels); ?>
        <?php mysql_free_result($resourseCityCountry); ?>
        <?php
        if (isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = trim(htmlspecialchars($_POST['cost']));
            $stars = trim(htmlspecialchars($_POST['stars']));
            $info = trim(htmlspecialchars($_POST['info']));
            if ($hotel == '' || $cost == '' || $stars == '' || $info == '') {
                return false;
            }
            $cityid = $_POST['hcity'];
            $countryid = $hackStyleArray[$cityid];
            $insert = "insert into hotels(hotel, city_id,country_id, stars,cost,info) 
                        VALUES ('$hotel', $cityid, $countryid, $stars, $cost, '$info')";
            mysql_query($insert);
            log_db(mysql_errno());
            reload();
        }
        if (isset($_POST['delhotel'])) {
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 2) == "hb") {
                    $idc = substr($key, 2);
                    $delete = "delete from hotels where id = '$idc'";
                    mysql_query($delete);
                    log_db(mysql_errno());
                }
            }
            reload();
        }
        ?>
    </div>
    <div class="col-md-6">
        <form action="index.php?page=4" method="post" enctype="multipart/form-data">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <h3>Form for Images</h3>
                </div>
                <div class="panel panel-body">
                    <div class="form-group">
                        <select name="hotelid" class="form-control">
                            <?php while ($row = mysql_fetch_array($resourseImages)): ?>
                                <option value="<?= $row[0] ?>"><?= "$row[1] : $row[2] : $row[3]" ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" name="file[]" multiple class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addimg" value="Add" class="btn btn-info">
                    </div>
                </div>
            </div>
        </form>
        <?php mysql_free_result($resourseImages); ?>
        <?php
        if (isset($_POST['addimg'])) {
            foreach ($_FILES['file']['name'] as $key => $value){
                if ($_FILES['file']['error'][$key] != 0){

                    Logging('File error', true);
                }
                if (move_uploaded_file($_FILES['file']['tmp_name'][$key], "images/$value")){
                    $hotelid = $_POST['hotelid'];
                    $imagepath = "images/$value";
                    $insert = "insert into images(image_path, hotel_id)VALUES ('$imagepath', $hotelid)";
                    mysql_query($insert);
                    log_db(mysql_errno());
                }
            }
            reload();
        }
        ?>
    </div>
</div>