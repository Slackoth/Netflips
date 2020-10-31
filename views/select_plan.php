<div class="card-deck my-2">
<?php use app\core\Application;

for($i = 0; $i < 3; $i++): ?>
        <div class="card mb-3" style="max-width: 18rem;" id="card_<?=$i + 1?>">
            <div class="card-header">
                <h5>Plan <?= $i + 1 ?></h4>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $plans[0]["name"]; ?></h5>
                <p class="card-text"><?= $plans[0]["description"]; ?></p>
                <p class="card-text">Precio: <?= "$" . $costs[$i]; ?></p>
                <small class="text-muted" id="<?= $i + 1 ?>"><?= ucfirst($types[$i]["name"]); ?></small>
            </div>
        </div>
    <?php endfor; ?>
</div>

<div class="float-right my-2">
    <a href="/register" class="btn btn-primary" id="next_btn">Siguiente</a>
</div>
<script src="assets/js/select_plan.js"></script> 