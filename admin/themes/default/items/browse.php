<?php
$pageTitle = __('Browse Resources');
head(array('title' => $pageTitle, 'content_class' => 'horizontal-nav', 'bodyclass' => 'items primary browse-items'));
?>
<?php echo js('prototype'); ?>
<?php echo js('tooltip_browse_items'); ?>
<h1><?php echo $pageTitle; ?> <?php echo __('(%s total)', total_results()); ?></h1>
<?php if (has_permission('Items', 'add')): ?>
    <?php /* ?><p id="add-item" class="add-button"><a class="add" href="<?php echo html_escape(uri('items/add')); ?>"><?php echo __('Add a File'); ?></a></p><?php */ ?>
    <p id="add-item" class="add-button" style="position:relative; top:0px;"><a class="add" id="fileText" title="<?php echo __('Add in your collection a new resource from your local disk.'); ?>" href="<?php echo html_escape(uri('items/add')); ?>"><?php echo __('Add a File'); ?></a></p>
    <p id="add-item" class="add-button" style="position:relative; top:0px; right:5px;"><a class="add" id="hyperlinkText" title="<?php echo __('Add in your collection a new resource found online by providing its URL.'); ?>" href="<?php echo html_escape(uri('items/addlink')); ?>"><?php echo __('Add a Hyperlink'); ?></a></p> &nbsp;
    <p id="add-item" class="add-button" style="position:relative; right:10px; top:0px;"><a class="add" id="displayText" title="<?php echo __('Add in your collection a new resource from external repositories.'); ?>" href="<?php echo html_escape(uri('items/ingestitemtorepository')); ?>"><?php echo __('Ingest a Resource'); ?></a></p>

    <div id="displayText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Add in your collection a new resource from external repositories.'); ?>
    </div>
    <div id="hyperlinkText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Add in your collection a new resource found online by providing its URL.'); ?>
    </div>
    <div id="fileText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Add in your collection a new resource from your local disk.'); ?>
    </div>

     <script type="text/javascript">
var my_tooltip = new Tooltip('displayText', 'displayText_help');
var my_tooltip2 = new Tooltip('fileText', 'fileText_help');
var my_tooltip3 = new Tooltip('hyperlinkText', 'hyperlinkText_help');
</script>   
<?php endif; ?>
<script>
    function showloader() { 
        document.body.onclick = function (e) {
            if (!(e.ctrlKey || e.which==2)) {
                document.getElementById('loadertoopenpage_div').style.display='block';
                document.getElementById('loadertoopenpage_img').style.display='block';
            }
        }


    }

    function hideloader() { 

        document.getElementByID('loadertoopenpage').style.display='none';

    }
</script>
<div id="loadertoopenpage_div" style="display: none; position: fixed; top: 0px; left: 0px; width:100%; height: 100%;  text-align: center; 
     background-color: silver;
     opacity:0.3;
     filter:alpha(opacity=30);">
</div>
<div id="loadertoopenpage_img" style="display: none; position: fixed; top: 0px; left: 0px; width:100%; height: 100%;  text-align: center; 
     background-image: url(<?php echo uri('themes/default/images/loader.gif') ?>);
     background-position: center center;
     background-repeat: no-repeat; z-index: 1000;">

