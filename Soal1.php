<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simulasi Tabungan Berjangka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .box {
            width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Simulasi Tabungan Berjangka</h2>

        <label>Nominal Target Tabungan (Rp)</label>
        <input type="number" id="target" placeholder="contoh: 10000000">

        <label>Pilih Mode Perhitungan</label>
        <select id="mode" onchange="tampilkanInput()">
            <option value="">-- Pilih --</option>
            <option value="bulan">Target Bulan</option>
            <option value="setoran">Setoran Tetap</option>
        </select>

        <div id="inputTambahan"></div>

        <button onclick="hitung()">Hitung Simulasi</button>

        <div id="hasil"></div>
    </div>

    <script>
        // nilai tetap
        var bunga = 0.0335;  // bunga per bulan
        var admin = 12500;   // biaya admin tiap bulan

        // menampilkan input tambahan sesuai pilihan
        function tampilkanInput(){
            var mode = document.getElementById("mode").value;
            var div = document.getElementById("inputTambahan");
            div.innerHTML = "";

            if(mode == "bulan"){
                div.innerHTML = "<label>Masukkan Jumlah Bulan</label><input type='number' id='bulan' placeholder='contoh: 12'>";
            } else if(mode == "setoran"){
                div.innerHTML = "<label>Masukkan Jumlah Setoran per Bulan (Rp)</label><input type='number' id='setoran' placeholder='contoh: 500000'>";
            }
        }

        function hitung(){
            var target = parseFloat(document.getElementById("target").value);
            var mode = document.getElementById("mode").value;
            var hasil = document.getElementById("hasil");
            hasil.innerHTML = "";

            if(isNaN(target) || mode == ""){
                alert("Mohon isi semua data terlebih dahulu!");
                return;
            }

            var total = 0;
            var tabel = "<table><tr><th>Bulan</th><th>Setoran</th><th>Bunga</th><th>Admin</th><th>Total Tabungan</th></tr>";
            var jumlahBulan = 0;

            if(mode == "bulan"){
                var bulan = parseInt(document.getElementById("bulan").value);
                if(isNaN(bulan)){
                    alert("Masukkan jumlah bulan!");
                    return;
                }
                var setoran = target / bulan;

                for(var i=1; i<=bulan; i++){
                    var bungaBulanan = total * bunga;
                    total = total + setoran + bungaBulanan - admin;
                    tabel += "<tr><td>"+i+"</td><td>Rp"+setoran.toLocaleString()+"</td><td>Rp"+bungaBulanan.toLocaleString()+"</td><td>Rp"+admin.toLocaleString()+"</td><td>Rp"+total.toLocaleString()+"</td></tr>";
                }
                jumlahBulan = bulan;
            }

            else if(mode == "setoran"){
                var setoran = parseFloat(document.getElementById("setoran").value);
                if(isNaN(setoran)){
                    alert("Masukkan jumlah setoran!");
                    return;
                }

                var i = 0;
                while(total < target){
                    i++;
                    var bungaBulanan = total * bunga;
                    total = total + setoran + bungaBulanan - admin;
                    tabel += "<tr><td>"+i+"</td><td>Rp"+setoran.toLocaleString()+"</td><td>Rp"+bungaBulanan.toLocaleString()+"</td><td>Rp"+admin.toLocaleString()+"</td><td>Rp"+total.toLocaleString()+"</td></tr>";
                }
                jumlahBulan = i;
            }

            tabel += "</table>";
            hasil.innerHTML = "<h3>Rincian Simulasi selama "+jumlahBulan+" bulan</h3>" + tabel;
        }
    </script>
</body>
</html>
