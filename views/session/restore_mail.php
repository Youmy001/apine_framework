<h1 style="font-size: 36px; font-weight: 500; line-height: 39.6px; margin: 20px 0 10px 0"><?= ApineAppTranslator::translate('restore_mail','title') ?></h1>
<p><?= ApineAppTranslator::translate('restore_mail','description') ?></p>
<ul>
	<li><?= $this->_params['username'] ?></li>
</ul>
<p><?= ApineAppTranslator::translate('restore_mail','warning') ?></p>
<a href="<?= $this->_params['link'] ?>" style="display: block; margin-bottom: 0; text-align: center; color: white; background-color: #337AB7; border: 1px solid #2E6DA4; border-radius: 4px; padding: 15px 15px; font-size: 18px; font-weight: 400; line-height: 24px; text-decoration: none"><?= ApineAppTranslator::translate('restore_mail','button') ?></a>
<hr style="border: 0px solid #000;border-top: 1px solid #EEE; margin: 20px 0 20px 0;" />
<p style="text-align: center">
	<a href="<?= ApineURLHelper::path(''); ?>"><?= ApineConfig::get('application', 'title') ?></a> - <strong><?= ApineAppTranslator::translate('restore_mail','donotreply') ?></strong>
</p>