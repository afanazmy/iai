<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>MasterOngkir | Home</title>
  </head>
  <body>

    <?php
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "key: 8418869567f9eaaf367721fb5789ef22"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $city = json_decode($response)->rajaongkir->results;

    ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                      <h5 class="card-header">Cek Ongkir</h5>
                      <div class="card-body">
                        <h5 class="card-title">Masukkan data barang dan tujuan</h5>

                        <form class="" action="" method="post">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kota Asal</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name="origin">
                                  <option value="" selected disabled>Pilih Kota Asal</option>
                                  <?php foreach ($city as $key => $city_origin) { ?>
                                      <option value="<?php echo $city_origin->city_id; ?>"><?php echo $city_origin->city_name; ?></option>
                                  <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kota Tujuan</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name="destination">
                                  <option value="" selected disabled>Pilih Kota Tujuan</option>
                                  <?php foreach ($city as $key => $city_destination) { ?>
                                      <option value="<?php echo $city_destination->city_id; ?>"><?php echo $city_destination->city_name; ?></option>
                                  <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Berat</label>
                                <div class="input-group mb-3">
                                  <input type="number" class="form-control" placeholder="Berat barang yang akan dikirim" aria-label="Recipient's username" aria-describedby="basic-addon2" name="weight">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">gram</span>
                                  </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kurir</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name="courier">
                                  <option value="" selected disabled>Pilih Kurir</option>
                                  <option value="jne">JNE</option>
                                  <option value="pos">POS</option>
                                  <option value="tiki">TIKI</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

                        </form>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $origin = $_POST["origin"];
                            $destination = $_POST['destination'];
                            $weight = $_POST['weight'];
                            $courir = $_POST['courier'];

                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courir",
                            CURLOPT_HTTPHEADER => array(
                            "content-type: application/x-www-form-urlencoded",
                            "key: 8418869567f9eaaf367721fb5789ef22"
                            ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            $origin_detail = json_decode($response)->rajaongkir->origin_details;
                            $destination_detail = json_decode($response)->rajaongkir->destination_details;
                            $result = json_decode($response)->rajaongkir->results;
                            $weight = json_decode($response)->rajaongkir->query->weight;
                        }

                        ?>

                      </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                      <div class="card-header">
                        Hasil
                      </div>
                      <div class="card-body">
                          <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
                          <b>Asal : </b>
                          <span><?php echo $origin_detail->city_name; ?></span>
                          <br>

                          <b>Tujuan : </b>
                          <span><?php echo $destination_detail->city_name; ?></span>
                          <br>

                          <b>Kurir : </b>
                          <span><?php echo $result[0]->name; ?></span>
                          <br>

                          <b>Berat : </b>
                          <span><?php echo $weight; ?> gram</span>
                          <br>
                          <br>

                          <table class="table">
                              <thead>
                                  <th>Service</th>
                                  <th>Deskripsi</th>
                                  <th>Harga</th>
                                  <th>Estimasi (hari)</th>
                              </thead>
                              <tbody>
                                  <?php foreach ($result[0]->costs as $key => $val) { ?>
                                  <tr>
                                      <td><?php echo $val->service; ?></td>
                                      <td><?php echo $val->description; ?></td>
                                      <td><?php echo $val->cost[0]->value; ?></td>
                                      <td><?php echo $val->cost[0]->etd; ?></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                      <?php } ?>
                      </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
