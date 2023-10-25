<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<style>
        .dropbtn {
            background-color: transparent;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        
        .dropdown-list {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 15px;
            padding-top: 12px;
            padding-bottom: 13px;
        }
        
        .dropdown-list a {
            color: black;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
        }
        
        .dropdown-list a:hover {
            color: blue;
        }
        
        .left-menu-header:hover .dropdown-list {
            display: block;
        }
        
        .left-menu-header:hover .dropbtn {
            background-color: transparent;
        }
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 24}
</style>

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index_barang.php">Barang</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="jenis_barang.php">Jenis Barang</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="lokasi.php">Lokasi</a>
    </li> 

    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="riwayat_lokasi.php">History Perpindahan </a>
    </li>

    <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
                $db_hostname = "localhost";
                $db_database = "db_inventarisit";
                $db_username = "root";
                $db_password = "";
                $db_charset = "utf8mb4";
                $dsn ="mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
                $opt = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                );
                $pdo = new PDO($dsn,$db_username,$db_password,$opt);

                $stmt = $pdo->prepare("SELECT username FROM users WHERE password=?");
                $stmt->execute([$_SESSION["pass"]]);
                $data = $stmt->fetch();

        if ($_SESSION['loggedin'] == true) {
            echo '
            <div class="nav-item">
            <div class="left-menu-header" style="margin-left:500px">
                <span>
                    <a class="nav-link active" href="#" aria-current="page">';
                    echo'<span class="material-symbols-outlined"> person </span>
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
                    ';
                    echo $data['username'];
                    echo '</a>
                </span>
                <div class="dropdown-list">
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
            </div>
            ';
        }
    ?>
</ul>