</div>
<div id="primary">
    <?php echo flash(); ?>
    <?php if (total_results()): ?>
        <script type="text/javascript">
            jQuery(window).load(function() {
                var toggleText = <?php echo js_escape(__('Toggle')); ?>;
                var detailsText = <?php echo js_escape(__('Details')); ?>;
                var showDetailsText = <?php echo js_escape(__('Show Details')); ?>;
                var hideDetailsText = <?php echo js_escape(__('Hide Details')); ?>;
                jQuery('.item-details').hide();
                jQuery('.action-links').prepend('<li class="details">' + detailsText + '</li>');

                jQuery('tr.item').each(function() {
                    var itemDetails = jQuery(this).find('.item-details');
                    if (jQuery.trim(itemDetails.html()) != '') {
                        jQuery(this).find('.details').css({'color': '#389', 'font-weight' : 'bold', 'cursor': 'pointer'}).click(function() {
                            itemDetails.slideToggle('fast');
                        });
                    }
                });

                var toggleList = '<ul id="browse-toggles">'
                    + '<li><strong>' + toggleText + '</strong></li>'
                    + '<li><a href="#" id="toggle-all-details">' + showDetailsText + '</a></li>'
                    + '</ul>';

                jQuery('#items-sort').after(toggleList);

                // Toggle item details.
                jQuery('#toggle-all-details').toggle(function(e) {
                    e.preventDefault();
                    jQuery(this).text(hideDetailsText);
                    jQuery('.item-details').slideDown('fast');
                }, function(e) {
                    e.preventDefault();
                    jQuery(this).text(showDetailsText);
                    jQuery('.item-details').slideUp('fast');
                });

                var itemCheckboxes = jQuery("table#items tbody input[type=checkbox]");
                var globalCheckbox = jQuery('th#batch-edit-heading').html('<input type="checkbox">').find('input');
                var batchEditSubmit = jQuery('.batch-edit-option input');
                /**
                 * Disable the batch submit button first, will be enabled once item
                 * checkboxes are checked.
                 */
                batchEditSubmit.prop('disabled', true);

                /**
                 * Check all the itemCheckboxes if the globalCheckbox is checked.
                 */
                globalCheckbox.change(function() {
                    itemCheckboxes.prop('checked', !!this.checked);
                    checkBatchEditSubmitButton();
                });

                /**
                 * Unchecks the global checkbox if any of the itemCheckboxes are
                 * unchecked.
                 */
                itemCheckboxes.change(function(){
                    if (!this.checked) {
                        globalCheckbox.prop('checked', false);
                    }
                    checkBatchEditSubmitButton();
                });

                /**
                 * Function to check whether the batchEditSubmit button should be
                 * enabled. If any of the itemCheckboxes is checked, the
                 * batchEditSubmit button is enabled.
                 */
                function checkBatchEditSubmitButton() {
                    var checked = false;
                    itemCheckboxes.each(function() {
                        if (this.checked) {
                            checked = true;
                            return false;
                        }
                    });

                    batchEditSubmit.prop('disabled', !checked);
                }
            });
        </script>
        <div id="browse-meta" class="group">
            <p class="help_text">
            <?php echo __('The Resources area consists of Resources Management options such as Ingest a Resource, Add a Hyperlink, Add a File.'); ?><br>
            <?php echo __('It also offers the list of all the resources and the option of Search.'); ?><br>
            <?php echo __('A quick filter option allows for a faster choice between different modes of resources.'); ?>
            </p>
            <div id="browse-meta-lists">
                <ul id="items-sort" class="navigation">
                    <li><strong><?php echo __('Quick Filter'); ?></strong></li>
                    <?php
                    echo nav(array(
                        __('All') => uri('items'),
                        __('Public') => uri('items/browse?public=1'),
                        __('Private') => uri('items/browse?public=0'),
                    ));

                    /* echo nav(array(
                      __('All') => uri('items'),
                      __('Public') => uri('items/browse?public=1'),
                      __('Private') => uri('items/browse?public=0'),
                      __('Featured') => uri('items/browse?featured=1')
                      )); */
                    ?>
                </ul>
            </div>
            <div id="simple-search-form">
                <?php echo '<img id="searchText" style="position:relative; top:21px; left:15px;" src="' . uri("themes/default/items/images/information.png") . '">'; echo simple_search(); ?>
                <div id="searchText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Search using keywords through your resources.'); ?>
    </div>
