<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?>
         style="<?php echo $this->style; ?>"<?php endif; ?>>
	<?php
	echo $this->list;
	
	if ($this->total > $this->limit):
		$objPagination = new Pagination($this->count, $intLimit);
		echo $objPagination->generate();
	endif;
	?>
</div>