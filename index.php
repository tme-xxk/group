<?php
$uploadDir = "uploads/";

function generateCode($length = 6) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
}

$url = "";
$error = "";

if(isset($_POST['submit'])) {
    $file = $_FILES['htmlfile'];
    $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if($fileType != "html") {
        $error = "❌ Only HTML files allowed!";
    } else {
        $code = generateCode();
        $newName = $code . ".html";
        $targetFile = $uploadDir . $newName;

        if(move_uploaded_file($file["tmp_name"], $targetFile)) {
            $url = "https://" . $_SERVER['HTTP_HOST'] . "/" . $code;
        } else {
            $error = "❌ Upload Failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>HTML Host</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-align: center;
    padding: 50px;
}

.box {
    background: white;
    color: black;
    padding: 30px;
    border-radius: 15px;
    width: 320px;
    margin: auto;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

input[type="file"] {
    margin: 10px 0;
}

button {
    background: #667eea;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background: #5a67d8;
}

.copy-btn {
    background: green;
}

/* Toast Popup */
#toast {
    visibility: hidden;
    min-width: 200px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 8px;
    padding: 10px;
    position: fixed;
    left: 50%;
    bottom: 30px;
    transform: translateX(-50%);
}

#toast.show {
    visibility: visible;
    animation: fadein 0.3s, fadeout 0.3s 0.7s;
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}
</style>

</head>

<body>

<div class="box">
    <h2>🚀 HTML Upload</h2>

    <?php if($url != "") { ?>
        <p>✅ Your Link:</p>

        <input type="text" value="<?php echo $url; ?>" id="linkBox" readonly style="width:100%;padding:8px;"><br>

        <button class="copy-btn" onclick="copyLink()">📋 Copy Link</button>
        <button onclick="resetPage()">🔄 Upload Another</button>

    <?php } else { ?>

        <?php if($error != "") echo "<p style='color:red;'>$error</p>"; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="file" name="htmlfile" required><br>
            <button type="submit" name="submit">Upload</button>
        </form>

    <?php } ?>
</div>

<!-- Toast Popup -->
<div id="toast">✅ Copied!</div>

<script>
function copyLink() {
    var copyText = document.getElementById("linkBox");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");

    var toast = document.getElementById("toast");
    toast.className = "show";

    setTimeout(function() {
        toast.className = toast.className.replace("show", "");
    }, 1000);
}

function resetPage() {
    window.location.href = window.location.pathname;
}
</script>

</body>
</html>