<?php

// Data biaya pengiriman antar kota
$routes = [
    ['start' => 'Blitar', 'end' => 'Malang Kota', 'cost' => 10000],
    ['start' => 'Blitar', 'end' => 'Malang Timur', 'cost' => 9000],
    ['start' => 'Blitar', 'end' => 'Surabaya Selatan', 'cost' => 15000],
    ['start' => 'Blitar', 'end' => 'Surabaya Utara', 'cost' => 12000],
    ['start' => 'Blitar', 'end' => 'Surabaya Barat', 'cost' => 15500],
    ['start' => 'Blitar', 'end' => 'Bandung', 'cost' => 22000],
    ['start' => 'Blitar', 'end' => 'Jakarta', 'cost' => 32000],
    ['start' => 'Blitar', 'end' => 'Bekasi', 'cost' => 50000],
    ['start' => 'Blitar', 'end' => 'Bekasi', 'cost' => 51000],
    ['start' => 'Blitar', 'end' => 'Palembang', 'cost' => 100000],
    ['start' => 'Blitar', 'end' => 'Semarang', 'cost' => 15000],
    ['start' => 'Blitar', 'end' => 'Palembang', 'cost' => 7000],
    ['start' => 'Blitar', 'end' => 'Madura', 'cost' => 12000],
    ['start' => 'Blitar', 'end' => 'Bali', 'cost' => 22000],
    ['start' => 'Blitar', 'end' => 'Bandung', 'cost' => 22000],
    ['start' => 'Blitar', 'end' => 'Bandung', 'cost' => 21000],
    // Anda dapat menambahkan data lain sesuai kebutuhan
];

function findOptimalRoute($routes, $start, $end) {
    $dp = [];
    $dp[$start] = 0;  // Biaya untuk mencapai kota awal adalah 0

    foreach ($routes as $route) {
        $currentStart = $route['start'];
        $currentEnd = $route['end'];
        $cost = $route['cost'];

        // Jika kita sudah memiliki biaya untuk mencapai kota awal saat ini dan belum ada biaya untuk kota tujuan,
        // atau biaya saat ini lebih murah, maka update biaya untuk kota tujuan.
        if (isset($dp[$currentStart]) && (!isset($dp[$currentEnd]) || $dp[$currentStart] + $cost < $dp[$currentEnd])) {
            $dp[$currentEnd] = $dp[$currentStart] + $cost;
        }
    }
     // Kembalikan biaya optimal untuk mencapai kota tujuan
     if ($end === 'Malang') {
        $malangKotaCost = isset($dp['Malang Kota']) ? $dp['Malang Kota'] : PHP_INT_MAX;
        $malangTimurCost = isset($dp['Malang Timur']) ? $dp['Malang Timur'] : PHP_INT_MAX;
        return min($malangKotaCost, $malangTimurCost);
    }
    if ($end === 'Surabay') {
        $surabaSelatanCost = isset($dp['Surabaya Selatan']) ? $dp['Surabaya Selatan'] : PHP_INT_MAX;
        $surabayaUtaraCost = isset($dp['Surabaya Utara']) ? $dp['Surabaya Utara'] : PHP_INT_MAX;
        $surabaBaratCost = isset($dp['Surabaya Barat']) ? $dp['Surabaya Barat'] : PHP_INT_MAX;
        return min($surabaSelatanCost, $surabayaUtaraCost,$surabaBaratCost);
    }

    // Kembalikan biaya optimal untuk mencapai kota tujuan
    return isset($dp[$end]) ? $dp[$end] : "Route not found!";
}

// Contoh penggunaan
$startCity = $_POST['start_city'] ?? '';
$endCity = $_POST['end_city'] ?? '';

if ($startCity && $endCity) {
    $result = findOptimalRoute($routes, $startCity, $endCity);
    echo "Biaya pengiriman termurah adalah: " . ($result !== "Route not found!" ? "Rp. " . number_format($result, 0, ',', '.') : $result);
} 

?>
