
<div class="menus view large-9 medium-8 columns content">
<div class="panel panel-default">
	<div class="panel-heading"> 
		
		
		 <div class="dropdown pull-right">
                                <button class="btn dropdown-toggle btn-sm"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-list pull-right" aria-hidden="true"></span>&nbsp; '.__('Listagem'), ['action' => 'index'], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>&nbsp; '.__('Alterar'), ['action' => 'edit', $menu->id], ['escape' => false]) ?></li>
                                    <li> <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>&nbsp; '.__('Remover'), ['action' => 'delete', $menu->id], ['class'=>'delete-confirm','escape' => false]) ?></li>
                                </ul>
                </div>
                
          <h3>Menu <small><?= h($menu->descricao) ?></small></h3>
	</div>
    <div class="panel-body">  
    <?php 
    foreach ($crumbs as $cb) {
	//	debug($cb);
		$this->Html->addCrumb($cb->descricao, ['controller' => 'menus', 'action' => 'view', $cb->id]);
/*$this->Html->addCrumb('Home', '/');
		$this->Html->addCrumb('Pages', ['controller' => 'pages']);
		$this->Html->addCrumb('About', ['controller' => 'pages', 'action' => 'about']);
	*/	
	}
	echo $this->Html->getCrumbList();
    ?>
    
    <table class="table">
    	<tr>
            <th><?= __('Sistema') ?></th>
            <td><?= $menu->has('sistema') ? h($menu->sistema->nome) : '' ?></td>
        </tr>
        	<tr>
            <th><?= __('Menu Item') ?></th>
            <td><?= h($menu->descricao) ?></td>
        </tr>
        <tr>
            <th><?= __('URL') ?></th>
            <td><?= h($menu->prefix) ?>/<?= h($menu->controller) ?>/<?= h($menu->action) ?></td>
        </tr>
        
        <tr>
            <th><?= __('Parent') ?></th>
            <td><?= $menu->has('parent_menu') ? h($menu->parent_menu->descricao) : '-- RAIZ --' ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($menu->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rght') ?></th>
            <td><?= $this->Number->format($menu->rght) ?></td>
        </tr>
        <tr>
            <th><?= __('Ativo') ?></th>
            <td><?= $menu->ativo ? __('SIM') : __('NÃO'); ?></td>
         </tr>
    </table>
   
  
    
<ul class="nav nav-tabs">

  <li role="presentation" class="active"><a href="#Menus" aria-controls="Menus" role="tab" data-toggle="tab"><?= __('Sub-Menus') ?></a></li>
  
  
</ul>
    
    </div>

<div class="panel-body">
	<div class="tab-content">
		    
	    <div role="tabpanel" class="tab-pane active" id="Menus">
	    
	        
	        <?php if (!$descendants->isEmpty()): ?>
	        <table class="table table-hover tree" cellpadding="0" cellspacing="0">
	            <tr>
		                <th class="ajax-pagination">Sub-Menu Item</th>
						<th class="ajax-pagination">Ativo</th>
						<th class="actions">&nbsp;</th>
		               
	            </tr>
	            <?php 
	           
	            foreach ($descendants as $childMenus): ?>
	            <?php 
	            
		            $id = "treegrid-".$childMenus->id;
		            
		            $parent_id = "treegrid-parent-". ($childMenus->parent_id == $menu->id ? '' : $childMenus->parent_id );
		            
		            $class="$id $parent_id";
		            
		            if(!$childMenus->ativo)
		            	$class.=" text-danger";
	            ?>
	           <tr class="<?php echo $class?>" >
                    
                                               
						<td>&nbsp;&nbsp; <?php echo h($childMenus->descricao) ?> &nbsp; &nbsp; <small><?php echo h($childMenus->prefix) ?>/<?php echo h($childMenus->controller) ?>/<?php echo h($childMenus->action) ?></small></td>
						<td><?php echo h($childMenus->ativo ? 'SIM' : 'NÃO') ?></td>
						<td>
                            <a href="#" class="btn btn-info btn-sm pull-right"  rel="popover" data-placement="left" data-popover-content="#myPopover<?php echo $childMenus->id ?>" data-container="body" data-toggle="popover"> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
							<div id="myPopover<?php echo $childMenus->id ?>" class="hide">
								  <?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign " aria-hidden="true"></span>', ['action' => 'view', $childMenus->id], ['class'=>'btn btn-default', 'escape' => false]) ?>
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>', ['action' => 'edit', $childMenus->id], ['class'=>'btn btn-default','escape' => false]) ?>
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash " aria-hidden="true"></span>', ['action' => 'delete', $childMenus->id], ['class'=>'btn btn-danger delete-confirm','title'=>"Remover",'escape' => false]) ?>
							</div>
                        </td>
                    </tr>
	            <?php endforeach; ?>
	        </table>
	    <?php else: ?>
	    <div class="alert alert-warning">Nenhum sub-menu encontrado.</div>
	    <?php endif; ?>
	    </div>
		</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('.tree').treegrid();
  });
</script>
