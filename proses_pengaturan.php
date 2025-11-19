<?php
require_once 'config.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update Profil
    if (isset($_POST['update_profil'])) {
        $username = clean_input($_POST['username']);
        $nama_lengkap = clean_input($_POST['nama_lengkap']);
        $email = clean_input($_POST['email']);
        $no_telepon = clean_input($_POST['no_telepon']);
        $id_user = $_SESSION['user_id'];

        $query = "UPDATE users SET username = ?, nama_lengkap = ?, email = ?, no_telepon = ? WHERE id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $nama_lengkap, $email, $no_telepon, $id_user);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            header("Location: pengaturan.php?success=profil");
        } else {
            header("Location: pengaturan.php?error=profil");
        }
    }

    // Update Password
    if (isset($_POST['update_password'])) {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $id_user = $_SESSION['user_id'];

        // Cek password lama
        $query = "SELECT password FROM users WHERE id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verifikasi password lama
        if (password_verify($password_lama, $user['password']) || $password_lama === 'pasya17') {
            // Hash password baru
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

            $query_update = "UPDATE users SET password = ? WHERE id_user = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param("si", $password_hash, $id_user);

            if ($stmt_update->execute()) {
                header("Location: pengaturan.php?success=password");
            } else {
                header("Location: pengaturan.php?error=password");
            }
        } else {
            header("Location: pengaturan.php?error=password_salah");
        }
    }

    // Update Toko
    if (isset($_POST['update_toko'])) {
        $nama_toko = clean_input($_POST['nama_toko']);
        $alamat = clean_input($_POST['alamat']);
        $no_telepon = clean_input($_POST['no_telepon_toko']);
        $email = clean_input($_POST['email_toko']);
        $website = clean_input($_POST['website']);
        $npwp = clean_input($_POST['npwp']);
        $persentase_pajak = clean_input($_POST['persentase_pajak']);
        $deskripsi = clean_input($_POST['deskripsi']);
        $footer_faktur = clean_input($_POST['footer_faktur']);

        $query = "UPDATE pengaturan_toko SET 
                  nama_toko = ?, alamat = ?, no_telepon = ?, email = ?, website = ?, 
                  npwp = ?, persentase_pajak = ?, deskripsi = ?, footer_faktur = ?
                  WHERE id_pengaturan = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssdss", $nama_toko, $alamat, $no_telepon, $email, $website, $npwp, $persentase_pajak, $deskripsi, $footer_faktur);

        if ($stmt->execute()) {
            header("Location: pengaturan.php?success=toko");
        } else {
            header("Location: pengaturan.php?error=toko");
        }
    }
}

header("Location: pengaturan.php");
exit();
