<?php

?>

<ul class="nav nav-pills nav-justified">
    <li <?= ($page == 1) ? 'class = "active"' : ''?>>
        <a href="index.php?page=1">Catalog</a>
    </li>
    <li <?= ($page == 2) ? 'class = "active"' : ''?>>
        <a href="index.php?page=2">Comments</a>
    </li>
    <li <?= ($page == 3) ? 'class = "active"' : ''?>>
        <a href="index.php?page=3">Registration</a>
    </li>
    <li <?= ($page == 4) ? 'class = "active"' : ''?>>
        <a href="index.php?page=4">Admin Form</a>
    </li>
</ul>