<script type="text/javascript">
var my_tooltip7 = new Tooltip('searchText', 'searchText_help');

    </script>
                    <?php //echo link_to_advanced_search(__('Advanced Search'), array('id' => 'advanced-search-link')); ?>
            </div>
        </div>

        <form id="items-browse" action="<?php echo html_escape(uri('items/batch-edit')); ?>" method="post" accept-charset="utf-8">
            <div class="group">
                <?php if (has_permission('Items', 'edit')): ?>
                    <?php /* ?><div class="batch-edit-option">
                      <input type="submit" class="submit" name="submit" value="<?php echo __('Edit Selected Items'); ?>" />
                      </div><?php */ ?>
                <?php endif; ?>
                <div class="pagination"><?php echo pagination_links(); ?></div>
            </div>
            <table id="items" class="simple" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <?php if (has_permission('Items', 'edit')): ?>
                            <?php /* ?><th id="batch-edit-heading"><?php echo __('Select'); ?></th><?php */ ?>
                        <?php endif; ?>
                        <?php
                        $browseHeadings[__('Title').' <img id="titleText" src="' . uri("themes/default/items/images/information.png") . '">'] = 'Dublin Core,Title';
                        /* $browseHeadings[__('Creator')] = 'Dublin Core,Creator'; */
                        $browseHeadings[__('Type')] = null;
                        $browseHeadings[__('Public').' <img id="publicText" src="' . uri("themes/default/items/images/information.png") . '">'] = 'public';
                        /* $browseHeadings[__('Featured')] = 'featured'; */
                        $browseHeadings[__('Date Added').' <img id="dateaddedText" src="' . uri("themes/default/items/images/information.png") . '">'] = 'added';
                        echo browse_headings($browseHeadings);
                        ?>
                        
     <div id="titleText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Sort alphabetically the resources based on Title'); ?>
    </div>
    <div id="publicText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Sort the resources based on their status (public – private).'); ?>
    </div>
    <div id="dateaddedText_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Sort the resources based on the Date Added.'); ?>
    </div>
                        <script type="text/javascript">
