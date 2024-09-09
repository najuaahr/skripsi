<?php
$gambar = isset($_POST['gambar']) ? $_POST['gambar'] : '';

// Gantilah path ke executable Python di bawah sesuai dengan instalasi Anaconda Anda
$pythonExecutable = 'C:/Users/Lenovo/anaconda3/python.exe';
// Gantilah path ke skrip Python Anda di bawah
$pythonScript = 'AI/nb.py';

$data = explode(',', $gambar);

// Ambil tipe file dari metadata
$type = explode(';', $data[0]);
$type = explode(':', $type[0]);
$type = $type[1];
$uid = uniqid(); //penamaan file di testing2
$outputFile = 'AI/testing2/' . $uid . '.png';
// Decode base64 dan simpan sebagai file
$decodedData = base64_decode($data[1]); //mendekode data base64 yang disimpan menjadi data byte
file_put_contents($outputFile, $decodedData);


// Bangun command untuk dieksekusi
$command = "$pythonExecutable $pythonScript '$uid.png' ";
$output = shell_exec($command); //kaya buka cmd
// echo $command;

// Jalankan command dan dapatkan outputnya
try {
    $output = shell_exec($command);
    echo $output;
} catch (Exception $error) {
    echo "Error: " . $error->getMessage();
}
