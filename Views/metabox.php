<style>
    .currency-wrap{
        position:relative;
    }
    
    .currency-code{
        position: absolute;
        left: 0px;
        background: #ddd;
        top: 0px;
        padding: 0px 10px;
        line-height: 2;
        min-height: 28px;
        border-radius: 4px 0px 0px 4px;
        border: 1px solid #8c8f94;
        box-shadow: 0 0 0 transparent;
    }
    
    #md-book-price{
        padding-left: 32px;
    }
</style>
<p>
    <label for="md-book-price"><?php _e( "Price", 'md-books-library' ); ?></label>
    <br />

    <div class="currency-wrap">
        <span class="currency-code">$</span>
        <input class="widefat" type="number" name="md-book-price" id="md-book-price" value="<?php echo $price; ?>" size="30" />
    </div>
</p>
<p>
    <label for="md-book-rating"><?php _e( "Star Rating", 'md-books-library' ); ?></label>
    <br />

    <select class="widefat" name="md-book-rating" id="md-book-rating">
        <option value="1" <?php echo selected( $rating , '1', false); ?>>1</option>
        <option value="2" <?php echo selected( $rating , '2', false); ?>>2</option>
        <option value="3" <?php echo selected( $rating , '3', false); ?>>3</option>
        <option value="4" <?php echo selected( $rating , '4', false); ?>>4</option>
        <option value="5" <?php echo selected( $rating , '5', false); ?>>5</option>
    </select>
</p>

<?php wp_nonce_field( 'asjdhsakdsamnbsjahd', 'md_books_nonce' ); ?>