/**
 * Bottega file manager JavaScript module.
 *
 * @link https://github.com/vetoni/Bottega
 * @copyright Vetoni (c) 2015
 * @license https://opensource.org/licenses/MIT
 * @author Vetoni <vetoni.github@gmail.com>
 */

(function ($) {
    $(document).ready(function() {

        $.fn.fileManager = function(options) {

            var manager = this;
            manager.on('click', 'button', function(e) {
                e.preventDefault();
                $(this).parent('li').remove();
            });
            manager.on('fileInsert', function(e, data) {

                var template =
                    '<li>'
                        +'<button type="button" class="btn-remove">'
                        +'<i class="glyphicon glyphicon-remove-circle"></i>'
                        +'</button>'
                        +'<img src="' + data.thumb_url + '" alt="">'
                        +'<input name="' + options.name
                            + '[' + data.id + ']" value="'
                            + data.url +'" type="hidden">'
                    +'</li>',

                    images = $(this).find('.file-manager-images');

                if (options.multiple) {
                    images.append(template);
                }
                else {
                    images.find('li').remove();
                    images.append(template);
                }
            });
            manager.closest('form').on('submit', function() {
               var data = $('.file-manager-images li', $(this));
               if (data.length == 0) {
                   $(this).append('<input type="hidden" name="' + options.name +'" value="">');
               }
            });

            var modal = manager.find('.modal');
            modal.on('show.bs.modal', function() {
                var modalBody = $(this).find('.modal-body');
                modalBody.html('<iframe class="file-manager-frame" src="' + options.url + '"></iframe>');
                var frame = $(this).find('.file-manager-frame');
                frame.load(function() {
                    var contents = frame.contents(),
                        info = $('.file-manager-details .info', contents),
                        list = $('.file-manager-list', contents),

                        files = {
                            selectItem: function(item) {
                                files.removeSelection();
                                item.toggleClass('selected');
                                files.loadDetails({
                                    id: item.parent().attr('data-key'),
                                    url: item.attr('data-action')
                                });
                            },
                            removeSelection: function() {
                                list.find('a.selected').toggleClass('selected');
                            },
                            loadDetails: function(data) {
                                $.ajax({
                                    type: "GET",
                                    url: data.url,
                                    data: "id=" + data.id,
                                    beforeSend: function() {
                                        files.setAjaxLoader();
                                    },
                                    success: function(html) {
                                        info.html(html);
                                    }
                                });
                            },
                            deleteFile: function(data) {
                                $.ajax({
                                    type: "GET",
                                    url: data.url,
                                    data: "id=" + data.id,
                                    beforeSend: function() {
                                        files.setAjaxLoader();
                                    },
                                    success: function() {
                                        list.find('.item[data-key=' + data.id  +']').remove();
                                        info.empty();
                                    }
                                });
                            },
                            setAjaxLoader: function () {
                                info.html('<div class="loading"><span class="glyphicon glyphicon-refresh spin"></span></div>');
                            }
                        };

                    list.find('.item a').on('click', function(e) {
                        e.preventDefault();
                        files.selectItem($(this));
                    });

                    info.on('click', '.btn-delete-file', function(e) {
                        e.preventDefault();
                        files.deleteFile({
                            id : $(this).attr('data-id'),
                            url: $(this).attr('data-action')
                        });
                    });

                    info.on('click', '.btn-cancel', function(e) {
                        e.preventDefault();
                        files.removeSelection();
                        info.empty();
                    });

                    info.on('click', '.btn-insert', function(e) {
                        e.preventDefault();
                        modal.modal('hide');
                        var data = {
                            id: $(this).attr('data-id'),
                            url: $(this).attr('data-url'),
                            thumb_url: $(this).attr('data-thumbnail')
                        };
                        manager.trigger('fileInsert', data);
                    });
                });
            });

            return this;
        };
    });
})(jQuery);