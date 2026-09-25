<?php
// 1. Tạo hàm isPrime nhận một số nguyên dương và trả về true/false
function isPrime($n) {
    // Các số nhỏ hơn 2 không phải là số nguyên tố
    if ($n < 2) {
        return false;
    }
    
    // Kiểm tra xem $n có chia hết cho số nào từ 2 đến $n - 1 hay không
    for ($i = 2; $i < $n; $i++) {
        if ($n % $i == 0) {
            return false; // Chia hết thì không phải số nguyên tố
        }
    }
    
    return true; // Không chia hết cho số nào thì là số nguyên tố
}
//Thử với sô 12
$number = 12;

if (isPrime($number)) {
    echo "$number là số nguyên tố.";
} else {
    echo "$number không phải là số nguyên tố.";
}
echo '<br><br>';
// 2. Sử dụng hàm để hiển thị danh sách các số nguyên tố từ 1 đến 100
echo "Danh sách các số nguyên tố từ 1 đến 100 là:<br>";

for ($number = 1; $number <= 100; $number++) {
    // Gọi hàm isPrime để kiểm tra điều kiện
    if (isPrime($number)) {
        echo $number . " ";
    }
}
?>