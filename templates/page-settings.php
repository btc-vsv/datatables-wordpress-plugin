<div class="wrap">
    <h1><?php esc_html_e( 'DataTables Settings', 'datatables' ) ?></h1>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
            <tr>
                <th><?php esc_html_e( 'Include DataTables', 'datatables' ) ?></th>
                <td>
                    <fieldset>
                        <label>
                            <input class="radio_include" type="radio" name="include" value="everywhere"<?php checked( 'everywhere', $options['include'] ); ?>> <span><?php esc_html_e( 'Everywhere', 'datatables' ) ?></span>
                        </label><br />
                        <label>
                            <input id="posts" class="radio_include" type="radio" name="include" value="posts"<?php checked( 'posts', $options['include'] ); ?>> <span><?php esc_html_e( 'On some pages and posts', 'datatables' ) ?></span>
                        </label><br />
                        <div id="posts_ids">
                            <label><input name="posts_ids" type="text" value="<?php echo implode( ',', $options['posts_ids'] ); ?>" class="regular-text"></label><br />
                        </div>
                        <label>
                            <input class="radio_include" type="radio" name="include" value="manually"<?php checked( 'manually', $options['include'] ); ?>> <span><?php esc_html_e( 'Manually', 'datatables' ) ?> (JavaScript)</span>
                        </label><br />
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th>Option2</th>
                <td></td>
            </tr>
            <tr>
                <th>Option3</th>
                <td></td>
            </tr>
            </tbody>
        </table>
        <?php wp_nonce_field('datatables_settings','nonce_field'); ?>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'datatables' ) ?>" />
        </p>
    </form>
</div>