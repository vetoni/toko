<?php
if (!isset($class)) {
    $class = 'warning';
}
if (isset($text)) {
    echo "<div class=\"alert alert-$class\" role=\"alert\">$text</div>";
}
