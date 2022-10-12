<?php

// Requirements
if(file_exists('../../.env')){
    require '../../resources/views/errors/404.blade.php';
    die();
}
$php_version = phpversion();
$php_check = false;
$open_ssl = false;
$pdo = false;
$mbstring = false;
$tokenizer = false;
$json = false;
$curl = false;
$ioncube = false;
$ioncube_version = "Ioncube Kurulu Değil";
if ($php_version >= '7.3' && $php_version <= '8.0') {
    $php_check = true;
} else {
    $error = true;
}
if (extension_loaded('openssl')) {
    $open_ssl = true;
} else {
    $error = true;
}
if (extension_loaded('pdo')) {
    $pdo = true;
} else {
    $error = true;
}
if (extension_loaded('mbstring')) {
    $mbstring = true;
} else {
    $error = true;
}
if (extension_loaded('tokenizer')) {
    $tokenizer = true;
} else {
    $error = true;
}
if (extension_loaded('json')) {
    $json = true;
} else {
    $error = true;
}
if (extension_loaded('curl')) {
    $curl = true;
} else {
    $error = true;
}

if (function_exists('ioncube_loader_version')) {
    $ioncubeVersion = ioncube_loader_version();
    $ioncubeMajorVersion = (int) substr($ioncubeVersion, 0, strpos($ioncubeVersion, '.'));
    $ioncubeMinorVersion = (int) substr($ioncubeVersion, strpos($ioncubeVersion, '.') + 1);
    if ($ioncubeMajorVersion >= 11) {
      $ioncube_version = $ioncubeVersion;
      $ioncube = true;
    } else {
      $ioncube_version = "Ioncube versiyonunuz 11+ olmalıdır";
      $error = true;
    }
} else {
  $error = true;
}
// Permissions
$folders = ['public/uploads', 'storage/app', 'storage/framework', 'storage/logs', 'bootstrap/cache'];
foreach ($folders as $folder) {
    $folders_arr[$folder]['check'] = false;
    $folders_arr[$folder]['perm'] = substr(sprintf('%o', fileperms('../../' . $folder)), -4);
    if ($folders_arr[$folder]['perm'] >= '0755') {
        $folders_arr[$folder]['check'] = true;
    }
}

// POST Process
if ($_POST && isset($_POST['db_test'])) {
    $servername   = $_POST['db_host'];
    $database = $_POST['db_name'];
    $username = $_POST['db_username'];
    $password = $_POST['db_password'];

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    die('connected');
} elseif ($_POST && isset($_POST['completed'])) {

    $servername  = $_POST['db_host'];
    $database = $_POST['db_name'];
    $username = $_POST['db_username'];
    $password = $_POST['db_password'];
    $app_name = $_POST['app_name'];
    $site_url = $_POST['protocol'] . $_POST['site_url'];
    $license_code = $_POST['license_code'];
    $env = file_get_contents('env.txt');
    $app_key = base64_encode(md5(uniqid()));
    if ($env) {
        $env = str_replace('${APP_NAME}', $app_name, $env);
        $env = str_replace('${DB_HOST}', $servername, $env);
        $env = str_replace('${DB_DATABASE}', $database, $env);
        $env = str_replace('${DB_USERNAME}', $username, $env);
        $env = str_replace('${DB_PASSWORD}', $password, $env);
        $env = str_replace('${APP_KEY}', $app_key, $env);
        $env = str_replace('${APP_URL}', $site_url, $env);
        $env = str_replace('${LICENSE_CODE}', $license_code, $env);
        $new_file = '../../.env';
        if (file_exists($new_file)) {
            unlink($new_file);
        }
        touch($new_file);
        if (file_put_contents($new_file, $env, FILE_APPEND)) {
            $dsn = "mysql:host=$servername;dbname=$database";
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $dump = file_get_contents('dump.sql');
                $link = new PDO('mysql:host=' . $servername . ';dbname=' . $database . ';charset=utf8mb4', $username, $password, $options);
                $link->exec($dump);
                die('success');
            } catch (PDOException $e) {
                if (file_exists($new_file)) {
                    unlink($new_file);
                }
                die('Please make sure the database is empty and restart the installation.');
            }
        } else {
            if (file_exists($new_file)) {
                unlink($new_file);
            }
            die('Make sure the installation directory is writable and try again.');
        }
    } else {
        die('Please make sure the script files are fully loaded and try again.');
    }
}
