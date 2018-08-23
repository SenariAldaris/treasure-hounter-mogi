

<?php $__env->startSection('content'); ?>



      <div class="top-bar">
          <h3>Последние 20 платежей</h3>

      </div>



      <div class="well no-padding">


          <table class="table">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Пользователь</th>
                  <th>Пополнил</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach($a as $b): ?>
                  <tr>
                      <td><?php echo e($b->id); ?></td>
                      <td><a href="/profile/<?php echo e($b->name_id); ?>"><?php echo e($b->name); ?></a></td>
                      <td><?php echo e($b->amount); ?> rub</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
          <!-- / Add News: WYSIWYG Edior -->

      </div>
      <!-- / Add News: Content -->




      </div>

      </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>