var my_tooltip4 = new Tooltip('titleText', 'titleText_help');
var my_tooltip5 = new Tooltip('publicText', 'publicText_help');
var my_tooltip6 = new Tooltip('dateaddedText', 'dateaddedText_help');
    </script>
                    </tr>
                </thead>
                <tbody>
                    <?php $key = 0; ?>
                    <?php while ($item = loop_items()): ?>
                        <tr class="item <?php if (++$key % 2 == 1) echo 'odd'; else echo 'even'; ?>">
                            <?php $id = item('id'); ?>
                            <?php /* ?><?php if (has_permission($item, 'edit') || has_permission($item, 'tag')): ?>
                              <td class="batch-edit-check" scope="row"><input type="checkbox" name="items[]" value="<?php echo $id; ?>" /></td>
                              <?php endif; ?><?php */ ?>
                            <td class="item-info">
                                <span class="title"><?php echo link_to_item(item('Dublin Core', 'Title'), array(), 'edit'); ?></span>
                                <ul class="action-links group">
                                    <li><?php $uri=WEB_ROOT; $uri=explode('http://',$uri);	echo '<a href="http://'.$uri[1].'/oai?verb=GetRecordOnlyLom&metadataPrefix=oai_lom&identifier=oai:'.$uri[1].'/:'.$item->id.':item" target="_blank">XML</a>'; ?></li> 
                                    <?php /* <li><?php echo '<a href="javascript:void(0);" onclick="translatediv(\''.$item->id.'_trans\',\''.$item->id.'\')">'.__('Translate').'</a>'; ?></li> */ ?>
                                    <?php /*<li><?php
                            $uri = WEB_ROOT;
                            $uri = explode('http://', $uri);
                            echo '<a href="http://' . $uri[1] . '/oai?verb=GetRecordOnlyLom&metadataPrefix=oai_lom&identifier=oai:' . $uri[1] . '/:' . $item->id . ':item" target="_blank">XML</a>';
                                    ?></li> */ ?>

                                    <?php if (has_permission($item, 'edit')): ?>
                                        <li><?php echo link_to_item(__('Edit'), array('onclick' => 'showloader();'), 'edit'); ?></li>
                                    <?php endif; ?>
                                    <?php if (has_permission($item, 'delete')): ?>
                                        <li><?php echo link_to_item(__('Delete'), array('class' => 'delete-confirm'), 'delete-confirm'); ?></li>
                                        <?php echo '<div id="' . $item->id . '_trans" title="' . __('Please select language to translate:') . '"></div>'; ?>
                                        <script type="text/javascript" charset="utf-8">
                                            function translatediv(name,item_id){


                                                //var answer = confirm("Are you sure you want to TRANSLATE it?")
                                                //   if (answer){

                                                //var name = document.getElementById(name).value;

                                                jQuery.post("<?php echo uri('items/translatexerox'); ?>", { name: name, item_id: item_id },
                                                function(data) {

                                                    //alert(name);
                                                    // document.getElementById('#'+nameid+'_trans')=data;
                                                    //jQuery('#'+nameid+'_trans').html(data);

                                                    jQuery('#'+name+'').html(data).dialog({modal: true}).dialog('open');
                                                });

                                                //} 

                                            }
                                        </script>

                                    <?php endif; ?>
                                </ul>
                                <?php fire_plugin_hook('admin_append_to_items_browse_simple_each'); ?>
                                <div class="item-details">
                                    <?php
                                    if (item_has_thumbnail()) {
                                        //echo link_to_item(item_square_thumbnail(), array('class'=>'square-thumbnail'));
                                        echo link_to_item(item_square_thumbnail(), array('class' => 'square-thumbnail'));
                                    }
                                    ?>
                                    <?php echo snippet_by_word_count(strip_formatting(item('Dublin Core', 'Description')), 40); ?>
                                    <ul>
                                        <?php /* ?> <li><strong><?php echo __('Collection'); ?>:</strong> <?php if (item_belongs_to_collection()) echo link_to_collection_for_item(); else echo __('No Collection'); ?></li>
                                          <li><strong><?php echo __('Tags'); ?>:</strong> <?php if ($tags = item_tags_as_string()) echo $tags; else echo __('No Tags'); ?></li><?php */ ?>
                                    </ul>
                                    <?php fire_plugin_hook('admin_append_to_items_browse_detailed_each'); ?>
                                </div>
                            </td>
                            <?php /* ?><td><?php echo strip_formatting(item('Dublin Core', 'Creator')); ?></td><?php */ ?>
                            <td><?php
                    echo ($typeName = __(item('Item Type Name'))) ? __($typeName) : '<em>' . __(item('Dublin Core', 'Type', array('snippet' => 35))) . '</em>';
                            ?></td>
                            <td>
                                <?php if ($item->public): ?>
                                    <img src="<?php echo img('silk-icons/tick.png'); ?>" alt="<?php echo __('Public'); ?>"/>
                                <?php endif; ?>
                            </td>
                            <?php /* ?><td>
                              <?php if($item->featured): ?>
                              <img src="<?php echo img('silk-icons/star.png'); ?>" alt="<?php echo __('Featured'); ?>"/>
                              <?php endif; ?>
                              </td><?php */ ?>
                            <td><?php echo format_date(item('Date Added')); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="group">
                <?php if (has_permission('Items', 'edit')): ?>
                    <?php /* ?><div class="batch-edit-option">
                      <input type="submit" class="submit" name="submit" value="<?php echo __('Edit Selected Items'); ?>" />
                      </div><?php */ ?>
                <?php endif; ?>
                <div class="pagination"><?php echo pagination_links(); ?></div>
            </div>
        </form>

        <?php /* ?><div id="output-formats">
          <h2><?php echo __('Output Formats'); ?></h2>
          <?php echo output_format_list(false, ' · '); ?>
          </div><?php */ ?>

    <?php elseif (!total_items()): ?>
        <div id="no-items">
            <p><?php echo __('There are no items in the archive yet.'); ?>

                <?php if (has_permission('Items', 'add')): ?>
                    <?php echo link_to('items', 'add', __('Add an item.')); ?></p>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <p><?php echo __('The query searched %s items and returned no results.', total_items()); ?> <?php //echo __('Would you like to %s?', link_to_advanced_search(__('refine your search')));   ?></p>

    <?php endif; ?>



    <?php fire_plugin_hook('admin_append_to_items_browse_primary', $items); ?>

</div>
<?php foot(); ?>
