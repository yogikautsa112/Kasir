<?php
session_start();

if (!isset($_SESSION["data_barang"])) {
    $_SESSION["data_barang"] = array();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-submit'])) {
    $nama = $_POST["nama"];
    $harga = $_POST["harga"];
    $jumlah = $_POST["jumlah"];
    $total = $harga * $jumlah;

    $_SESSION["data_barang"][] = array(
        "nama" => $nama,
        "harga" => $harga,
        "jumlah" => $jumlah,
        "total" => $total
    );
    $_SESSION['success_message'] = "Data berhasil ditambahkan";
    header("Location: index.php");
    exit();
} 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-delete'])) {
    $index = $_POST["delete-index"];
    unset($_SESSION['data_barang'][$index]);
    $_SESSION['data_barang'] = array_values($_SESSION['data_barang']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="container mt-4">
        <?php 
        if(isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success d-flex justify-content-between' role='alert'>";
            echo $_SESSION['success_message'];
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
            echo '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <div class="form-container">
            <h3 class="text-center">Masukan Data Barang</h3>
            <form method="post" class="add-data d-flex justify-content-center flex-column mb-2">
                <div class="input-container d-flex gap-2">
                    <input class="form-control" type="text" placeholder="Masukan Nama Barang" style="text-align: center;" name="nama" required>
                    <input class="form-control" type="number" placeholder="Masukan Harga Barang" style="text-align: center;" name="harga" required>
                    <input class="form-control" type="text" placeholder="Masukan Jumlah Barang" style="text-align: center;" name="jumlah" required>
                </div>
                <!-- Add Btn -->
                <div class="btn-collapse mt-2">
                    <button class="btn btn-primary" type="submit" name="btn-submit"><i class="bi bi-plus-lg"></i> Tambah</button>
                    <a href="checkout.php" class="btn btn-success" type="submit"><i class="bi bi-cart-fill"></i> CheckOut</a>
                </div>
                <!-- End Add Btn -->
            </form>
        </div>
        <hr>
        <p class="text-secondary">List Barang</p>
        <table class="table table-bordered table-striped-columns">
            <thead>
                <tr class="table-container" style="text-align: center;">
                    <th scope="col">No</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga </th>
                    <th scope="col">Jumlah </th>
                    <th scope="col">Total </th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php 
                if(isset($_SESSION["data_barang"]) && is_array($_SESSION["data_barang"]) && !empty($_SESSION["data_barang"]))  {
                    $nomor = 1;
                    foreach ($_SESSION["data_barang"] as $index => $barang){
                        $total = $barang['harga'] * $barang['jumlah'];
                        $formattedTotal = "Rp " . number_format($total, 0, ',', '.');
                        echo "<tr style='text-align: center;'>";
                        echo "<td>$nomor</td>";
                        echo "<td>".$barang['nama']."</td>";
                        echo "<td>".$barang['harga']."</td>";
                        echo "<td>".$barang['jumlah']."</td>";
                        echo "<td>". $formattedTotal . "</td>";
                        echo "<td>
                            <form method='post' class='d-inline-block'>
                                <input type='hidden' name='delete-index' value='$index'>
                                <button type='submit' class='btn btn-danger btn-sm' name='btn-delete'><i class='bi bi-trash3-fill'></i> Hapus</button>
                            </form>
                        </td>";
                        $nomor++;
                    }
                }
                ?>
                <tr>
                    <td class="text-center fw-bold " colspan="5">Total Barang</td>
                    <td class="text-center fw-bold">
                        <?php
                        $totalBarang = 0;
                        foreach($_SESSION["data_barang"] as $barang) {
                            $totalBarang += $barang['jumlah'];
                        }
                        echo $totalBarang;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center fw-bold" colspan="5">Total Harga</td>
                    <td class="text-center fw-bold">
                        <?php
                        $totalHarga = 0;
                        foreach ($_SESSION["data_barang"] as $barang) {
                            $totalHarga += $barang['total'];
                        }
                        echo "Rp " . number_format($totalHarga, 0, ',', '.');
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
