<?php
//Ashley Murad

session_start();

session_destroy();

header("Location: index.html");
exit;