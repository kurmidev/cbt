<?= $this->render('@app/views/layouts/_header') ?>
<div class="card pd-10">
    <div class="wizard">
        <div class="steps">
            <ul role="tablist">
                <?php foreach ($tab_list as $key => $value) { ?>
                    <li role="tab" aria-disabled="false" aria-selected="false" class="first <?php echo ($current_tab == $key) ? 'current' : ''; ?> <?php echo ($key > $current_tab) ? 'done' : ''; ?>">
                        <a href="#vtab<?= $key ?>" data-toggle="tab" style="display:flex">
                            <span class="number"><?= $key ?></span>
                            <span class="title"><?= $value ?></span>
                        </a>
                    </li>
                <?php } ?> 
            </ul>
            <div class="panel-body">
                <?php echo $this->render($view, $view_data, true); ?>
            </div>
        </div>
    </div>
</div>