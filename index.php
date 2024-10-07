<?php
// Koneksi ke database
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "undangan";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses pengiriman komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $komentar = $_POST['komentar'];
  // Capture the attendance choice, allowing it to be null
  $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : null; 

  // Menyimpan komentar ke database
  // Use prepared statements to prevent SQL Injection
  $stmt = $conn->prepare("INSERT INTO ucapan (nama, komentar, attendance, tanggal) VALUES (?, ?, ?, NOW())");
  // Bind parameters correctly; 's' for string, and attendance can be null
  $stmt->bind_param("sss", $nama, $komentar, $attendance); 

  if ($stmt->execute()) {
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
  } else {
      echo "Error: " . $stmt->error; // Use prepared statement error
  }
}


// Function to calculate time ago
function timeAgo($timestamp) {
    $timeDiff = time() - strtotime($timestamp); // Calculate the time difference in seconds

    $years = floor($timeDiff / (365 * 60 * 60 * 24));
    $days = floor(($timeDiff % (365 * 60 * 60 * 24)) / (60 * 60 * 24));
    $hours = floor(($timeDiff % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($timeDiff % (60 * 60)) / 60);

    $timeString = "";
    if ($years > 0) {
        $timeString .= $years . " tahun, ";
    }
    if ($days > 0) {
        $timeString .= $days . " hari, ";
    }
    if ($hours > 0) {
        $timeString .= $hours . " jam, ";
    }
    if ($minutes > 0) {
        $timeString .= $minutes . " menit lalu";
    }

    return rtrim($timeString, ', '); // Remove the trailing comma and space
}

// Mengambil semua komentar
$sql = "SELECT nama, komentar, tanggal, attendance FROM ucapan ORDER BY tanggal DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan</title>
    
    <!-- Include Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rozha+One&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
      body {
        font-family: "Rozha One", serif;
      }

      .bride-groom-name,
      .profile {
        height: 100vh;
        overflow: auto; /* Add scroll if necessary */
        padding: 60px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .bride-groom-name {
        background-color: #f9f9f9;
        color: #d9534f;
      }

      .profile {
        background-color: white;
        color: #d9534f;
      }

      .profile .person {
        margin: 20px;
      }

      .wedding-countdown {
        margin: 0;
        padding: 40px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        color: #d9534f;
      }

      .countdown-timer {
        display: flex;
        justify-content: center;
        margin: 20px 0;
      }

      .time-unit {
        text-align: center;
        margin: 0 15px;
      }

      .countdown-number {
        font-size: 40px;
        font-weight: bold;
        color: #d9534f;
      }

      .countdown-label {
        font-size: 20px;
        color: #d9534f;
      }

      .date-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
      }

      .large-number {
        font-size: 3em;
        margin: 0 10px;
      }

      .btn-custom-rounded {
        border-radius: 30px;
      }

      .comment-section{
        color: #d9534f;
        margin-top: 20px;
        text-align: left;
      }

      .comment-section h2{
        text-align: center;
      }

      .comment-section form {
        margin-bottom: 20px;
      }

      .comment-section input, .comment-section textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
      }

      .footer {
        margin-top: 20px;
      }

      .tanggal {
        color: grey;
      }

      .komen-cik {
        color: rgba(0, 0, 0, .80);
        font-size: 12px;
      }

      .badge {
        font-size: 12px;
        
      }

      /* Mobile Specific Adjustments */

      @media only screen and (max-width: 768px) {
        .bride-groom-name,
        .profile,
        .wedding-countdown {
          display: flex;
          flex-direction: column;
          align-items: center;
          padding: 20px;
        }
      }
    </style>
