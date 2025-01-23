<?php

require_once realpath(dirname(__DIR__) . '/app/App.php');

// Base path: Menggunakan realpath untuk memastikan path absolut yang benar
define('BASE_PATH', realpath(dirname(__DIR__) . '/app'));

session_start();
$app = new App();
?>

<script>
    const ws = new WebSocket("ws://localhost:3000");

    ws.onmessage = (event) => {
        if (event.data === "reload") {
            console.log("Reloading page...");
            window.location.reload();
        }
    };

    ws.onclose = () => {
        console.warn("WebSocket connection closed");
    };
</script>