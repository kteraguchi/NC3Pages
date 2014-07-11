<?php echo $this->Html->script("/announcements/js/announcements.js");?>
<!-- スペースのコントローラで読み込む -->
<?php echo $this->Html->script("/pages/js/pages.js"); ?>
<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
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
				<li><a href="/"><?php echo __("ホーム"); ?></a></li>

				<li>
					<?php if ($User = AuthComponent::user()): ?>
						<?php //echo h($User['handle']) ?>
						<?php echo $this->Html->link(__('Logout'), '/auth/logout') ?>
					<?php else: ?>
						<?php echo $this->Html->link(__('Login'), '/auth/login') ?>
					<?php endif; ?>
				</li>

				<li <?php
					if (isset($this->request->params['plugin'])
						&& $this->request->params['plugin'] == 'ThemeSettings') {
					echo 'class="active"';
					}
				?>>
					<?php echo $this->Html->link(__('テーマ設定'), '/theme_settings/site/') ?>
				</li>

				<li>
					<?php if (!Configure::read('Pages.isSetting')): ?>
						<?php echo $this->Html->link(__('Setting mode on'), '/' . Configure::read('Pages.settingModeWord') . $path) ?>
					<?php else: ?>
						<?php echo $this->Html->link(__('Setting mode off'), '/' . $path) ?>
					<?php endif; ?>
				</li>

			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

<div>
<?php
if (Configure::read('Pages.isSetting')) {
	echo $this->element('plugin_list');
	echo $this->element('setting_menu');
}
?>

<?php if (isset($containers[Configure::read('Containers.type.header')])): ?>
	<!-- container-header -->
	<header id="container-header">
		<?php echo $this->requestAction(
						'containers/containers/index/' . $containers[Configure::read('Containers.type.header')]['id'],
						array('return')); ?>
	</header>
<?php endif; ?>

<div class="container">

	<?php if (isset($containers[Configure::read('Containers.type.major')])): ?>
		<!-- container-major -->
		<div id="container-major" class="col-sm-3">
			<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.major')]['id'],
							array('return')); ?>
		</div>
	<?php endif; ?>

	<!-- container-main -->
	<div id="container-main" class="col-sm-6" role="main">
		<?php echo $this->requestAction(
						'containers/containers/index/' . $containers[Configure::read('Containers.type.main')]['id'],
						array('return')); ?>
	</div>
	
	<?php if (isset($containers[Configure::read('Containers.type.minor')])): ?>
		<!-- container-minor  -->
		<div id="container-minor" class="col-sm-3">
			<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.minor')]['id'],
							array('return')); ?>
	</div>
	<?php endif; ?>

</div>

<?php if (isset($containers[Configure::read('Containers.type.footer')])): ?>
	<!-- area-footer  -->
	<footer id="container-footer" role="contentinfo">
		<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.footer')]['id'],
							array('return')); ?>
	</footer>
<?php endif; ?>
</div>
</div>
