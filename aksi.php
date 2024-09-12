<?php

function tambahTransaksi($akun_debit, $akun_kredit, $total, $deskripsi, $kode_transaksi, $jenis_transaksi, $tanggal_transaksi, $conn)
{
    $sql = "INSERT INTO transaksi (akun_debit, akun_kredit, total, deskripsi, kode_transaksi, jenis_transaksi, tanggal_transaksi) 
    VALUES ('$akun_debit', '$akun_kredit', '$total', '$deskripsi', '$kode_transaksi', '$jenis_transaksi', '$tanggal_transaksi')";
    $result = $conn->query($sql);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
        echo $conn->error;
    }
}
function hapusTransaksi($id, $conn)
{
    $sql = "DELETE FROM transaksi WHERE kode_transaksi = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
        echo $conn->error;
    }
}

function editPembelian($conn, $akun_debit, $akun_kredit, $total, $deskripsi, $kode_transaksi, $jenis_transaksi, $tanggal_transaksi)
{
    $sql = "UPDATE transaksi SET akun_debit = '$akun_debit', akun_kredit = '$akun_kredit', total = '$total', deskripsi = '$deskripsi', tanggal_transaksi = '$tanggal_transaksi', jenis_transaksi = '$jenis_transaksi' WHERE kode_transaksi = '$kode_transaksi'";
    $result = $conn->query($sql);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
        echo $conn->error;
    }
}
require_once 'config.php';
switch ($_GET['aksi'] ?? '') {
    case 'tambah-pengguna':
        $username = filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW);
        $nama_user = filter_input(INPUT_POST, 'nama_user', FILTER_UNSAFE_RAW);
        $level = filter_input(INPUT_POST, 'level', FILTER_UNSAFE_RAW);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO pengguna (username, password, level, nama) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $level, $nama_user);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan',
                'error' => $stmt->error
            ]);
        }
        $stmt->close();
        break;
    case 'edit-pengguna':

        $stmt = $conn->prepare("UPDATE pengguna SET username = ?, nama = ?, level = ? WHERE id = ?");
        $stmt->bind_param("sssi", $_POST['username'], $_POST['nama_user'], $_POST['level'], $_POST['id']);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data gagal diubah', 'error' => $stmt->error]);
        }
        $stmt->close();

        break;
    case 'hapus-pengguna':
        $kode_user = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM pengguna WHERE id = ?");
        $stmt->bind_param("i", $kode_user);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
                'error' => $stmt->error
            ]);
        }

        break;
    case 'ganti-password':
        $stmt = $conn->prepare("UPDATE pengguna SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password, $id);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id = $_POST['id'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Password berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Password gagal diubah', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;

    // proses tambah pelanggan
    case 'tambah-pelanggan':
        $stmt = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, kontak) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_pelanggan, $alamat_pelanggan, $no_hp);
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $alamat_pelanggan = $_POST['alamat_pelanggan'];
        $no_hp = $_POST['no_hp'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data pelanggan berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data pelanggan gagal ditambahkan', 'error' => $stmt->error]);

        }
        $stmt->close();
        break;
    case 'edit-pelanggan':
        $stmt = $conn->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, kontak = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama_pelanggan, $alamat_pelanggan, $no_hp, $id);
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $alamat_pelanggan = $_POST['alamat_pelanggan'];
        $no_hp = $_POST['no_hp'];
        $id = $_POST['id'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data pelanggan berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data pelanggan gagal diubah', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'hapus-pelanggan':
        $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data pelanggan berhasil dihapus']);
        } else {
            http_response_code(500);
            echo $stmt->error;
        }
        $stmt->close();
        break;
    // supplier
    case 'tambah-supplier':
        $stmt = $conn->prepare("INSERT INTO supplier (nama_supplier, kontak_supplier) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_supplier, $kontak);
        $nama_supplier = $_POST['nama_supplier'];
        $kontak = $_POST['kontak_supplier'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data supplier berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data supplier gagal ditambahkan', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'edit-supplier':
        $stmt = $conn->prepare("UPDATE supplier SET nama_supplier = ?, kontak_supplier = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nama_supplier, $kontak, $_POST['id']);
        $nama_supplier = $_POST['nama_supplier'];
        $kontak = $_POST['kontak_supplier'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data supplier berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data supplier gagal diubah', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'hapus-supplier':
        $stmt = $conn->prepare("DELETE FROM supplier WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data supplier berhasil dihapus']);
        } else {
            http_response_code(500);
            echo $stmt->error;
        }
        $stmt->close();
        break;
    // tambah produk
    case 'tambah-produk':
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, satuan, harga_beli, harga_jual, kategori_produk) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama_produk, $satuan, $harga_beli, $harga_jual, $kategori_produk);
        $nama_produk = $_POST['nama_produk'];
        $satuan = $_POST['satuan'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $kategori_produk = $_POST['kategori_produk'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data produk berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data produk gagal ditambahkan', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'edit-produk':
        $stmt = $conn->prepare("UPDATE produk SET nama_produk = ?, satuan = ?, harga_beli = ?, harga_jual = ?, kategori_produk = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nama_produk, $satuan, $harga_beli, $harga_jual, $kategori_produk, $_POST['id']);
        $nama_produk = $_POST['nama_produk'];
        $satuan = $_POST['satuan'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $kategori_produk = $_POST['kategori_produk'];
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data produk berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data produk gagal diubah', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'hapus-produk':
        $stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data produk berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data produk gagal dihapus', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    // akun
    case 'tambah-akun':
        $stmt = $conn->prepare("INSERT INTO akun (nama_akun, kode_akun, kategori_akun, wajib) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $_POST['nama_akun'], $_POST['kode_akun'], $_POST['kategori_akun'], $wajib);
        $wajib = '0';
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data akun berhasil ditambahkan']);

        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data akun gagal ditambahkan', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'edit-akun':
        $nama_akun = $_POST['nama_akun'];
        $kode_akun = $_POST['kode_akun'];
        $kategori_akun = $_POST['kategori_akun'];
        $sql = "UPDATE akun SET nama_akun = '$nama_akun', kode_akun = '$kode_akun', kategori_akun = '$kategori_akun' WHERE id = '$_POST[id]'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data akun berhasil diubah']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data akun gagal diubah', 'error' => $conn->error]);
        }
        break;
    case 'hapus-akun':
        $stmt = $conn->prepare("DELETE FROM akun WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data akun berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data akun gagal dihapus', 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
    case 'tambah-transaksi':
        $akun_debit = $_POST['id_akun_debit'];
        $akun_kredit = $_POST['id_akun_kredit'];
        $total = $_POST['total'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $kode_jurnal = 'JRNL' . date('YmdHis');
        $jenis_transaksi = $_POST['jenis_transaksi'];
        tambahTransaksi($akun_debit, $akun_kredit, $total, $deskripsi, $kode_jurnal, $jenis_transaksi, $tanggal_transaksi, $conn);
        echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil ditambahkan']);
        break;
    case 'hapus-transaksi':
        $id = $_POST['id'];
        $sql = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus', 'error' => $conn->error]);
        }
        break;
    case 'tambah-pembelian':
        $id_pengguna = $_POST['id_pengguna'];
        $akun_debit = $_POST['akun_debit'];
        $akun_kredit = $_POST['akun_kredit'];
        $id_produk = $_POST['id_produk'];
        $id_supplier = $_POST['id_supplier'];
        $kode_pembelian = $_POST['kode_pembelian'];
        $harga_beli = $_POST['harga_beli'];
        $qty = $_POST['qty'];
        $total = $harga_beli * $qty;
        $deskripsi = 'Pembelian dengan kode' . $kode_pembelian;
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        try {
            tambahTransaksi($akun_debit, $akun_kredit, $total, $deskripsi, $kode_pembelian, 'Pengeluaran', $tanggal_transaksi, $conn);
            $sql = "INSERT INTO pembelian (id_supplier, id_produk, qty, harga_beli, total, kode_pembelian, tanggal_transaksi, id_pengguna) 
            VALUES ('$id_supplier', '$id_produk', '$qty', '$harga_beli', '$total', '$kode_pembelian', '$tanggal_transaksi', '$id_pengguna')";
            $result = $conn->query($sql);
            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Data pembelian berhasil ditambahkan']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data pembelian gagal ditambahkan', 'error' => $e->getMessage()]);
        }
        break;
    case 'edit-pembelian':
        $id_pengguna = $_POST['id_pengguna'];
        $akun_debit = $_POST['akun_debit'];
        $akun_kredit = $_POST['akun_kredit'];
        $id_produk = $_POST['id_produk'];
        $id_supplier = $_POST['id_supplier'];
        $kode_pembelian = $_POST['kode_pembelian'];
        $harga_beli = $_POST['harga_beli'];
        $qty = $_POST['qty'];
        $total = $harga_beli * $qty;
        $deskripsi = 'Pembelian dengan kode' . $kode_pembelian;
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        try {
            editPembelian($conn, $akun_debit, $akun_kredit, $total, $deskripsi, $kode_pembelian, 'Pengeluaran', $tanggal_transaksi);
            $sql = "UPDATE pembelian SET id_supplier = '$id_supplier', id_produk = '$id_produk', qty = '$qty', harga_beli = '$harga_beli', total = '$total', kode_pembelian = '$kode_pembelian', tanggal_transaksi = '$tanggal_transaksi', id_pengguna = '$id_pengguna' WHERE kode_pembelian = '$kode_pembelian'";
            $result = $conn->query($sql);
            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Data pembelian berhasil diedit']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data pembelian gagal diedit', 'error' => $e->getMessage()]);
        }
        break;

    case 'hapus-pembelian':
        $kode_transaksi = $_POST['kode_transaksi'];
        $sql = "DELETE FROM pembelian WHERE kode_pembelian = '$kode_transaksi'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data pembelian berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data pembelian gagal dihapus', 'error' => $conn->error]);
        }
        hapusTransaksi($kode_transaksi, $conn);

        break;
    case 'keranjang':
        $id_produk = $_POST['id_produk'];
        $qty = $_POST['qty'];
        $harga_jual = $_POST['harga_jual'];
        $harga_beli = $_POST['harga_beli'];
        $tanggal_transaksi = date('Y-m-d');
        $id_pelanggan = $_POST['id_pelanggan'];
        $id_pengguna = $_POST['id_pengguna'];
        $kode_penjualan = $_POST['kode_penjualan'];
        $total = $qty * $harga_jual;
        $sql = "INSERT INTO keranjang (id_produk, qty, harga_jual, harga_beli, kode_penjualan, tanggal_transaksi, id_pelanggan, total)
        VALUES ('$id_produk', '$qty', '$harga_jual', '$harga_beli', '$kode_penjualan', '$tanggal_transaksi', '$id_pelanggan', '$total')";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data keranjang berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data keranjang gagal ditambahkan', 'error' => $conn->error]);
        }
        break;
    case 'hapus-keranjang':
        $id = $_POST['id'];
        $sql = "DELETE FROM keranjang WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data keranjang berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data keranjang gagal dihapus', 'error' => $conn->error]);
        }
        break;
    case 'tambah-penjualan':
        $akun_debit = 10; // id akun hpp
        $akun_kredit = 8; // id akun persediaan
        $total = $_POST['harga_beli'];
        $deskripsi = 'HPP dari penjualan ' . $_POST['kode_penjualan'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $kode_penjualan = $_POST['kode_penjualan'];
        tambahTransaksi($akun_debit, $akun_kredit, $total, $deskripsi, $kode_penjualan, 'Pengeluaran', $tanggal_transaksi, $conn);

        $akun_debit = 1; //akun kas
        $akun_kredit = 3; //akun pendapatan
        $total = $_POST['harga_jual'];
        $deskripsi = 'Penjualan dari kode ' . $_POST['kode_penjualan'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        tambahTransaksi($akun_debit, $akun_kredit, $total, $deskripsi, $kode_penjualan, 'Pendapatan', $tanggal_transaksi, $conn);

        // simpan penjualan ke tabel penjualan
        $id_pengguna = $_POST['id_pengguna'];
        $total = $_POST['total'];
        $sql = "INSERT INTO penjualan (id_pengguna, total, kode_penjualan, tanggal_transaksi) 
        VALUES ('$id_pengguna', '$total', '$kode_penjualan', '$tanggal_transaksi')";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data penjualan berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data penjualan gagal ditambahkan', 'error' => $conn->error]);
        }
        //update detail penjualan
        $sql = "UPDATE keranjang SET tanggal_transaksi = '$tanggal_transaksi' WHERE kode_penjualan = '$kode_penjualan'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
        } else {
            http_response_code(500);
            echo $conn->error;
        }
        break;





}