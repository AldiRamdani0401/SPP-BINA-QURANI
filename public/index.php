<?php

require_once realpath(dirname(__DIR__) . '/app/App.php');

// Base path: Menggunakan realpath untuk memastikan path absolut yang benar
define('BASE_PATH', realpath(dirname(__DIR__) . '/app'));

session_start();
$app = new App();
?>

<script>
    const ws = new WebSocket("ws://localhost:3000");

    ws.onopen = () => {
        console.log("WebSocket connection established");
    };

    ws.onmessage = (event) => {
        try {
            const data = JSON.parse(event.data);

            if (data.action === "reload") {
                console.log(`Reloading page due to changes in: ${data.file}`);
                window.location.reload();
            }
        } catch (error) {
            console.error("Error parsing WebSocket message:", error);
        }
    };

    ws.onerror = (error) => {
        console.error("WebSocket error:", error);
    };

    ws.onclose = () => {
        console.warn("WebSocket connection closed");
    };
</script>
