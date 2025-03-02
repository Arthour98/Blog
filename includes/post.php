<?php
if ($Posts): ?>
    <?php foreach ($Posts as $Post): ?><!--entolh gia na apofuge bug ean den uparxei estw kai ena Post -->
        <!-- Arxh gia kathe Post pou uparxei -->
        <div class="blog-content d-flex flex-column row-gap-50 my-5" id="blog-content"
            data-categorized="<?php echo $Post["category_name"]; ?>">
            <div class=" relative blog-box shadow-primary rounded-5 p-4 shadow-lg">
                <?php if (isset($user["user_id"]) && $Post["user_id"] === $user["user_id"]): ?>
                    <div class="settings absolute d-flex flex-column">
                        <i class="fa-solid fa-caret-down post-settings"></i>
                        <form action="index.php" method="POST" class="settings-menu d-none">
                            <input type="hidden" name="post_id" value="<?php echo $Post["content_id"]; ?>">
                            <input type="submit" class="edit btn btn-info rounded-3" value="EDIT" name="EDIT-POST">
                            <input type="submit" class="btn btn-danger rounder-3" value="DELETE" name="DELETE-POST">
                        </form>
                    </div>
                <?php else : echo ""; ?><!--Na dei3ei keno ean den einai sundedemenos o xrhsths kai den einai diko tou to post -->

                <?php endif; ?>
                <div class=" row d-flex align-items-center bg-dark text-warning p-3 rounded-4">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12  ">
                        <i class="fa-solid fa-user  border border-3 border-success  p-3 rounded-5
                    " data-bs-toggle="tooltip" data-bs-placemenent="bottom" title="<?php echo $Post["user_name"]; ?>"></i>
                        <p class="fs-4 text-uppercase">Posted By : <?php echo $Post["user_name"]; ?></p>
                        <p><?php echo $Post["publish_date"]; ?>
                    </div>
                    <div class="col-xxl-9 d-flex col-xl-9 col-lg-9 col-md-12 col-sm-12 justify-content-between ">
                        <h3 class="title text-decoration-underline fs-1 cursor-pointer">Title: <?php echo $Post["title"]; ?></h3>
                        <button class="btn sm-btn btn-primary rounded-4 cursor-pointer"><?php echo $Post["category_name"]; ?></button>
                    </div>

                </div>
                <div class="p-4">
                    <!-- edw einai to container tou periexomenou tou post -->
                    <?php if (isset($user["user_id"]) && $Post["user_id"] === $user["user_id"]): ?>
                        <div class="content-container col-12 p-4"
                            data-user-id="<?php echo $Post["user_id"]; ?>">
                            <form class="EDIT_FORM flex-100 d-none d-flex flex-column row-gap-20 " action="blog-exec/edit.php" method="post">
                                <textarea class="EDIT_TEXT flex-100" name="edited-content"><?php echo $Post["content"]; ?></textarea>
                                <input type="hidden" class="EDIT_ID" name="post-id" value="<?php echo $Post['content_id']; ?>">
                                <input type="submit" class="EDIT_SUBMIT btn btn-success rounded-4" value="EDIT" name="EDIT_SUBMIT">
                            </form>
                            <!--Edw einai to periexomeno tou Post -->
                            <p class="content-text text-break fs-3 font-weight-bold text-dark"
                                data-content="<?php echo $Post["content_id"]; ?>"
                                data-user-id="<?php echo $Post["user_id"]; ?>">
                                <?php echo $Post["content"]; ?>
                            </p>
                            <!--edw telionei to periexomeno tou Post -->
                        </div>
                    <?php else : ?>
                        <div class="content-container col-12 p-4">
                            <p class="content-text text-break fs-3 font-weight-bold text-dark">
                                <?php echo $Post["content"]; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- likes section if there is any session -->
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <div class="row gap-5">
                            <div class="col-xxl-1 col-xl-2 col-lg-6 col-md-11 col-sm-12 gap-4 fs-4 d-flex">
                                <div class="d-flex">
                                    <form action="index.php" method="POST">
                                        <input type="hidden" name="content_id" value="<?php echo $Post["content_id"]; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user["user_id"]; ?>">
                                        <input type="hidden" name="status" value="like">
                                        <button type="submit" name="submit_like" class="like">
                                            <i class=" fa-solid fa-thumbs-up"></i>
                                        </button>
                                    </form>
                                    <?php foreach ($status_count as $status): ?>
                                        <?php if (isset($status["content_id"]) && $Post["content_id"] === $status["content_id"]): ?>
                                            <p><?php echo $status["likes"] ? $status['likes'] : '0'; ?></p>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex">
                                    <form action="index.php" method="POST">
                                        <input type="hidden" name="content_id" value="<?php echo $Post["content_id"]; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user["user_id"]; ?>">
                                        <input type="hidden" name="status" value="dislike">
                                        <button type="submit" name="submit_dislike" class="dislike">
                                            <i class="fa-regular fa-thumbs-down"></i>
                                        </button>
                                    </form>
                                    <?php foreach ($status_count as $status): ?>
                                        <?php if (isset($status["content_id"]) && $Post["content_id"] === $status["content_id"]): ?>
                                            <p><?php echo $status["dislikes"] ? $status["dislikes"] : '0'; ?></p>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- end likes section -->

                            <!-- comment-section if there is a session -->
                            <div class=" col-xxl-10 col-xl-9 col-lg-12 col-md-12 col-sm-12  d-flex justify-content-end align-items-center gap-20 ">
                                <form id="comment-form" method="POST" action="index.php" class="flex-100">
                                    <label>Comment:</label>
                                    <div class="d-flex flex-column gap-4 align-items-end flex-100">
                                        <textarea class="form-control flex-100 shadow-lg " name="comment_text"></textarea>
                                        <input type="hidden" name="blog_id" value="<?php echo $Post["content_id"]; ?>">
                                        <input type="submit" name="POST-COMMENT" value="POST" class="btn  btn-primary  btn-success rounded-4 btn-lg">
                                    </div>
                                </form>
                                <p class="comments text-decoration-underline fs-3">Comments:
                                    <?php foreach ($comment_count as $count): ?>
                                        <?php if ($Post["content_id"] === $count["content_id"] || $count["comment_count"] === null) : ?>
                                            <?php echo " " . $count["comment_count"]; ?>
                                        <?php else: continue; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!--end of comment section -->

                    <!-- comments-view section -->

                    <div class="row mt-2 p-1 d-none gap-30" id="comment-row">
                        <?php foreach ($comments as $comment): ?>
                            <?php if ($comment["content_id"] === $Post["content_id"]): ?>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex align-items-stretch gap-20 ">
                                    <i class="fa-solid fa-user  border border-3 border-primary text-dark  p-3 rounded-5
                        " data-bs-toggle="tooltip" data-bs-placemenent="bottom" title="<?php echo $comment["user_name"]; ?>"></i>
                                    <p class="fs-3 text-decoration-underline text-capitalize d-flex cursor-pointer"><?php echo "#" . $comment["user_name"] . ":"; ?></p>
                                    <p class="fs-3"><?php echo $comment["posting_date"]; ?></p>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12  d-flex align-items-center gap-5 ms-5 ">
                                    <p class="fs-4 text-danger text-break "><?php echo $comment["comment_text"] ?></p>
                                    <!-- edw diagrafafei o user mono ta dika tou sxolia -->
                                    <?php if ($user["user_id"] === $comment["user_id"]): ?>
                                        <form action="index.php" method="POST">
                                            <input type="hidden" name="comment_id" value="<?php echo $comment["comment_id"]; ?>">
                                            <input type="submit" class="btn btn-danger" name="REMOVE-COMMENT" value="DELETE">
                                        </form>
                                        <!---->
                                    <?php endif; ?>
                                </div>
                                <hr class="w-100">
                            <?php else : {
                                    continue;
                                }; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- end comments-view section-->


                </div>
            </div>
        </div>
        <!-- telos gia kathe Post pou uparxei -->
    <?php endforeach; ?>
<?php endif; ?>
<!---->