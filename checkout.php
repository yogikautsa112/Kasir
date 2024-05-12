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
        <div class="container-input">
            <h3 class="text-center">Bayar Sekarang</h3>
            <form action="" method="post" class="d-flex justify-content-center flex-column mb-2 gap-2">
                    <label for="" class="mb-2">Masukan Nominal Uang</label>
                    <input class="form-control border-success" type="number" name="bayar" required>
                    <?php 
                    session_start();
                    
                    $totalHarga=0;
                    if(isset($_SESSION['data_barang']) && !empty($_SESSION['data_barang'])) {
                        foreach($_SESSION['data_barang'] as $barang) {
                            $totalHarga += $barang['total'];
                        }
                        echo "<div class='mb-2 fw-bold'>Total Yang Harus dibayar: Rp " . number_format($totalHarga, 0, ',', '.') . "</div>";
                        
                        if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['btn-submit'])) {
                            $nominal = $_POST["bayar"];
                            if($nominal < $totalHarga) {
                                $kurang = $totalHarga - $nominal;
                                echo "<div class='alert alert-danger d-flex justify-content-between' role='alert'>Nominal uang yang dimasukkan kurang Rp " . number_format($kurang, 0, ',', '.') . "</div>";
                            } else {
                                $_SESSION['nominal'] = $nominal;
                                $_SESSION['totalHarga'] = $totalHarga;
                                header("Location: receipt.php?bayar=$nominal");
                                exit;
                            }
                        }
                    } else {
                        echo "<p class='text text-danger text-center fw-bold'>Tidak ada barang yang harus dibayar</p>";
                    }
                    ?>
                    <button class="btn btn-primary" type="submit" href="receipt.php" name="btn-submit"><i class="bi bi-credit-card-2-back-fill"></i> Bayar</button>
                    <a class="btn btn-secondary" type="submit" href="index.php"><i class="bi bi-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>