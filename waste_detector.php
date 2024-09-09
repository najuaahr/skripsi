<style>
  .loader-container {
    text-align: center;
  }

  .loader {
    border: 4px solid #f3f3f3;
    border-radius: 50%;
    border-top: 4px solid #3498db;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
  }

  .loading-text {
    font-family: Arial, sans-serif;
    font-size: 18px;
    margin-top: 20px;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>

<!-- Masthead-->
<header class="masthead">
  <div class="container position-relative">
    <div class="row justify-content-center">
      <div class="col-xl-6">

        <div class="text-center text-white" id="form-data-diri">
          <h1 class="mb-5">Deteksi Sampah</h1>
          <div class="row">
            <h2 style="text-align:left">Upload Gambar :</h2>
            <input type="file" class="form-control form-control-lg" name="gambar" id="image-input" accept="image/*" style="margin-bottom:15px">
            <div id="preview-container"></div>
          </div>
          <div class="loader-container" hidden>
            <div class="loader"></div>
            <div class="loading-text">Loading...</div>
          </div>
          <div class="row" style="margin-top:15px" id="form-hasil" hidden>
            <h1 id='hasil'>Sampah</h1>
            <p id='presentase'></p>
            <textarea name="" id='desc' cols="20" rows="20" readonly style="text-align: justify;"> Ini adalah sampah ... </textarea>
          </div>
          <div class="row" style="margin-top:15px">
            <button class="btn btn-primary btn-lg" id="mulaiInterviewButton" type="button" onclick="predict()">Deteksi</button>
          </div>

        </div>

      </div>
    </div>
  </div>
</header>
<!-- Footer-->
<footer class="footer bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 h-100 text-center text-lg-start my-auto">

        <p class="text-muted small mb-4 mb-lg-0">&copy; Deteksi Sampah 2024. All Rights Reserved.</p>
      </div>
      <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
        <ul class="list-inline mb-0"></ul>
      </div>
    </div>
  </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>

<script>
  var waste_desc = [
    "Mendaur ulang kardus merupakan langkah penting dalam menjaga kelestarian lingkungan dan ketersediaan sumber daya. Mulailah dengan merapikan kotak bekas untuk menghemat ruang dan memudahkan proses pengangkutan. Pastikan kardus dibersihkan dari bahan non-kardus seperti selotip atau plastik agar proses daur ulang berjalan dengan lancar. Selanjutnya, lakukan pengecekan dengan pusat daur ulang lokal untuk memastikan apakah mereka menerima kardus. Apabila iya, silakan letakkan kardus tersebut di dalam bak daur ulang yang telah ditentukan. Dengan mendaur ulang kardus, kita turut serta dalam menjaga kebersihan lingkungan dan melestarikan sumber daya alam.",
    "Mendaur ulang karton merupakan langkah penting dalam menjaga lingkungan dan sumber daya. Mulailah dengan memecah kotak bekas agar lebih mudah disimpan dan dibawa. Pastikan untuk membersihkan karton dari benda-benda seperti pita atau plastik agar proses daur ulangnya lancar. Selanjutnya, cek apakah pusat daur ulang lokal menerima karton. Jika ya, cukup letakkan karton di tempat yang sudah ditentukan untuk daur ulang. Dengan mendaur ulang karton, kita turut berkontribusi dalam menjaga kebersihan lingkungan serta melestarikan sumber daya alam.",
    "Pengelolaan limbah logam sangat penting untuk lingkungan dan sumber daya. Pisahkan limbah logam menjadi dua: yang mengandung besi dan yang tidak. Daur ulang logam membantu menjaga lingkungan dan mengurangi emisi gas rumah kaca. Gunakan kembali atau sumbangkan barang-barang logam yang masih layak. Dengan mengelola limbah logam dengan baik, kita ikut berkontribusi pada keberlanjutan ekonomi dan mengurangi polusi lingkungan.",
    "Mendaur ulang kertas adalah cara yang simpel tapi penting untuk menjaga lingkungan. Mulailah dengan mengumpulkan kertas bekas seperti koran, majalah, karton, dan kertas kantor. Pisahkan kertas yang tercemar, lalu hancurkan menjadi potongan-potongan kecil. Letakkan kertas tersebut di dalam bak daur ulang atau bawa ke pusat daur ulang. Pabrik kertas akan mengolah kertas bekas menjadi produk baru. Daur ulang kertas membantu menghemat sumber daya dan energi, serta mendukung masa depan yang lebih berkelanjutan.",
    "Daur ulang plastik penting untuk menjaga lingkungan dan sumber daya. Identifikasi jenis plastik yang Anda miliki. Bersihkan dan pisahkan plastik dari kontaminan. Tempatkan plastik yang sudah dipilah ke dalam bak daur ulang atau bawa ke tempat daur ulang. Plastik yang terkumpul akan diolah menjadi pelet atau serpihan. Pelet atau serpihan tersebut digunakan untuk membuat produk plastik baru. Dengan mendaur ulang plastik, Anda membantu mengurangi sampah dan polusi lingkungan. Turut berkontribusi dalam menjaga keberlanjutan dan kebersihan lingkungan.",
    "Pengelolaan sampah sangat penting untuk menjaga kebersihan lingkungan dan keberlanjutan. Pisahkan sampah menjadi tiga bagian: organik, yang bisa didaur ulang, dan yang tidak bisa didaur ulang. Sampah organik bisa dijadikan kompos untuk tanaman. Bahan yang bisa didaur ulang seperti kertas, karton, kaca, dan plastik harus dipilah dan dikirim ke tempat daur ulang. Sampah yang tidak bisa didaur ulang seperti beberapa jenis plastik dan Styrofoam harus dibuang di tempat sampah khusus. Patuhi peraturan setempat untuk mengurangi dampak lingkungan. Kurangi sampah dengan menggunakan barang-barang yang bisa digunakan kembali dan hindari penggunaan plastik sekali pakai. Dengan pengelolaan sampah yang baik, kita mendukung lingkungan yang bersih dan masa depan yang berkelanjutan."
  ];

  function findWasteIndex(input) { //buat ubah indeks kelas jd tulisan labelnya
    var wasteTypes = ["cardboard", "glass", "metal", "paper", "plastic", "trash"];
    // Convert input to lowercase for case-insensitive comparison
    var inputLower = input.toLowerCase();

    // Loop through the array
    for (var i = 0; i < wasteTypes.length; i++) {
      // Convert current array element to lowercase for comparison
      var typeLower = wasteTypes[i].toLowerCase();

      // Check if the input matches the current element
      if (typeLower === inputLower) {
        // Return the index if a match is found
        return i;
      }
    }

    // Return -1 if no match is found
    return -1;
  }

  document.getElementById('image-input').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function(event) {
        var image = new Image();
        image.src = event.target.result;
        image.onload = function() {
          var previewContainer = document.getElementById('preview-container');
          previewContainer.innerHTML = '';
          var previewImage = document.createElement('img');
          previewImage.id = 'preview-image';
          previewImage.src = this.src;
          previewImage.style.maxWidth = '400px';
          previewContainer.appendChild(previewImage);
        };
      };
      reader.readAsDataURL(file);
    }
  });

  function showLoader() {
    var loaderContainer = document.querySelector('.loader-container');
    if (loaderContainer) {
      loaderContainer.removeAttribute('hidden');
    }
  }

  function hideLoader() {
    var loaderContainer = document.querySelector('.loader-container');
    if (loaderContainer) {
      loaderContainer.setAttribute('hidden', true);
    }
  }

  function predict() {
    var fileInput = document.getElementById('image-input');
    var file = fileInput.files[0];
    var file_gambar = "";
    var reader = new FileReader();
    if (!fileInput.files || !fileInput.files[0]) {
      alert('Pendeteksian gagal: tidak ada gambar');
    } else {
      showLoader();
      reader.onload = function(event) {
        file_gambar = event.target.result;
        // console.log(file_gambar);
        $.ajax({
          type: 'POST',
          url: 'AIScript.php',
          data: {
            gambar: file_gambar
          },
          success: function(response) {
            hideLoader();
            // Mengubah isi textarea dengan respons dari server
            var data = JSON.parse(response, true); //buat ambil json
            var results = data;
            console.log(data);
            document.getElementById('form-hasil').hidden = false;
            $('#hasil').html("sampah " + results.result);
            $('#presentase').html(results.prediction_labels[0] + ': ' + (results.prediction_results[0] * 100).toFixed(2) + '%, ' + results.prediction_labels[1] + ': ' + (results.prediction_results[1] * 100).toFixed(2) + '%, ' + results.prediction_labels[2] + ': ' + (results.prediction_results[2] * 100).toFixed(2) + '%, ' + results.prediction_labels[3] + ': ' + (results.prediction_results[3] * 100).toFixed(2) + '%, ' + results.prediction_labels[4] + ': ' + (results.prediction_results[4] * 100).toFixed(2) + '%, ' + results.prediction_labels[5] + ': ' + (results.prediction_results[5] * 100).toFixed(2) + '%');
            $('#desc').html(waste_desc[findWasteIndex(results.result)]);
          },
          error: function(error) {
            console.error('Error:', error);
          }
        });
      };
      reader.readAsDataURL(file);
    }
  }
</script>