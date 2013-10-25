<div class="b-post first-post">     
       
                <div class="post-number"><?=$this->h($post->id);?></div>
                
                <p><?=$this->h($post->content); ?></p>
            </div>
			
			<?php foreach ($comments as $comment):?>
            <div class="b-post">            
                <div class="post-number">
					<?=$this->h($comment->id); ?> | 
					<?php
						if (!empty($comment->name)){
							echo $this->h($comment->name);
						} else {
						echo Config::getDefaultName();
						}
					?>
				</div>
                
                <p><?=$this->h($comment->content); ?></p>        
            </div>
			<?php endforeach; ?>