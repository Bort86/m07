<div id="content">
    <fieldset>
        <legend>Category list</legend>    
        <?php
            if (isset($content)) {
                echo <<<EOT
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                        </tr>
EOT;
                foreach ($content as $category) {
                    echo <<<EOT
                        <tr>
                            <td>{$category->getId()}</td>
                            <td>{$category->getName()}</td>
                        </tr>
EOT;
                }
                echo <<<EOT
                    </table>
EOT;
            }
        ?>
    </fieldset>
</div>
