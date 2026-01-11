<?php
$db = new PDO("sqlite:database/jeda.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
