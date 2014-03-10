<?php $this->extend('layout'); ?>

        <?php $this->paginationControl($paginator, 'pagination'); ?>

        <section class="list">
            <?php foreach ($records as $record): ?>
                <article class="item panel">
                    <div class="left">
                        <span class="id"><?php echo $record->id; ?></span>
                        <span class="name"><?php echo $record->name; ?></span>
                        <span class="when"><?php echo date('l jS \of F Y h:i:s A', $record->when); ?></span>
                    </div>
                    <div class="right">
                        <?php echo $record->ip; ?> |
                        <?php echo $record->email; ?>
                        <?php if ($record->homepage): ?>| <?php echo $record->homepage; ?> <?php endif; ?>
                    </div>
                    <div class="description"><?php echo $record->description;?></div>
                    <?php if ($record->file): ?>
                        <div class="file"><br>
                            Uploaded file: <a href="<?php echo $record->file; ?>"><?php echo $record->file; ?></a>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>

        <?php $this->paginationControl($paginator, 'pagination'); ?>

        <hr>

        <h2>Добавьте запись</h2>
        <div class="add-record">
            <form enctype="multipart/form-data" action="" method="post">
                <div class="row">
                    <?php echo $form->render(); ?>
                </div>
            </form>
        </div>

