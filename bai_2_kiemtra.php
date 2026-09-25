<?php
$servername = "localhost";
$username = "root";
$password = "";

//Kết nối MySQL (chưa chọn Database)
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

//Tạo Cơ sở dữ liệu nếu chưa tồn tại
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS quan_ly_ban_hang";
$conn->query($sqlCreateDB);
$conn->select_db("quan_ly_ban_hang");// Chọn Database vừa tạo

//Tạo Bảng products nếu chưa tồn tại
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sqlCreateTable);

//Thêm dữ liệu mẫu nếu bảng chưa có dữ liệu
$checkData = $conn->query("SELECT COUNT(*) as total FROM products");
$row = $checkData->fetch_assoc();

if ($row['total'] == 0) {
    $sqlInsert = "INSERT INTO products (name, price, quantity) VALUES
        ('Áo sơ mi', 150000.00, 10),
        ('Quần jean', 250000.00, 5),
        ('Giày thể thao', 500000.00, 3)";
    $conn->query($sqlInsert);
}

//Lấy danh sách sản phẩm từ CSDL
$sql = "SELECT name, price, quantity FROM products";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($item = $result->fetch_assoc()) {
        $products[] = $item;
    }
}

//Hàm tính tổng giá trị
function tinhTongGiaTri($danhSachSanPham) {
    $tongTien = 0;
    foreach ($danhSachSanPham as $sp) {
        $tongTien += $sp["price"] * $sp["quantity"];
    }
    return $tongTien;
}

//Hiển thị thông tin
$stt = 1;
foreach ($products as $sp) {
    $thanhTien = $sp["price"] * $sp["quantity"];
    
    echo "<div style='margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #ccc;'>";
    echo "<p><strong>Sản phẩm " . $stt++ . ": " . htmlspecialchars($sp["name"]) . "</strong></p>";
    echo "<ul>";
    echo "<li>Giá bán: " . number_format($sp["price"]) . " VNĐ</li>";
    echo "<li>Số lượng: " . $sp["quantity"] . "</li>";
    echo "<li>Thành tiền: " . number_format($thanhTien) . " VNĐ</li>";
    echo "</ul>";
    echo "</div>";
}

$tongGiaTri = tinhTongGiaTri($products);
echo "<p><strong>Tổng giá trị tất cả sản phẩm: " . number_format($tongGiaTri) . " VNĐ</strong></p>";

$conn->close();
?>