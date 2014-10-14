<?php echo $this->Html->script("/announcements/js/announcements.js");?>
<!-- スペースのコントローラで読み込む -->
<?php echo $this->Html->script("/pages/js/pages.js"); ?>
<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<div ng-controller="PagesController">
<!-- Fixed navbar 別のプラグインとして実装することになる予定 -->
<!-- navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">NetCommons3</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="/"><?php echo __("Home"); ?></a></li>

				<?php if ($User = AuthComponent::user()): ?>
					<li>
						<?php //echo h($User['handle']) ?>
						<?php echo $this->Html->link(__('Logout'), '/auth/logout') ?>
					</li>
					<li <?php
						if (isset($this->request->params['plugin'])
							&& $this->request->params['plugin'] == 'ThemeSettings') {
						echo 'class="active"';
						}
					?>>
						<?php echo $this->Html->link(__('Theme setting'), '/theme_settings/site/') ?>
					</li>

					<li>
						<?php if (!Page::isSetting()): ?>
							<?php echo $this->Html->link(__('Setting mode on'), '/' . Page::SETTING_MODE_WORD . '/' . $path) ?>
						<?php else: ?>
							<?php echo $this->Html->link(__('Setting mode off'), '/' . $path) ?>
						<?php endif; ?>
					</li>

					<li>
						<?php //echo $this->Html->link(__('Control Panel'), '/control_panel/index') ?>
					</li>
				<?php else: ?>
					<li>
						<?php echo $this->Html->link(__('Login'), '/auth/login') ?>
					</li>
				<?php endif; ?>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

<div>
<?php
if (Page::isSetting()) {
	echo $this->element('Pages.plugin_list');
	echo $this->element('Pages.setting_menu');
}

echo $this->element('Containers.render_containers',
	array(
		'containers' => $page['Container'],
		'boxes' => $page['Box']
	));
?>
</div>
