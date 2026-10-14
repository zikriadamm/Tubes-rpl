param([int]$WebPort = 8000, [int]$MysqlPort = 3317)

$ErrorActionPreference = 'Stop'
$project = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
$php = 'C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe'
$mysqlBin = 'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin'
$mysqld = Join-Path $mysqlBin 'mysqld.exe'
$mysql = Join-Path $mysqlBin 'mysql.exe'
$data = Join-Path $project 'runtime\mysql-data'
foreach ($file in @($php, $mysqld, $mysql)) {
    if (-not (Test-Path -LiteralPath $file)) { throw "Tidak ditemukan: $file. Sesuaikan path Laragon di scripts/start-demo.ps1." }
}
if ($MysqlPort -ne 3317) { throw 'Demo ini memakai DB_PORT=3317 pada .env. Ubah .env dan skrip bila ingin port lain.' }
if (-not (Test-Path -LiteralPath (Join-Path $data 'auto.cnf'))) {
    New-Item -ItemType Directory -Force -Path $data | Out-Null
    & $mysqld --initialize-insecure "--basedir=$($mysqlBin | Split-Path -Parent)" "--datadir=$data"
    if ($LASTEXITCODE -ne 0) { throw 'Inisialisasi MySQL gagal.' }
}
$listener = Get-NetTCPConnection -State Listen -LocalPort $MysqlPort -ErrorAction SilentlyContinue
if (-not $listener) {
    $args = @('--no-defaults', "--basedir=$($mysqlBin | Split-Path -Parent)", "--datadir=`"$data`"", "--port=$MysqlPort", '--bind-address=127.0.0.1')
    Start-Process -FilePath $mysqld -ArgumentList $args -WindowStyle Hidden | Out-Null
    for ($i = 0; $i -lt 20; $i++) {
        Start-Sleep -Milliseconds 500
        if (Get-NetTCPConnection -State Listen -LocalPort $MysqlPort -ErrorAction SilentlyContinue) { break }
    }
}
if (-not (Get-NetTCPConnection -State Listen -LocalPort $MysqlPort -ErrorAction SilentlyContinue)) { throw 'MySQL demo gagal berjalan.' }
$activeData = (& $mysql -N -B --raw -h 127.0.0.1 -P $MysqlPort -u root -e 'SELECT @@datadir;' 2>$null)
if ($LASTEXITCODE -ne 0 -or $activeData.TrimEnd('\','/') -ine $data.TrimEnd('\','/')) {
    throw "Port MySQL $MysqlPort dipakai oleh instance lain. Hentikan instance itu sebelum menjalankan demo."
}
& $mysql -h 127.0.0.1 -P $MysqlPort -u root -e 'CREATE DATABASE IF NOT EXISTS hotel_nusa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
if ($LASTEXITCODE -ne 0) { throw 'Gagal membuat database hotel_nusa.' }
Push-Location $project
try {
    & $php artisan migrate --seed --force
    if ($LASTEXITCODE -ne 0) { throw 'Migrasi gagal.' }
    if (-not (Test-Path -LiteralPath (Join-Path $project 'public\storage'))) { & $php artisan storage:link }
    if (Get-NetTCPConnection -State Listen -LocalPort $WebPort -ErrorAction SilentlyContinue) { throw "Port web $WebPort sudah dipakai." }
    Start-Process -FilePath $php -ArgumentList @('artisan', 'serve', '--host=127.0.0.1', "--port=$WebPort") -WorkingDirectory $project -WindowStyle Hidden | Out-Null
    Write-Host "Hotel Nusa siap di http://127.0.0.1:$WebPort"
} finally { Pop-Location }
