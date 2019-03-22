<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>Search, modify or delete User</legend>
            <label>Username *:</label>
            <input type="text" placeholder="Username" name="username" value="<?php
            if (isset($content)) {
                echo $content->getUsername();
            }
            ?>" />
            <label>Password *:</label>
            <input type="password" placeholder="Password" name="password" value="<?php
            if (isset($content)) {
                echo $content->getPassword();
            }
            ?>" />
            <label>Age: </label>
            <input type="text" placeholder="Age" name="age" value="<?php
            if (isset($content)) {
                echo $content->getAge();
            }
            ?>" />
            <label>Role *:</label>
            <select name="role">
                <option value="">-</option>
                <?php
                if (isset($content)) {
                    echo "<option value=" . $content->getRole() . " selected>" . $content->getRole() . "</option>";
                }
                echo "<option value='Basic'>Basic </option>";
                echo "<option value='Advanced'>Advanced </option>";
                ?>
            </select>
            <label>Active *:</label>   
            <?php
            $checked_yes = "";
            $checked_no = "";

            if (isset($content)) {
                if ($content->getActive() == 1) {
                    $checked_yes = "checked";
                } else {
                    $checked_no = "checked";
                }
            }
            ?>
            <input type="radio" name="active" value="1" <?php echo $checked_yes; ?>/>1          
            <input type="radio" name="active" value="0" <?php echo $checked_no; ?> />0

            <label>* Required fields</label>
            <input type="submit" name="action" value="search" />
            <input type="submit" name="action" value="modify" />
            <input type="reset" name="reset" value="reset" />
        </fieldset>
    </form>
</div>