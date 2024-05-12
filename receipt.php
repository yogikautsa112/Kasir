<?php
session_start();

$nominal = isset($_SESSION['nominal']) ? $_SESSION['nominal'] : 0;
$totalHarga = isset($_SESSION['totalHarga']) ? $_SESSION['totalHarga'] : 0;

$kembalian = $nominal - $totalHarga;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h2 class="text-center mb-4">Bukti Pembayaran</h2>
                <div class="mb-4">
                    <p>No. Transaksi #<?php echo rand(10,1000000000)?></p>
                    <p>Tanggal #<?php echo date("Y-m-d H:i:s"); ?></p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Barang</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($_SESSION["data_barang"]) && !empty($_SESSION["data_barang"]))  {
                            foreach ($_SESSION["data_barang"] as $barang){
                                echo "<tr>";
                                echo "<td>".$barang['nama']."</td>";
                                echo "<td>Rp " . number_format($barang['harga'], 0, ',', '.') . "</td>";
                                echo "<td>".$barang['jumlah']."</td>";
                                echo "<td>Rp " . number_format($barang['total'], 0, ',', '.') . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="mb-4">
                    <p><strong>Uang Yang Dibayarkan:</strong> Rp <?php echo number_format($nominal, 0, ',', '.'); ?></p>
                    <p><strong>Total :</strong> Rp <?php echo number_format($totalHarga, 0, ',', '.'); ?></p>
                    <?php if($kembalian > 0 ): ?>
                        <p><strong>Kembalian: </strong> Rp <?php echo number_format($kembalian, 0, ',', '.'); ?></p>
                    <?php endif; ?>
                </div>
                    <div>
                        <a href="index.php" class="btn btn-primary">Kembali</a>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>
