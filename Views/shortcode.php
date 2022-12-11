<form method="post" class="md-book-search alignwide">
	<fieldset>

		<legend> <?php _e('Search Book', 'md-books-library') ?> </legend>

		<div class="box">
        	<label for="First Name"> <?php _e('Book Name', 'md-books-library') ?> </label>
        	<input type="text" id="md-book-name" name="md_book_name">
      	</div>

      	<div class="box">
      		<label for="md-book-author"><?php _e('Author', 'md-books-library') ?></label>
      		<select name="md_book_author" id="md-book-author">
      			<option value="">--Please select</option>
      			<?php foreach( $authors as $author ) : ?>
      				<option value="<?php echo $author->slug; ?>"><?php echo $author->name;  ?></option>
      			<?php endforeach; ?>
      		</select>
        </div>

        <div class="box" style="clear:both">
      		<label for="md-book-publisher"><?php _e('Publisher', 'md-books-library') ?></label>
      		<select name="md_book_publisher" id="md-book-publisher">
      			<option value="">--Please select</option>
      			<?php foreach( $publishers as $publisher ) : ?>
      				<option value="<?php echo $publisher->slug; ?>"><?php echo $publisher->name;  ?></option>
      			<?php endforeach; ?>
      		</select>
        </div>

        <div class="box">
      		<label for="md-book-rating"><?php _e('Rating', 'md-books-library') ?></label>
      		<select name="md_book_rating" id="md-book-rating">
      			<option value="">--Please select</option>
      			<option value="1">1</option>
      			<option value="2">2</option>
      			<option value="3">3</option>
      			<option value="4">4</option>
      			<option value="5">5</option>
      		</select>
        </div>

        <div class="box">
        	<label for="md-book-rating" style="float:none"><?php _e('Price', 'md-books-library') ?></label>
        	<div id="slider" min="1" max="3000"></div>
        	<input type="text" id="amount" readonly style="border:0;">
        </div>
      	

      	<div class="box-btn">
        	<input type="button" value="Submit" id="search_book">
      	</div>
      
    </fieldset>
 </form>

<div class="search_result alignwide">
	<table class="list">
		<thead>
			<th><?php _e('No', 'md-books-library') ?></th>
			<th><?php _e('Book Name', 'md-books-library') ?></th>
			<th><?php _e('Price', 'md-books-library') ?></th>
			<th><?php _e('Author', 'md-books-library') ?></th>
			<th><?php _e('Publisher', 'md-books-library') ?></th>
			<th><?php _e('Ratings', 'md-books-library') ?></th>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
