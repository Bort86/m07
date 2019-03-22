<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>Modify category</legend>
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" 
                   value="<?php if (isset($content)) { echo $content->getId(); } ?>" />
            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" 
                   value="<?php if (isset($content)) { echo $content->getName(); } ?>" />

            <label>* Required fields</label>
            <input type="submit" name="action" value="search" />
            <input type="submit" name="action" value="modify" />
            <button name="action" value="delete" onclick="form_delete(this.form.id);">delete</button>
            <input type="reset" name="reset" value="reset" />
        </fieldset>
    </form>
</div>