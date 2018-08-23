

<?php $__env->startSection('content'); ?>

<div class="navbar navbar-inverse" id="nav" style="display: block;">

    <!-- Main Navigation: Inner -->
    <div class="navbar-inner">

        <form class="navbar-search pull-right" action="/admin/searchusers">
            <input type="text" name="name" class="search-query" placeholder="Поиск login" autocomplete="off">
        </form>
        <form class="navbar-search pull-right" action="/admin/searchusersname">
            <input type="text" name="name" class="search-query" placeholder="Поиск name" autocomplete="off">
        </form>

    </div>
    <!-- / Main Navigation: Inner -->

</div>

<style>td {
        white-space: nowrap;
        word-wrap: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }</style>


<div class="top-bar">
    <h3>Пользователи</h3>

</div>


<div class="well no-padding">


    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Ник</th>
            <th>Login</th>
            <th>Баланс</th>
            <th>Админ</th>
            <th>Youtuber</th>
        </tr>
        </thead>
        <tbody>


        <?php foreach($users as $i): ?>


        <tr>
            <td><?php echo e($i->id); ?></td>
            <td><?php echo e($i->username); ?></td>
            <td><?php echo e($i->login); ?></td>
            <td><?php echo e($i->money); ?></td>
            <td><?php if($i->is_admin): ?><span class="label label-important">Да</span><?php else: ?> <span class="label label-success">Нет</span>
                <?php endif; ?>
            </td>
            <td><?php if($i->is_yt): ?><span class="label label-important">Да</span><?php else: ?> <span class="label label-success">Нет</span>
                <?php endif; ?>
            </td>
            <td><a href="/admin/givemoney/<?php echo e($i->id); ?>" class="btn btn-info">Перевести деньги</a></td>
            <td><a href="/admin/user/<?php echo e($i->id); ?>">Редактировать</a></td>
        </tr>
        <?php endforeach; ?>


        </tbody>
    </table>


    <?php echo e($users->render()); ?>

    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->


</div>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>