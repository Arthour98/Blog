<div class="creation-post d-flex justify-content-center align-items-center py-2 mt-3" id="creation-post">
    <form id="post-blog" action="index.php" method="POST">
        <div class="d-flex align-items-center gap-20">
            <i class="fa-solid fa-user  border border-3 border-success  p-3 rounded-5
                    " data-bs-toggle="tooltip" data-bs-placemenent="bottom" title="Artour"></i>
            <select name="category" class="form-select bg-secondary text-light">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category["category_id"]; ?>">
                        <?php echo $category["category_name"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <label>Title:</label>
        <input type="text" name="title" class="form-control bg-secondary text-light">
        <textarea name="post" class="form-control"></textarea>
        <div class="col-12 d-flex justify-content-end">
            <input type="submit" value="POST" name="POST-BLOG" class="btn btn-info rounded-pill w-25">
        </div>
    </form>
</div>