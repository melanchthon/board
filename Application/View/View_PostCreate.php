<div class="l-header-clean">
    <h1>Начать новый тред</h1>
</div>
<div class="page-add-form">
   <form method='post' action="../post/create" class="b-add-thread-form b-big-form">
        <input type="hidden" name="name" id="add-name" value="<?=$this->h($auth->getName());?>">

		<?php if (isset($error)):
			foreach ($error as $message): ?>
			<label class="row-error" for="add-text">
				<?=$this->h($message);?>
			</label>
			<?php endforeach; ?>
        <?php endif; ?>
		
		<div class="row">
            <label class="row-label" for="add-title">Заголовок:</label>
            <input type="text"  name="title" id="add-title" class="input-wide" value="<?=(isset($title) ? $title : NULL);?>" />
        </div>
		
        <div class="row">
            <div class="row-comment">Пожалуйста, не пишите здесь ничего плохого, иначе наши суровые 
                модераторы вынуждены будут лишить вас этой возможности.</div>
            <label class="row-label" for="add-text">Текст поста:</label>
            <textarea name="content" id="add-text" class="textarea-wide textarea-large"><?=(isset($content) ? $content : NULL);?></textarea>
			
			
       
	   </div>
		
		<div class='honeypot'>
			<label class='row-label'>Оставте это поле пустым:</label>
			<input type='text' name='honeypot'>
		</div>
		
		<input type='hidden' name='csrf' value ='<?=$csrf->getToken();?>'/>
		
		<div class='captcha'>
			<?php 
				$captcha = new Core_Captcha();
				if($captcha->isCaptchaRequired()){
					$captcha->setCaptcha();
					$captcha->view();
				}
			?>
		</div>
		
       <div class="row row-buttons">
            <button class="button-action button-main">Создать тред</button>
            <a href="../" class="button-left back-link">← вернуться на главную</a>
       </div>
   </form>
</div>