</head>
<body>
    <!-- Section pertama: Nama Pengantin -->
    <section class="bride-groom-name">
        <h3>PERNIKAHAN</h3>
        <h1> Lisa Nur Fitriani<br>& <br>Ibnu Hanafi, S.Kom</h1>
        <h3>26 Juni 2026</h3>
    </section>

    <!-- Section ketiga: Profil Pengantin -->
    <section class="profile">
        <div class="container">
            <img src="https://bynoia.com/wp-content/uploads/2023/10/bismillah1.png" alt="Bismillah" class="img-fluid mb-3" style="max-width: 20%; height: auto;">
            <h3>Assalamualaikum Wr. Wb</h3>
            <p>Ya Allah, dengan segala kesucian hati, kami bersujud memohon Ridho-Mu, untuk menuju Sunnah Rasul-Mu, membentuk keluarga yang sakinah, mawaddah, warohmah.</p>
            <div class="row">
                <div class="col person">
                    <h4 class="border-bottom col-md pb-2 mb-4">Lisa Nur Fitriani</h4>
                    <p>Putri Ke-2 dari <br> Bapak Endro <br> & <br> Ibu Diah</p>
                    <a class="btn btn-danger btn-custom-rounded" href="https://www.instagram.com/lisanftrn/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="col person">
                    <h4 class="border-bottom col-md pb-2 mb-4">Ibnu Hanafi, S.Kom</h4>
                    <p>Putra Ke-1 dari<br>Bapak Kusaeni <br> & <br> Ibu Piatun</p>
                    <a class="btn btn-danger btn-custom-rounded" href="https://www.instagram.com/ibnhanafi.i/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Countdown Pernikahan -->
    <section class="wedding-countdown">
        <h3>Menghitung Hari</h3>
        <h2>Pernikahan</h2>
        <div class="countdown-timer" id="countdown">
            <div class="time-unit">
                <span id="days" class="countdown-number">00</span>
                <span class="countdown-label">Hari</span>
            </div>
            <div class="time-unit">
                <span id="hours" class="countdown-number">00</span>
                <span class="countdown-label">Jam</span>
            </div>
            <div class="time-unit">
                <span id="minutes" class="countdown-number">00</span>
                <span class="countdown-label">Menit</span>
            </div>
            <div class="time-unit">
                <span id="seconds" class="countdown-number">00</span>
                <span class="countdown-label">Detik</span>
            </div>
        </div>
        <p>Dengan memohon Ridho serta Rahmat Allah SWT, kami bermaksud menyelenggarakan Pernikahan kami yang Insya Allah akan diselenggarakan pada:</p>
        <div class="container">
            <div class="row">
                <div class="col person text-center">
                    <h4 class="border-bottom col-md pb-2 mb-4">Akad Nikah</h4>
                    <p><strong>Juni</strong></p>
                    <p class="date-container">
                        <span>Jum'at</span>
                        <strong class="large-number">24</strong>
                        <span>2026</span>
                    </p>
                    <p><strong>07.00 WIB <br> s/d Selesai</strong></p>
                    <p class="border-top col-md pb-2 mb-4">Jalur Gaza</p>
                    <a class="btn btn-danger" href="https://maps.app.goo.gl/zw8yj19gQHKUmFBB9" target="_blank"><i class="fas fa-map"></i> Lokasi</a>
                </div>
                <div class="col person text-center">
                    <h4 class="border-bottom col-md pb-2 mb-4">Resepsi</h4>
                    <p><strong>Juni</strong></p>
                    <p class="date-container">
                        <span>Sabtu</span>
                        <strong class="large-number">25</strong>
                        <span>2026</span>
                    </p>
                    <p><strong>07.00 WIB <br> s/d Selesai</strong></p>
                    <p class="border-top col-md pb-2 mb-4">Jalur Gaza</p>
                    <a class="btn btn-danger" href="https://maps.app.goo.gl/zw8yj19gQHKUmFBB9" target="_blank"><i class="fas fa-map"></i> Lokasi</a>
                </div>
            </div>
        </div>
    </section>
    <section class="comment-section">
    <div class="container">
        <h2>Doa & Ucapan</h2>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required>
            </div>
            <div class="form-group">
                <textarea name="komentar" class="form-control" placeholder="Ucapan" required></textarea>
            </div>
            <div class="form-group">
                <select name="attendance" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                    <option disabled selected>Konfirmasi Kehadiran</option>
                    <option value="hadir">Hadir</option>
                    <option value="tidak hadir">Tidak Hadir</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Kirim</button>
        </form>
        <hr>

        <div id="commentsCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
            <div class="carousel-inner">
                <?php if ($result->num_rows > 0): ?>
                    <?php $isActive = true; ?>
                    <?php $cardsInRow = 0; ?>
                    <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                        <div class="row justify-content-center">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="col-md-4 col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama']); ?><?php if (isset($row['attendance'])): ?>
                                                <?php if ($row['attendance'] === 'hadir'): ?>
                                                    <span class="badge badge-success">Hadir <i class="fas fa-check"></i></span>
                                                <?php elseif ($row['attendance'] === 'tidak_hadir'): ?>
                                                    <span class="badge badge-danger">Tidak Hadir <i class="fas fa-times-circle"></i></span>
                                                <?php endif; ?>
                                            <?php endif; ?></h5>
                                            
                                            <p class="komen-cik"><?php echo htmlspecialchars($row['komentar']); ?></p>
                                            <small class="text-muted"><?php echo date("d M Y H:i", strtotime($row['tanggal'])); ?> lalu</small>
                                        </div>
                                    </div>
                                </div>
                                <?php $cardsInRow++; ?>
                                <?php if ($cardsInRow % 3 === 0): // Change 3 to 2 if you want two items in larger screens ?>
                                    </div></div> <!-- Close current row and carousel item -->
                                    <div class="carousel-item">
                                        <div class="row justify-content-center"> <!-- Start new row -->
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php $isActive = false; ?>
                <?php else: ?>
                    <p>Belum ada ucapan selamat.</p>
                <?php endif; ?>
            </div>
            <a class="carousel-control-prev" href="#commentsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#commentsCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>

    <footer class="footer">
      <div class="container">
        <p>&copy; 2024 pratnoken studio code</p>
      </div>
    </footer>

    <!-- Script untuk countdown -->
    <script>
        function countdown() {
            var weddingDate = new Date("Oct 4, 2026 07:00:00").getTime();
            var now = new Date().getTime();
            var distance = weddingDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update the countdown display
            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;

            if (distance < 0) {
                document.getElementById("countdown").innerHTML = "Acara telah selesai";
            }
        }
        setInterval(countdown, 1000);
    </script>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
