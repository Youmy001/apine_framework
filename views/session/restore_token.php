
	<!-- content section -->
	<div class="col-md-4 col-md-offset-4">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?= ApineAppTranslator::translate('restore','title'); ?></h3>
			</div>
			<?php if ($this->_params->get_item('error_code')) :?>
			<?php 	if ($this->_params->get_item('error_code') == 200) :?>
			<div class="alert alert-block alert-success" style="margin:0;border-radius:0;">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4><strong><span class="glyphicon glyphicon-ok"></span>&nbsp;<?= ApineAppTranslator::translate('form','success'); ?></strong></h4>
				<span><?php echo $this->_params->get_item('error_message'); ?></span>
			</div>
			<?php else :?>
			<div class="alert alert-block alert-warning" style="margin:0;border-radius:0;">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4><strong><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?= ApineAppTranslator::translate('form','warning'); ?></strong></h4>
				<span><?php echo $this->_params->get_item('error_message'); ?></span>
			</div>
			<?php endif;?>
			<?php endif;?>
			<div class="panel-body">
				<form id="content" action="<?= ApineURLHelper::path("login/restore/".$this->_params->get_item('token')->get_token());?>"
					method="post">
					<div class="form-group">
						<label class="control-label"><?= ApineAppTranslator::translate('restore','username'); ?></label>
						<input class="form-control" type="text" name="user"
								placeholder="<?= ApineAppTranslator::translate('restore','username'); ?>" disabled="disabled" value="<?= $this->_params->get_item('token')->get_user()->get_username() ?>" />
					</div>
					<div class="form-group">
						<label class="control-label"><?= ApineAppTranslator::translate('restore','email'); ?></label>
						<input class="form-control" type="email" name="email"
								placeholder="<?= ApineAppTranslator::translate('restore','email'); ?>" disabled="disabled" value="<?= $this->_params->get_item('token')->get_user()->get_email_address() ?>" />
					</div>
					<div class="form-group">
						<label class="control-label"><?= ApineAppTranslator::translate('restore','password'); ?></label>
						<input class="form-control" type="password" name="password"
								placeholder="<?= ApineAppTranslator::translate('restore','password'); ?>" required="required" />
					</div>
					<div class="form-group">
						<label class="control-label"><?= ApineAppTranslator::translate('restore','password_confirm'); ?></label>
						<input class="form-control" type="password" name="password_confirm"
								placeholder="<?= ApineAppTranslator::translate('restore','password'); ?>" required="required" />
					</div>
					<div class="checkout">
						<input type="hidden" name="action" value="reset" />
						<input type="hidden" name="token" value="<?= $this->_params->get_item('token')->get_token(); ?>" />
						<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<?= ApineAppTranslator::translate('restore','submit'); ?></button>
					</div>
				</form>
			</div>
		</div>

	</div>