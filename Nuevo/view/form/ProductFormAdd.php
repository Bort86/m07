<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>Add product</legend>
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php if (isset($content)) { echo $content->getId(); } ?>" />
            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" value="<?php if (isset($content)) { echo $content->getName(); } ?>" />
            <label>Price *:</label>
            <input type="text" placeholder="Price" name="price" value="<?php if (isset($content)) { echo $content->getPrice(); } ?>" />
            <label>Description :</label>
            <input type="text" placeholder="Description" name="description" value="<?php if (isset($content)) { echo $content->getDescription(); } ?>" />
            <label>Category :</label>
            
            <select name="category">
                <?php
                echo "<option value='' selected ></option>";
                
                 foreach ($categories as $category) {         
                     if (isset($content)) {
                        if ($content->getCategory() == $category->getId()) {
                            echo "<option value=" . $category->getId() ." selected >" . $category->getName() . "</option>";
                        }
                        else {
                            echo "<option value=" . $category->getId() .">" . $category->getName() . "</option>";
                        }
                     }
                     else {
                         echo "<option value=" . $category->getId() .">" . $category->getName() . "</option>";
                     }
                 }
                ?>
            </select>
            
            <label>* Required fields</label>
            <input type="submit" name="action" value="add" />
            <input type="submit" name="reset" value="reset" onClick="form_reset(this.form.id);" />
        </fieldset>
    </form>
</div>