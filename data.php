<?php 
// 1. الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) { 
    die("خطأ في الاتصال"); 
}

// --- حالة إنشاء حساب جديد (مع التحقق من التكرار) ---
if (isset($_GET['signup'])) {
    $username = $_GET["username"]; 
    $useremail = $_GET["useremail"];
    $password = $_GET["password"];

    // الخطوة الذكية: البحث عن مستخدم بنفس الاسم أو الإيميل
    $checkUser = "SELECT * FROM users WHERE username='$username' OR useremail='$useremail'";
    $resultCheck = $conn->query($checkUser);

    if ($resultCheck->num_rows > 0) {
        // إذا وجدنا الشخص موجود، نعطيه رسالة تنبيه صفراء
        echo "
        <div style='background-color: #fff3cd; color: #856404; padding: 30px; border-radius: 15px; text-align: center; font-family: \"Noto Kufi Arabic\", sans-serif; margin: 100px auto; max-width: 400px; border: 1px solid #ffeeba;'>
            <h2 style='margin-bottom: 10px;'>⚠️ تنبيه!</h2>
            <p>اسم المستخدم أو البريد الإلكتروني مسجل مسبقاً.</p>
            <br>
            <a href='register.html' style='text-decoration: none; color: white; background: #856404; padding: 10px 20px; border-radius: 8px;'>العودة للتسجيل</a>
        </div>";
    } else {
        // إذا كان المستخدم جديد، نقوم بعملية الإضافة فوراً
        $add = "INSERT INTO users (username, useremail, password) VALUES ('$username', '$useremail', '$password')";

        if ($conn->query($add) === TRUE) {
            echo "
            <div style='background-color: #e8f5e9; color: #2e7d32; padding: 30px; border-radius: 15px; text-align: center; font-family: \"Noto Kufi Arabic\", sans-serif; margin: 100px auto; max-width: 400px; border: 1px solid #c8e6c9;'>
                <h2 style='margin-bottom: 10px;'>🌱 مبروك!</h2>
                <p>تم إنشاء حسابك في \"خلاب\" بنجاح.</p>
                <p style='font-size: 0.8em; color: #666;'>سيتم تحويلك الآن لتسجيل الدخول...</p>
            </div>
            <script>
                setTimeout(function(){ window.location.href = 'login.html'; }, 3000);
            </script>";
        }
    }
}

// --- حالة تسجيل الدخول ---
if (isset($_GET['login'])) {
    $username = $_GET["username"];
    $password = $_GET["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: acc.html");
        exit();
    } else {
        echo "
        <div style='background-color: #ffebee; color: #c62828; padding: 30px; border-radius: 15px; text-align: center; font-family: \"Noto Kufi Arabic\", sans-serif; margin: 100px auto; max-width: 400px; border: 1px solid #ffcdd2;'>
            <h2 style='margin-bottom: 10px;'>⚠️ عذراً!</h2>
            <p>اسم المستخدم أو كلمة المرور غير صحيحة.</p>
            <br>
            <a href='login.html' style='text-decoration: none; color: white; background: #c62828; padding: 10px 20px; border-radius: 8px;'>حاول مرة أخرى</a>
        </div>";
    }
}
$conn->close();
?>