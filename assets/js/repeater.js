jQuery.fn.extend({
    createRepeater: function (options = {}, callback) {
        var hasOption = function (optionKey) {
            return options.hasOwnProperty(optionKey);
        };

        var option = function (optionKey) {
            return options[optionKey];
        };

        var generateId = function (string) {
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase();
        };

        var addItem = function (items, key, instanceIndex, fresh = true) {

            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select,textarea');

            input.each(function (index, el) {
                var attrName = jQuery(el).data('name');
                var skipName = jQuery(el).data('skip-name');
                if (skipName != true) {
                    jQuery(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                } else {
                    if (attrName != 'undefined') {
                        jQuery(el).attr("name", attrName);
                    }
                }
                if (fresh == true) {
                    jQuery(el).attr('value', '');
                }

                jQuery(el).attr('id', generateId(jQuery(el).attr('name')));
                jQuery(el).parent().find('label').attr('for', generateId(jQuery(el).attr('name')));
            })

            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.sof-remove-btn');
            removeButton.attr('onclick', 'jQuery(this).parents(\'.items\').remove()');

            var newItem = jQuery("<div class='items'>" + itemClone.html() + "<div/>");
            newItem.attr('data-index', key)

            newItem.appendTo(repeater[instanceIndex]);

            if(callback) callback();
        };

        /* find elements */
        var repeater = this;

        repeater.each(function (instanceIndex, instance) {
            var items = jQuery(instance).find(".sof-repeater-items");

            var key = 0;
            var addButton = jQuery(instance).closest('.sof-repeater-box').find('.repeater-add-btn');

            items.each(function (index, item) {
                items.remove();
                if (items.length > 1) {
                    addItem(jQuery(item), key, instanceIndex,false);
                    key++;
                } else {
                    const isEmpty = items.attr("data-empty");
                    if(isEmpty) {
                        if(hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') === true) {
                            addItem(jQuery(item), key, instanceIndex, true);
                            key++;
                        }
                    } else {
                        addItem(jQuery(item), key, instanceIndex, false);
                        key++;
                    }
                }
            });

            /* handle click and add items */
            addButton.on("click", function (e) {
                e.preventDefault();
                addItem(jQuery(items[0]), key, instanceIndex, false);
                key++;
            });
        })
    }
});
