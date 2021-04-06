<html>
<head>
<title>Table</title>
</head>
<body>

    <p>Filter by Provider: 

    <?php

        // Create a Filter Button For Each Provider
        // On Click Change Provider Get Value

        foreach ($data['all_providers'] as $provider_name) {
            echo '<a href="?page=1&&search=' . $data['search'] .'&&provider=' . $provider_name . '">' . $provider_name . '</a> ';
        }

    ?>
    </p>

    <!-- Search -->

    <form action="" method="get">
        <label for="search">Find:</label>
        <input type="text" name="search" placeholder="email..">
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="provider" value="<?php echo($data['provider']) ?>">
        <button type="submit">Search</button>
    </form>

    
    <p>
    <?php 

    // Displayed If Emails Are Filtered By Provider

    if ($data['provider'] == '%') {} 
    else {
        echo 'Emails from provider: "' . $data['provider'] . '" ';
        echo '<a href="?provider=%&&search=' . $data['search'] . '">x</a>';
    }

    ?>
    </p>

    <p>
    <?php 

    // Displayed If Emails Are Filtered By a Search Term

    if ($data['search'] == !'') {
        echo 'Emails that contain "' . $data['search'] . '" ';
        echo '<a href="?search=&&provider=' . $data['provider'] . '">x</a>';
    }

    ?>
    </p>

    <!-- Form For Selecting / Deleting / Exporting Emails -->

    <form action="<?php echo (URLROOT . "emails/deleteorexport") ?>" method="POST">
        <table>

            <!-- Table Headers -->

            <tr>
                <th>Select</th>

                <th><a href="?order=email <?php echo('&&search=' . $data['search'] . '&&provider=' . $data['provider']) ?>">Email Address</a>
                <a href="?order=email&&page=1&&sort=<?php echo(!$data['sort'] . '&&search=' . $data['search'] . '&&provider=' . $data['provider']) ?>">⇅</a></th>
                
                <th><a href="?order=date<?php echo('&&search=' . $data['search'] . '&&provider=' . $data['provider']) ?>">Date</a>
                <a href="?order=date&&page=1&&sort=<?php echo !$data['sort'] . '&&search=' . $data['search'] . '&&provider=' . $data['provider'] ?>">⇅</a></th>
            </tr>

            <!-- Emails -->

            <?php
                foreach ($data['emails'] as $email) {
                    echo('
                        <tr>
                            <td>
                                <input type="checkbox" name="select[]" value="' . $email->id . '">
                            </td>
                            <td> 
                                ' . $email->email . '
                            </td>
                            <td> 
                                ' . $email->date . '
                            </td>
                        </tr>
                    ');
                }
            ?>

            <!-- How Many Results Found -->

            <?php echo $data['result_count'] . " Results Found"; ?>
            
        </table>
        </br>

        <!-- Export / Delete Buttons -->
        

        <input type="submit" name="delete" value="Delete Selection">
        <input type="submit" name="export" value="Export Selection">

        </br>
        </br>
        
        Choose Page: 

        <?php

        // Pagination Buttons

        for ($i = 1; $i <= $data['total_pages']; $i++) {
            echo '<a href="?page=' . $i . '&&search=' . $data['search'] . '&&provider=' . $data['provider'] . '&&sort=' . $data['sort'] . '&&order=' . $data['order'] . '">' . $i . '</a> ' ;
        }

        ?>

        <!-- Current Page / Total Pages -->

        <p>Displaying Page: <?php echo $data['page'] ?> Out Of <?php echo $data['total_pages'] ?> Pages</p>
    </form>
</body>
</html>