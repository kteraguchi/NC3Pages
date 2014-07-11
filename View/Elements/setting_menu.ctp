<?php 
/**
 * Setting menu element.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<script src="/net_commons/jqueryui/jquery-ui.js"></script>
<link href="/net_commons/jqueryui/themes/base/minified/jquery-ui.min.css" rel="stylesheet">

<div id="settingMenu"  class="panel-body btn-group-vertical" title="Setting menu">
	<button type="button" class="btn btn-default" ng-click="changePluginSetting()">
		<?php echo __('Plugin')?>
	</button>
	<button type="button" class="btn btn-default" ng-click="changeLayoutSetting()">
		<?php echo __('Layout')?>
	</button>
	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#pageSetting">
		<?php echo __('Page')?>
	</button>
	<button type="button" class="btn btn-default" ng-click="">
		<!-- Setting Mode Off へのリンク処理 -->
		<?php echo __('Settin mode off')?>
	</button>
</div>

<div class="modal fade" id="pageSetting" tabindex="-1" role="dialog" aria-labelledby="pageSettingLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __('Page Setting'); ?>
			</div>

			<?php
				echo $this->Form->create(
					'Page',
					array(
						//'id' => 'pagesAdd',
						'url' => array(
							'plugin' => 'pages',
							'controller' => 'pages',
							'action' => 'add'
						),
						'role' => 'form'
					));
<<<<<<< HEAD
				echo $this->Form->input('Page.parent_id', array('type' => 'hidden'));
				echo $this->Form->input(
					'Language.0.id',
					array(
						'type' => 'hidden',
						'value' => $page['Language'][0]['id']
					));
				echo $this->Form->input(
					'Language.0.LanguagesPage.language_id',
					array(
						'type' => 'hidden',
						'value' => $page['Language'][0]['LanguagesPage']['language_id']
					));
			?>
				<div class="modal-body" ng-controller="PluginController">
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'Language.0.LanguagesPage.name',
								array(
									'label' => __('Page name'),
									'class' => 'form-control'
								));
						?>
					</div>
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'Page.slug',
=======
				echo $this->Form->input('parent_id', array('type' => 'hidden'));
				echo $this->Form->input(
					'Language.0.id',
					array(
						'type' => 'hidden',
						'value' => $page['Language'][0]['id']
					));
				echo $this->Form->input(
					'Language.0.LanguagesPage.language_id',
					array(
						'type' => 'hidden',
						'value' => $page['Language'][0]['LanguagesPage']['language_id']
					));
			?>
				<div class="modal-body" ng-controller="PluginController">
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'Language.0.LanguagesPage.name',
								array(
									'label' => __('Page name'),
									'class' => 'form-control'
								));
						?>
					</div>
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'slug',
>>>>>>> refs/heads/trialCode
								array(
									'label' => __('Slug'),
									'class' => 'form-control'
								));
						?>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close') ?></button>
					<button type="submit" class="btn btn-primary"><?php echo __('Add') ?></button>
					<button type="submit" class="btn btn-primary"><?php echo __('Add and close') ?></button>
					</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<script>
$('#settingMenu').dialog({
	closeOnEscape: false,
	width: "170px",
	position: {
		my: "right-30 center",
		at: "right center",
		of: window,
		collision: 'none'
	},
	open: function( event, ui ) {
		var titleBar = $("#settingMenu").prev(".ui-dialog-titlebar");
		titleBar.removeClass("ui-widget-header");
		titleBar.addClass("panel-heading");
		titleBar.parent().removeClass("ui-widget-content");
		titleBar.parent().addClass("panel panel-info");
		titleBar.children(".ui-dialog-titlebar-close").hide();
	}
});
</script>
