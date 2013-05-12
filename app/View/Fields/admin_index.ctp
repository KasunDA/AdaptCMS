<?php $this->Html->addCrumb('Admin', '/admin') ?>
<?php $this->Html->addCrumb('Fields', null) ?>

<div class="pull-left">
    <h1>Fields<?php if (!empty($this->params->named['trash'])): ?> - Trash<?php endif ?></h1>
</div>
<div class="btn-toolbar pull-right" style="margin-bottom:10px">
    <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown">
            Filter by Category
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($categories as $category_id => $category): ?>
                <li>
                    <?= $this->Html->link($category, array(
                        'category_id' => $category_id
                    )) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown">
            Filter by Module
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($modules as $id => $module): ?>
                <li>
                    <?= $this->Html->link($module, array(
                        'module_id' => $id
                    )) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown">
            Filter by Field Type
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($field_types as $key => $type): ?>
                <li>
                    <?= $this->Html->link($type, array(
                        'field_type' => $key
                    )) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown">
        View <i class="icon-picture"></i>
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu view">
        <li>
            <?= $this->Html->link('<i class="icon-ok"></i> Active', array(
                'admin' => true, 
                'action' => 'index'
            ), array('escape' => false)) ?>
        </li>
        <li>
            <?= $this->Html->link('<i class="icon-trash"></i> Trash', array(
                'admin' => true, 
                'action' => 'index', 
                'trash' => 1
            ), array('escape' => false)) ?>
        </li>
      </ul>
    </div>
</div>
<div class="clearfix"></div>

<?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_add'])): ?>
    <?= $this->Html->link('Add Field <i class="icon icon-plus icon-white"></i>', array('action' => 'add'), array(
        'class' => 'btn btn-info pull-right', 
        'style' => 'margin-bottom:10px',
        'escape' => false
    )) ?>
<?php endif ?>

<?php if (empty($this->request->data)): ?>
    <div class="clearfix"></div>
    <div class="well">
        No Items Found
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('field_type', 'Type') ?></th>
                <th><?= $this->Paginator->sort('Category.title', 'Category') ?></th>
                <th><?= $this->Paginator->sort('Module.title', 'Module') ?></th>
                <th><?= $this->Paginator->sort('User.username', 'Author') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>

        <?php foreach ($this->request->data as $data): ?>
            <tbody>
                <tr>
                    <td>
                        <?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_edit'], $data['User']['id'])): ?>
                            <?= $this->Html->link($data['Field']['title'], array(
                                'action' => 'edit',
                                $data['Field']['id']
                            )) ?>
                        <?php else: ?>
                            <?= $data['Field']['title'] ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?= ucfirst($data['Field']['field_type']) ?>
                    </td>
                    <td>
                        <?php if (!empty($data['Category']['id'])): ?>
                            <?= $this->Html->link($data['Category']['title'], array(
                                    'controller' => 'categories',
                                    'action' => 'admin_edit',
                                    $data['Category']['id']
                            )) ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if (!empty($data['Module']['id'])): ?>
                            <?= $data['Module']['title'] ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($this->Admin->hasPermission($permissions['related']['users']['profile'], $data['User']['id'])): ?>
                            <?= $this->Html->link($data['User']['username'], array(
                                'controller' => 'users',
                                'action' => 'profile',
                                $data['User']['username']
                            )) ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?= $this->Admin->time($data['Field']['created']) ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (empty($this->params->named['trash'])): ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_edit'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->edit(
                                                $data['Field']['id']
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_delete'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->delete(
                                                $data['Field']['id'],
                                                $data['Field']['title'],
                                                'field'
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_restore'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->restore(
                                                $data['Field']['id'],
                                                $data['Field']['title']
                                            ) ?>
                                        </li>
                                    <?php endif ?> 
                                    <?php if ($this->Admin->hasPermission($permissions['related']['fields']['admin_delete'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->delete_perm(
                                                $data['Field']['id'],
                                                $data['Field']['title'],
                                                'field'
                                            ) ?>
                                        </li>  
                                    <?php endif ?>
                                <?php endif ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
<?php endif ?>

<?= $this->element('admin_pagination') ?>