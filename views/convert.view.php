<link rel="stylesheet" href="/css/css.css">

<div class="container">

    <table>
        <tr>

            <td>word</td>
            <td>number</td>
        </tr>

        <tr>
            <?php

            foreach ($data as $word => $number) {
            ?>

                <td><?=$word?>
                </td>
                <td>
                    <?=$number?>
                </td>


                </tr>
        <?php }
        ?>
    </table>
</div>