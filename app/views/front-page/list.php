<blockquote>
    <a href="//github.com/yaleksandr89/Programing-task-php-javascript/tree/master/php/filter-ajax" target="_blank" rel="nofollow noopener">Source code(GitHub)</a>
</blockquote>
<div class="select">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="categories">Filter category</label>
            <select id="categories" class="form-control customize-style-dark" name="category">
                <option selected value="all">All category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category'] ?>" <?php echo checkSelectAttribute('category',
                        $category['category']) ?>>
                        <?= $category['category'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="colors">Filter colors</label>
            <select id="colors" class="form-control customize-style-dark" name="color">
                <option selected value="all">All category</option><?php foreach ($colors as $color): ?>
                    <option value="<?= $color['color'] ?>" <?php echo checkSelectAttribute('color', $color['color']) ?>>
                        <?= $color['color'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="weights">Filter weight</label>
            <select id="weights" class="form-control customize-style-dark" name="weight">
                <option selected value="all">All weight</option>
                <?php foreach ($weights as $weight): ?>
                    <option value="<?= $weight['weight'] ?>" <?php echo checkSelectAttribute('weight',
                        $weight['weight']) ?>>
                        <?= $weight['weight'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="row cards_block">
    <?php include_once('app/helper/ajax-filter.php'); ?>
</div>