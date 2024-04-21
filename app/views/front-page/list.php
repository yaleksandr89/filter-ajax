<div class="row mb-3">
    <a
        href="https://github.com/yaleksandr89/filter-ajax"
        target="_blank"
        rel="nofollow noopener"
        class="link-underline-warning font-monospace display-6 animate-txt"
    >
        Source code(GitHub)
    </a>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="form-group">
            <label for="categories"><code>Category</code></label>
            <select id="categories" class="form-control outline-customize" name="category">
                <option selected value="all">All category</option>
                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?= $category['category'] ?>"
                        <?php echo checkSelectAttribute(
                        'category',
                        $category['category']
                        ) ?>
                    >
                        <?= $category['category'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="colors"><code>Colors</code></label>
            <select id="colors" class="form-control outline-customize" name="color">
                <option selected value="all">All category</option>
                <?php foreach ($colors as $color): ?>
                    <option
                        value="<?= $color['color'] ?>"
                        <?php echo checkSelectAttribute('color', $color['color']) ?>
                    >
                        <?= $color['color'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="weights"><code>Weight</code></label>
            <select id="weights" class="form-control outline-customize" name="weight">
                <option selected value="all">All weight</option>
                <?php foreach ($weights as $weight): ?>
                    <option
                        value="<?= $weight['weight'] ?>"
                        <?php echo checkSelectAttribute('weight', $weight['weight']) ?>
                    >
                        <?= $weight['weight'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>


<div class="row" data-filters-block>
    <?php include_once(PATH_ROOT . '/app/helper/ajax-filter.php'); ?>
</div>
