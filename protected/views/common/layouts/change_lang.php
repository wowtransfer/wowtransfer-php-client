<div class="dropdown" style="display: inline-block;" id="change-lang-block">
	<? $lang = Yii::app()->user->lang ?>
	<button class="btn btn-default btn-sm dropdown-toggle" type="button"
			id="change-lang" data-toggle="dropdown"
			aria-haspopup="true" aria-expanded="true">
		<?= strtoupper($lang) ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="change-lang">
		<li class="<?= $lang === 'ru' ? 'active' : '' ?>">
			<a href="<?= $this->createUrl('/site/lang', ['lang' => 'ru']) ?>">
				<span class="spr flag-ru"></span>
			</a>
		</li>
		<li class="<?= $lang === 'en' ? 'active' : '' ?>">
			<a href="<?= $this->createUrl('/site/lang', ['lang' => 'en']) ?>">
				<span class="spr flag-en"></span>
			</a>
		</li>
	</ul>
</div>
