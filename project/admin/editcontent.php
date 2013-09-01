<?php
date_default_timezone_set('MST');
session_start();
if (!$_SESSION['loggedin'] || $_SESSION['role'] != 1) {
    header('location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Content | Yellowstone Park</title>
        <!-- Page header -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/head.php' ?>
    </head>
    <body>
        <div class="container">
            <header class="masthead">
                <!-- User Tools -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/usertools.php' ?>
                <!-- Photo Header -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/header.php' ?>
                <!-- Top nav bar -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/topnav.php' ?>
            </header>
            <!-- Main content area -->
            <div class="content">
                <h1 class="text-center">Edit Content</h1>
                <hr>
                <?php
                // If there was a message generated, echo it at the top.
                if (is_array($message)) {
                    echo "<div class='text-center lead'>";
                    echo "<p class='" . $message['class'] . "'>" . $message['message'] . "</p>";
                    echo "</div>";
                }
                ?>
                <div class="row-fluid">
                    <div class="span3"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/modules/adminsidebar.php' ?></div>
                    <div class="span9">
                        <form method="post" action="?p=editcontent">
                            <select name="cid" onchange="this.form.submit()">
                                <option value="" selected></option>
                                <?php
                                foreach ($contententries as $entry) {
                                    echo '<option value="' . $entry['id'] . '">' . $entry['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </form>
                        <form class="form-horizontal" method="post" action=".">
                            <fieldset>
                                <legend>Content Details</legend>
                                <div class="control-group">
                                    <label class="control-label" for="title">Title</label>
                                    <div class="controls">
                                        <input type="text" name="title" <?php
                                        if (isset($contentinfo['content_name'])) {
                                            echo 'value="' . $contentinfo['content_name'] . '"';
                                        }
                                        ?> required>
                                               <?php
                                               if (isset($errors[0])) {
                                                   echo "<br><span class='text-center text-error'>";
                                                   echo $errors[0];
                                                   echo "</span>";
                                               }
                                               ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="category">Category</label>
                                    <div class="controls">
                                        <select name="category">
                                            <option>-- Choose One --</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                echo '<option value="' . $category['id'] . '"';
                                                if (isset($contentinfo['content_category']) && $contentinfo['content_category'] == $category['id']) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $category['category_title'];
                                                echo '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="season">Season (optional)</label>
                                    <div class="controls">
                                        <input type="text" name="season" <?php
                                        if (isset($contentinfo['content_season'])) {
                                            echo 'value="' . $contentinfo['content_season'] . '"';
                                        }
                                        ?>>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="location">Location (optional)</label>
                                    <div class="controls">
                                        <input type="text" name="location" <?php
                                        if (isset($contentinfo['content_location'])) {
                                            echo 'value="' . $contentinfo['content_location'] . '"';
                                        }
                                        ?>>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Page Content</legend>
                                <div class="controls">
                                    <?php
                                    if (isset($errors[1])) {
                                        echo "<br><span class='text-center text-error'>";
                                        echo $errors[1];
                                        echo "</span>";
                                    }
                                    ?>
                                    <p>Be sure to include any HTML tags you want included (paragraph tags, italics, etc.)</p>
                                    <textarea name="description" cols="100" rows="15" required><?php
                                        if (isset($contentinfo['content_description'])) {
                                            echo $contentinfo['content_description'];
                                        }
                                        ?></textarea>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Rules (optional)</legend>
                                <div class="controls">
                                    <p>Be sure to include any HTML tags you want included (paragraph tags, italics, etc.)</p>
                                    <textarea name="rules" cols="100" rows="5"><?php
                                        if (isset($contentinfo['content_rules'])) {
                                            echo $contentinfo['content_rules'];
                                        }
                                        ?></textarea>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Submit</legend>
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Update Content</button>
                                </div>
                                <input type="hidden" name="cid" <?php
                                if (isset($contentinfo['content_id'])) {
                                    echo 'value="' . $contentinfo['content_id'] . '"';
                                }
                                ?>>
                                <input type="hidden" name="action" value="editing">
                                <input type="hidden" name="p" value="editcontent">
                            </fieldset>
                        </form>
                        <fieldset>
                            <legend>Delete This Page</legend>
                            <form class="form-horizontal" method="post" action="." onsubmit="return confirm('Are you sure you want to delete this content entry? This cannot be undone!')">
                                <input type="hidden" name="cid" value="<?php echo $contentinfo['content_id'] ?>">
                                <input type="hidden" name="p" value="editcontent">
                                <input type="hidden" name="action" value="deleting">
                                <div class="controls">
                                    <button type="submit" class="btn btn-danger">Delete This Entry</button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class='footer'>
                <!-- Footer nav bar -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/footernav.php' ?>
                <!-- Copyright and last updated statement -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/copyright.php' ?>
            </footer>
        </div>
    </body>
</html>