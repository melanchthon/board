<div class="l-header-clean">
    <h1>Регистрация</h1>
</div>
<div class="page-add-form">
   <form method='post' action="<?=Config::getBasePath()?>/user/create" class="b-add-thread-form b-big-form">
		
		<?php if (isset($error)):
			foreach ($error as $message): ?>
			<label class="row-error" for="add-text">
				<?=$this->h($message);?>
			</label>
			<?php endforeach; ?>
        <?php endif; ?>
	
        <div class="row">
            <div class="row-comment">Ваш логин должен состоять не менее чем из 5 символов.</div>
            <label class="row-label" for="add-text">Ваш логин:</label>
            <input type ="text" name="name" class="input-wide"/>
        </div>
		
		<div class="row">            
			<div class="row-comment">Ваш пароль должен состоять не менее чем из 8 символов и содержать не только цифры, но ибуквы.</div>
            <label class="row-label" for="add-name">Ваш пароль:</label>
            <input type="text" name="pass" class="input-wide">
		</div>
        

       <div class="row row-buttons">
            <button class="button-action button-main">Зарегистрироваться</button>
       </div>
   </form>
   <a href="<?=Config::getBasePath()?>" class="button-left back-link">← вернуться на главную</a>
</div>