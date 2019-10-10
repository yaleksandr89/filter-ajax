<?php if ($infoBlock === null) : ?>
    <div class="alert alert-warning fade" role="alert">
        <button type="button" class="close closeLoginWarn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span><?= $infoBlock ?></span>
    </div>
<?php else: ?>
    <div class="alert alert-warning show pl-2 pr-2" role="alert">
        <button type="button" class="close closeLoginWarn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span><?= $infoBlock ?></span>
    </div>
<?php endif; ?>