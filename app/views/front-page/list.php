<div class="select">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="categories">Filter category</label>
            <select id="categories" class="form-control" name="categories">
                <option value="all">All category</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category'] ?>>"><?= $category['category'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="colors">Filter colors</label>
            <select id="colors" class="form-control" name="colors">
                <option value="all">All category</option>
                <?php foreach ($colors as $color): ?>
                    <option value="<?= $color['color'] ?>>"><?= $color['color'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="weights">Filter weight</label>
            <select id="weights" class="form-control" name="weights">
                <option value="all">All weight</option>
                <?php foreach ($weights as $weight): ?>
                    <option value="<?= $weight['weight'] ?>>"><?= $weight['weight'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-3">
            <div class="card mt-5">
                <h5 class="card-title text-center mt-2">
                    <?= $product['category'] ?>
                    <?= $product['title'] ?>
                </h5>
                <div class="card-body">
                    <ul>
                        <li><strong>Цвет</strong>: <?= $product['color'] ?></li>
                        <li><strong>Вес</strong>: <?= $product['weight'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>