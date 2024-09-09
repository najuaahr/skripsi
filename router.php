<?php
/* mengatur jalur halaman ditampilkan */
@$page = $_GET['page'];

if ($page == '' || !$page || $page == 'home') {
    include 'home.php';
} else if ($page == 'waste_detector') {
    include 'waste_detector.php';
} else if ($page == 'info_sampah') {
    include 'info_sampah.php';
}
