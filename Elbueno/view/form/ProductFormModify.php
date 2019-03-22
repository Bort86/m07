<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>Modify and Delete Product</legend>
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" 
                   value="<?php
                   if (isset($content)) {
                       echo $content->getId();
                   }
                   ?>" />
            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" 
                   value="<?php
                   if (isset($content)) {
                       echo $content->getName();
                   }
                   ?>" />

            <label>Price *:</label>
            <input type="text" placeholder="Price" name="price" value="<?php
            if (isset($content)) {
                echo $content->getPrice();
            }
            ?>" />
            <label>Description:</label>
            <input type="text" placeholder="Description" name="description" value="<?php
            if (isset($content)) {
                echo $content->getDescription();
            }
            ?>" />
            <label>Category</label>
            <select name="category">
                <option value="">-</option>
                <?php
                foreach ($categories as $category) {
                    if (isset($content)) {
                        $selected = "";
                        if ($category->getId() == $content->getCategory()) {

                            $selected = "selected";
                        }
                        echo "<option value=" . $category->getId() . " selected>" . $category->getName() . "</option>";
                    } else {
                        echo "<option value=" . $category->getId() . ">" . $category->getName() . "</option>";
                    }
                }
                ?>
            </select>

            <label>* Required fields</label>
            <input type="submit" name="action" value="search" />
            <input type="submit" name="action" value="modify" />
            <button name="action" value="delete" onclick="form_delete(this.form.id);">delete</button>
            <input type="reset" name="reset" value="reset" />
        </fieldset>
    </form>
</div>