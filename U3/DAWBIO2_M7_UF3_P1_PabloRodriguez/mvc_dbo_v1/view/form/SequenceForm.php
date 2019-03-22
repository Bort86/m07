<!-- debug -->
<p><?php var_dump($_FILES); ?></p>

<form method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Sequence upload</legend>    

        <label>Sequence:</label>
        <input type="file" name="seq_up"/>

        <input type="submit" name="action" value="upload"/>
    </fieldset>
    <fieldset>
        <legend>Sequence download</legend>
        
        <?php
            if (isset($content)) {
                foreach ($content as $file) {
                    echo "<input type='radio' name='seq_down' value='$file'/>";
                    echo "<a href='index.php?menu=sequence&seq=$file'>$file</a><br/>";
                }
            }
        ?>
        
        <input type="submit" name="action" value="download"/>
    </fieldset>
    <fieldset>
        <legend>Sequence view</legend>
        
        <textarea rows="5" cols="100" name="sequence"><?php if (isset($file_data)) { echo $file_data; } ?></textarea>
    </fieldset>
</form>