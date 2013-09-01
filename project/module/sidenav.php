<ul class="nav nav-list bs-docs-sidenav">
    <li><a href="/">Home</a></li>
    <?php
        foreach ($contentlist as $contentitem) {
            echo '<li>';
        echo '<a href="/?cid='.$contentitem['content_id'].'">'.$contentitem['content_name'].'</a>';
            echo '</li>';
        }
    ?>
</ul>