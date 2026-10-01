<?php

$file = "messages.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name !== "" && $message !== "") {

        $name = htmlspecialchars($name);
        $message = htmlspecialchars($message);

        $time = date("H:i");

        $line = "$time|$name|$message" . PHP_EOL;

        file_put_contents($file, $line, FILE_APPEND);
    }

    header("Location: index.php");
    exit;
}

$messages = [];

if (file_exists($file)) {
    $messages = file($file, FILE_IGNORE_NEW_LINES);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mini Messenger</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="messenger">

    <header>

        <div>
            <h1>💬 Mini Messenger</h1>
            <span>Simple PHP chat</span>
        </div>

        <div class="online">
            ● Online
        </div>

    </header>


    <main class="chat">

        <?php if (empty($messages)): ?>

            <div class="empty">
                Пока сообщений нет 👋
            </div>

        <?php else: ?>

            <?php foreach ($messages as $line): ?>

                <?php

                $parts = explode("|", $line, 3);

                if (count($parts) === 3):

                    [$time, $name, $message] = $parts;

                ?>

                    <div class="message">

                        <div class="avatar">
                            <?= strtoupper(substr($name, 0, 1)) ?>
                        </div>

                        <div class="bubble">

                            <div class="message-top">

                                <strong>
                                    <?= $name ?>
                                </strong>

                                <small>
                                    <?= $time ?>
                                </small>

                            </div>

                            <p>
                                <?= $message ?>
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>


    <form method="POST" class="form">

        <input
            type="text"
            name="name"
            placeholder="Ваше имя"
            maxlength="30"
            required
        >

        <input
            type="text"
            name="message"
            placeholder="Напишите сообщение..."
            maxlength="300"
            required
        >

        <button type="submit">
            ➤
        </button>

    </form>

</div>

</body>

</html>
