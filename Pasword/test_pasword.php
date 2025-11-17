<?php
$plain = "NAMZde98";
$hash  = "$2y$10$z0CzPU/mKke/X5qQh0sHvOihU99am6bt53AHO0NHkKZuw8n0cEZPK"; // copy same kama DB

if (password_verify($plain, $hash)) {
    echo "✅ Password is correct";
} else {
    echo "❌ Wrong password";
}
?>
