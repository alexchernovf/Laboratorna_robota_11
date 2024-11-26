<!-- Main Content -->

<?php
use yii\widgets\LinkPager;

?>


<div class="container mt-5">
    <div class="row">
        <!-- Blog Posts -->
        <div class="col-md-8">
            <?php
            // Фейковые посты
            $posts = [
                (object)[
                    'id' => 1,
                    'title' => 'How to Start a Blog',
                    'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur viverra eros nec arcu tristique tincidunt.',
                    'image' => 'https://dogsinc.org/wp-content/uploads/2021/08/extraordinary-dog.png',
                    'author' => (object)[
                        'name' => 'John Doe'
                    ],
                    'created_at' => '2024-11-01',
                ],
                (object)[
                    'id' => 2,
                    'title' => 'Understanding Web Development',
                    'short_description' => 'Quisque vel augue at lacus feugiat pretium non ac sapien. Donec cursus purus at metus facilisis fermentum.',
                    'image' => 'https://dogsinc.org/wp-content/uploads/2021/08/extraordinary-dog.png',
                    'author' => (object)[
                        'name' => 'Jane Smith'
                    ],
                    'created_at' => '2024-10-25',
                ],
                (object)[
                    'id' => 3,
                    'title' => 'The Best Coding Practices in 2024',
                    'short_description' => 'Sed euismod, erat non consequat feugiat, orci nulla gravida leo. Nulla facilisi. Phasellus vitae cursus purus.',
                    'image' => 'https://dogsinc.org/wp-content/uploads/2021/08/extraordinary-dog.png',
                    'author' => (object)[
                        'name' => 'Sarah Lee'
                    ],
                    'created_at' => '2024-10-18',
                ]
            ];


            foreach ($posts as $post): ?>
                <div class="card mb-4">
                    <img src="<?= $post->image ?>" class="card-img-top" alt="<?= $post->title ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post->title ?></h5>
                        <p class="card-text"><?= $post->short_description ?></p>
                        <a href="<?= Yii::$app->urlManager->createUrl(['post/view', 'id' => $post->id]) ?>" class="btn btn-primary">Continue Reading</a>
                    </div>
                    <div class="card-footer text-muted">
                        <span>By <?= $post->author->name ?> on <?= Yii::$app->formatter->asDate($post->created_at) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>
                </ul>
            </nav>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="widget">
                <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
                <ul class="list-unstyled">
                    <?php
                    // Фейковые популярные записи
                    $popularPosts = [
                        (object)[
                            'id' => 1,
                            'title' => 'How to Start a Blog',
                            'image' => 'https://via.placeholder.com/50x50',
                            'created_at' => '2024-11-01'
                        ],
                        (object)[
                            'id' => 2,
                            'title' => 'Understanding Web Development',
                            'image' => 'https://via.placeholder.com/50x50',
                            'created_at' => '2024-10-25'
                        ],
                        (object)[
                            'id' => 3,
                            'title' => 'The Best Coding Practices in 2024',
                            'image' => 'https://via.placeholder.com/50x50',
                            'created_at' => '2024-10-18'
                        ]
                    ];

                    foreach ($popularPosts as $post): ?>
                        <li class="d-flex align-items-center mb-3">
                            <img src="<?= $post->image ?>" class="img-thumbnail" alt="<?= $post->title ?>" style="width: 50px; height: 50px;">
                            <div class="ms-3">
                                <a href="#" class="text-uppercase"><?= $post->title ?></a>
                                <small><?= Yii::$app->formatter->asDate($post->created_at) ?></small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="widget">
                <h3 class="widget-title text-uppercase text-center">Categories</h3>
                <ul class="list-unstyled">
                    <?php
                    // Фейковые категории
                    $categories = [
                        (object)[
                            'name' => 'Technology',
                            'post_count' => 5
                        ],
                        (object)[
                            'name' => 'Lifestyle',
                            'post_count' => 3
                        ],
                        (object)[
                            'name' => 'Travel',
                            'post_count' => 4
                        ],
                    ];

                    foreach ($categories as $category): ?>
                        <li><a href="#"><?= $category->name ?> (<?= $category->post_count ?>)</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
