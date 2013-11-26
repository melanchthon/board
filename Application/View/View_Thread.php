<div class="l-header">
    <div class="wrap">
        <h1><?=$this->h($post->title)?></h1>
    </div>
    <div class="overlay"></div>
</div>

<div class="page-thread">

    <div class="b-threads-list">
        <div class="b-thread">
            <?php require __DIR__.'/View_ThreadBody.php' ?>
            <div class="b-post-actions clearfix">
               
				<form method = "post" action="../comment/create" class="b-in-thread-form b-big-form">
					<div class="row row-header">
						<h2>Вам слово</h2>
						<p class="mb-0">Хотите добавить свой комментарий? 
						Пожалуйста, воспользуйтесь этой формой.</p>
					</div>
					<input type="hidden" name="postId" value="<?=$this->h($_GET['thread']);?>" />
					<div class="row">
						
						<div class="row-comment">Ведите себя воспитанно. Невоспитанных ловят
						наши коты-модераторы.</div>
						<label class="row-label" for="add-text">Комментарий:</label>
						<textarea id="add-text" name="content" class="textarea-wide textarea-medium"></textarea>
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
					
					
					<button class="button-action button-main">Добавить комментарий</button>
			   </form>         
               <a href="<?=Config::getBasePath()?>" class="button-left back-link">← вернуться на главную</a>
            </div>
        </div>
    </div>
</div>