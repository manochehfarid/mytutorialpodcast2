<?php

/*
 * captures values from a form and prints them
 */
if ($_POST){
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
}
?>
<form action="" method="post">
    Name: <input type="text" name="personal[name]"/>
    <br/>
    Email: <input type="text" name="personal[email]"/>
    <br/>
    Root Beer: <br/>
    <select multiple name="root_beer[]">
        <option value="Barq's">Barq's</option>
        <option value="A&W">A&W</option>
        <option value="IBC">IBC</option>
    </select><br/>
    <input type="submit" value="send me!"/>
</form>
