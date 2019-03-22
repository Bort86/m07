<div id="content">
    <fieldset>
        <legend>Users list</legend>    
        <?php
            if (isset($content)) {
                echo <<<EOT
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Age</th>
                            <th>Role</th>
                            <th>Active</th>
                        </tr>
EOT;
                foreach ($content as $usuari) {
                    echo <<<EOT
                        <tr>
                            <td>{$usuari->getUsername()}</td>
                            <td>{$usuari->getAge()}</td>
                            <td>{$usuari->getRole()}</td>
                            <td>{$usuari->getActive()}</td>
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
