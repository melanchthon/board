			<div class="b-post first-post">     
       
                <div class="post-number">
					#<?=$this->h($post->id);?>
				</div>
                <div class="post-name">
					<?=(!empty($post->name) ? $this->h($post->name) : Config::getDefaultName());?> 
				</div>
                <p><?=$this->h($post->content); ?></p>
            </div>
			
			<?php foreach ($comments as $comment):?>
			
            <div class="b-post">            
               <div class="post-name <?=!empty($comment->name) ? 'authorized' : '';?>">
					<?=(!empty($comment->name) ? $this->h($comment->name) : Config::getDefaultName());?> 
				</div>
			   
			   <div class="post-number">
					#<?=$this->h($comment->id); ?> | <?=$this->h($comment->create_time); ?> 
				</div>
                
                <p><?=$this->h($comment->content); ?></p>        
            </div>
			<?php endforeach; ?>