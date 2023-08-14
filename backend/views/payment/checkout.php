<?php
switch ($d['checkout_type']) {
    case "iframe":
        ?>
        <iframe src="<?php echo $d['form_url'] ?>" id="paymentFrame" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"
                frameborder="0" scrolling="yes" ></iframe>
                <?php
                break;
            case "form":
                ?>
        <center>
            <form method="post" name="redirect" action="<?= $form_url ?>"> 
                <?php foreach ($form_data as $label => $values) {
                    ?>
                    <input type="hidden" name="<?= $label ?>" value="<?= $values ?>">
                <?php } ?>
                <?php if (!empty($_COOKIE['payment'])) { ?>
                    <input type="submit" name="Submit" onclick="document.redirect.submit()">
                <?php } ?>
            </form>
        </center>
        <?php
        $js = 'document.redirect.submit();';
        $this->registerJs($js, yii\web\View::POS_READY);
        break;
    default :

        break;
}